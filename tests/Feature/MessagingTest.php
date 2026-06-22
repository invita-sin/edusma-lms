<?php

use App\Models\Conversation;
use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Services\ConversationService;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->artisan('db:seed');
});

it('can send message from teacher to student', function () {
    $teacher = Teacher::first();
    $student = Student::first();
    $course = Course::first();

    if (!$teacher || !$student || !$course) {
        $this->markTestSkipped('Seed data not available — run db:seed first');
        return;
    }

    $this->actingAs($teacher->user);

    $service = app(ConversationService::class);
    $conversation = $service->findOrCreate($course->id, $teacher->id, $student->id);
    $message = $service->sendMessage($conversation, 'Hello student', 'teacher');

    expect($message)->not->toBeNull();
    expect($message->message)->toBe('Hello student');
    expect($message->sender_type)->toBe('teacher');
});

it('can send message from student to teacher', function () {
    $teacher = Teacher::first();
    $student = Student::first();
    $course = Course::first();

    if (!$teacher || !$student || !$course) {
        $this->markTestSkipped('Seed data not available');
        return;
    }

    $service = app(ConversationService::class);
    $conversation = $service->findOrCreate($course->id, $teacher->id, $student->id);

    $this->actingAs($student->user);
    $message = $service->sendMessage($conversation, 'Hello teacher', 'student');

    expect($message)->not->toBeNull();
    expect($message->message)->toBe('Hello teacher');
    expect($message->sender_type)->toBe('student');
});

it('can mark messages as read', function () {
    $teacher = Teacher::first();
    $student = Student::first();
    $course = Course::first();

    if (!$teacher || !$student || !$course) {
        $this->markTestSkipped('Seed data not available');
        return;
    }

    $this->actingAs($teacher->user);
    $conversation = app(ConversationService::class)->findOrCreate($course->id, $teacher->id, $student->id);
    app(ConversationService::class)->sendMessage($conversation, 'Test', 'teacher');

    $this->actingAs($student->user);
    app(ConversationService::class)->markAsRead($conversation);

    expect($conversation->messages()->where('is_read', true)->count())->toBe(1);
});

it('teacher can access conversation resource list', function () {
    $teacher = Teacher::first();
    if (!$teacher) {
        $this->markTestSkipped('Seed data not available');
        return;
    }

    $this->actingAs($teacher->user);
    $response = $this->get('/teacher/conversations');
    $response->assertStatus(200);
});

it('student can access conversation resource list', function () {
    $student = Student::first();
    if (!$student) {
        $this->markTestSkipped('Seed data not available');
        return;
    }

    $this->actingAs($student->user);
    $response = $this->get('/student/conversations');
    $response->assertStatus(200);
});

it('reports route requires role middleware', function () {
    $student = Student::first();
    if (!$student) {
        $this->markTestSkipped('Seed data not available');
        return;
    }

    $this->actingAs($student->user);
    $response = $this->get(route('reports.grades.pdf'));
    $response->assertStatus(403);
});

it('super admin can access report route', function () {
    $user = User::where('email', 'admin@edusma.sch.id')->first();
    if (!$user) {
        $this->markTestSkipped('Seed data not available');
        return;
    }

    $this->actingAs($user);
    $response = $this->get(route('reports.students.export'));
    $response->assertStatus(200);
});

it('returns unread count correctly', function () {
    $teacher = Teacher::first();
    $student = Student::first();
    $course = Course::first();

    if (!$teacher || !$student || !$course) {
        $this->markTestSkipped('Seed data not available');
        return;
    }

    $this->actingAs($teacher->user);
    $conversation = app(ConversationService::class)->findOrCreate($course->id, $teacher->id, $student->id);
    app(ConversationService::class)->sendMessage($conversation, 'Pesan untuk murid', 'teacher');

    $count = app(ConversationService::class)->getUnreadCount($student->user->id, studentId: $student->id);
    expect($count)->toBe(1);
});
