<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->artisan('db:seed');
});

it('student can view their courses page', function () {
    $student = \App\Models\Student::first();
    $response = $this->actingAs($student->user)->get('/student/courses');
    $response->assertStatus(200);
});

it('student can view their materials page', function () {
    $student = \App\Models\Student::first();
    $response = $this->actingAs($student->user)->get('/student/materials');
    $response->assertStatus(200);
});

it('student can view their assignments page', function () {
    $student = \App\Models\Student::first();
    $response = $this->actingAs($student->user)->get('/student/assignments');
    $response->assertStatus(200);
});

it('student can view their grades page', function () {
    $student = \App\Models\Student::first();
    $response = $this->actingAs($student->user)->get('/student/grades');
    $response->assertStatus(200);
});

it('student can view their quizzes page', function () {
    $student = \App\Models\Student::first();
    $response = $this->actingAs($student->user)->get('/student/quizzes');
    $response->assertStatus(200);
});

it('student can view their attendances page', function () {
    $student = \App\Models\Student::first();
    $response = $this->actingAs($student->user)->get('/student/attendances');
    $response->assertStatus(200);
});

it('student can view their conversations page', function () {
    $student = \App\Models\Student::first();
    $response = $this->actingAs($student->user)->get('/student/conversations');
    $response->assertStatus(200);
});

it('student dashboard is accessible', function () {
    $student = \App\Models\Student::first();
    $response = $this->actingAs($student->user)->get('/student');
    $response->assertStatus(200);
});
