<?php

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->artisan('db:seed', ['--class' => 'RoleAndPermissionSeeder']);
});

it('can create an assignment via service', function () {
    $teacher = Teacher::factory()->create();
    $course = Course::factory()->create();
    $service = app(\App\Services\AssignmentService::class);

    $dto = new \App\DTOs\CreateAssignmentDTO(
        courseId: $course->id,
        teacherId: $teacher->id,
        title: 'Test Tugas',
        description: 'Deskripsi tugas',
        filePath: null,
        type: 'essay',
        maxScore: 100,
        dueDate: now()->addDays(7),
    );

    $assignment = $service->create($dto);
    expect($assignment)->toBeInstanceOf(Assignment::class)
        ->and($assignment->title)->toBe('Test Tugas');
});

it('can submit an assignment', function () {
    $assignment = Assignment::factory()->create();
    $student = Student::factory()->create();
    $service = app(\App\Services\AssignmentService::class);

    $dto = new \App\DTOs\CreateSubmissionDTO(
        assignmentId: $assignment->id,
        studentId: $student->id,
        content: 'Jawaban siswa',
    );

    $submission = $service->submit($assignment->id, $dto);
    expect($submission->content)->toBe('Jawaban siswa');
});

it('can grade a submission', function () {
    $assignment = Assignment::factory()->create();
    $student = Student::factory()->create();
    $submission = \App\Models\AssignmentSubmission::factory()->create([
        'assignment_id' => $assignment->id,
        'student_id' => $student->id,
    ]);

    $service = app(\App\Services\AssignmentService::class);
    $dto = new \App\DTOs\GradeSubmissionDTO(score: 85, feedback: 'Bagus');

    $graded = $service->grade($submission->id, $dto);
    expect($graded->score)->toBe(85)
        ->and($graded->feedback)->toBe('Bagus');
});
