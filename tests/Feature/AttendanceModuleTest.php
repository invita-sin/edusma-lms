<?php

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use App\Services\AttendanceService;
use App\Services\AttendanceReportService;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->artisan('db:seed', ['--class' => 'RoleAndPermissionSeeder']);
});

it('can record attendance', function () {
    $course = Course::factory()->create();
    $student = Student::factory()->create();
    $teacher = Teacher::factory()->create();
    $service = app(AttendanceService::class);

    $dto = new \App\DTOs\CreateAttendanceDTO(
        courseId: $course->id,
        studentId: $student->id,
        teacherId: $teacher->id,
        date: now(),
        status: 'present',
    );

    $attendance = $service->record($dto);
    expect($attendance->status)->toBe('present');
});

it('can record bulk attendance', function () {
    $course = Course::factory()->create();
    $teacher = Teacher::factory()->create();
    $students = Student::factory()->count(3)->create();
    $service = app(AttendanceService::class);

    $attendances = $students->map(fn($s) => [
        'student_id' => $s->id,
        'status' => 'present',
    ])->toArray();

    $service->recordBulk($course->id, $teacher->id, now(), $attendances);

    $count = Attendance::where('course_id', $course->id)->count();
    expect($count)->toBe(3);
});

it('generates attendance report for student', function () {
    $student = Student::factory()->create();
    Attendance::factory()->count(5)->create([
        'student_id' => $student->id,
        'status' => 'present',
    ]);
    Attendance::factory()->create([
        'student_id' => $student->id,
        'status' => 'absent',
    ]);

    $service = app(AttendanceReportService::class);
    $report = $service->getStudentReport($student->id);

    expect($report['total'])->toBe(6)
        ->and($report['present'])->toBe(5)
        ->and($report['absent'])->toBe(1);
});
