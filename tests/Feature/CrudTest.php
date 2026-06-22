<?php

use App\Models\AcademicYear;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Course;
use App\Models\Grade;
use App\Models\Major;
use App\Models\Material;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use App\Repositories\AcademicYearRepository;
use App\Repositories\AssignmentRepository;
use App\Repositories\AttendanceRepository;
use App\Repositories\ClassroomRepository;
use App\Repositories\CourseRepository;
use App\Repositories\GradeRepository;
use App\Repositories\MajorRepository;
use App\Repositories\MaterialRepository;
use App\Repositories\QuizRepository;
use App\Repositories\SemesterRepository;
use App\Repositories\StudentRepository;
use App\Repositories\SubjectRepository;
use App\Repositories\TeacherRepository;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->artisan('db:seed', ['--class' => 'RoleAndPermissionSeeder']);
    // Seed reference data needed by factories
    Major::factory()->create(['code' => 'IPA', 'name' => 'IPA']);
    Subject::factory()->create();
    AcademicYear::factory()->create();
    Semester::factory()->create();
    Classroom::factory()->create();
});

test('AcademicYear CRUD', function () {
    $repo = app(AcademicYearRepository::class);
    $created = $repo->create([
        'name' => '2025/2026',
        'start_date' => '2025-07-01',
        'end_date' => '2026-06-30',
        'is_active' => true,
    ]);
    expect($created->name)->toBe('2025/2026');
    $found = $repo->findById($created->id);
    expect($found->id)->toBe($created->id);
    $updated = $repo->update($created->id, ['name' => '2026/2027']);
    expect($updated->name)->toBe('2026/2027');
    $repo->delete($created->id);
    expect($repo->findById($created->id))->toBeNull();
});

test('Major CRUD', function () {
    $repo = app(MajorRepository::class);
    $created = $repo->create(['code' => 'MTK', 'name' => 'Matematika']);
    expect($created->code)->toBe('MTK');
    $updated = $repo->update($created->id, ['name' => 'Matematika IPA']);
    expect($updated->name)->toBe('Matematika IPA');
    $repo->delete($created->id);
    expect($repo->findById($created->id))->toBeNull();
});

test('Subject CRUD', function () {
    $repo = app(SubjectRepository::class);
    $created = $repo->create(['code' => 'MTK', 'name' => 'Matematika']);
    expect($created->code)->toBe('MTK');
    $updated = $repo->update($created->id, ['name' => 'Matematika Wajib']);
    expect($updated->name)->toBe('Matematika Wajib');
});

test('Semester CRUD', function () {
    $repo = app(SemesterRepository::class);
    $academicYear = AcademicYear::factory()->create();
    $created = $repo->create([
        'academic_year_id' => $academicYear->id,
        'name' => 'Ganjil',
        'start_date' => '2025-07-01',
        'end_date' => '2025-12-31',
        'is_active' => true,
    ]);
    expect($created->name)->toBe('Ganjil');
    $updated = $repo->update($created->id, ['name' => 'Genap']);
    expect($updated->name)->toBe('Genap');
});

test('Classroom CRUD', function () {
    $repo = app(ClassroomRepository::class);
    $major = Major::factory()->create();
    $created = $repo->create([
        'major_id' => $major->id,
        'name' => 'X-IPA-1',
        'level' => '10',
        'capacity' => 36,
    ]);
    expect($created->name)->toBe('X-IPA-1');
    expect($created->level)->toBe('10');
    $updated = $repo->update($created->id, ['name' => 'X-IPA-2']);
    expect($updated->name)->toBe('X-IPA-2');
});

test('Teacher CRUD', function () {
    $repo = app(TeacherRepository::class);
    $user = User::factory()->create();
    $created = $repo->create([
        'user_id' => $user->id,
        'nip' => '1234567890',
        'gender' => 'L',
        'phone' => '08123456789',
    ]);
    expect($created->nip)->toBe('1234567890');
    $updated = $repo->update($created->id, ['phone' => '08987654321']);
    expect($updated->phone)->toBe('08987654321');
});

test('Student CRUD', function () {
    $repo = app(StudentRepository::class);
    $user = User::factory()->create();
    $classroom = Classroom::factory()->create();
    $created = $repo->create([
        'user_id' => $user->id,
        'nisn' => '1234567890',
        'nis' => '9876543210',
        'classroom_id' => $classroom->id,
        'gender' => 'L',
    ]);
    expect($created->nisn)->toBe('1234567890');
    $updated = $repo->update($created->id, ['nisn' => '0987654321']);
    expect($updated->nisn)->toBe('0987654321');
});

test('Course CRUD', function () {
    $repo = app(CourseRepository::class);
    $academicYear = AcademicYear::factory()->create();
    $semester = Semester::factory()->create();
    $classroom = Classroom::factory()->create();
    $subject = Subject::factory()->create();
    $teacher = Teacher::factory()->create();
    $created = $repo->create([
        'academic_year_id' => $academicYear->id,
        'semester_id' => $semester->id,
        'classroom_id' => $classroom->id,
        'subject_id' => $subject->id,
        'teacher_id' => $teacher->id,
        'code' => 'MTK-X-1',
        'name' => 'Matematika X',
    ]);
    expect($created->code)->toBe('MTK-X-1');
    $updated = $repo->update($created->id, ['name' => 'Matematika X IPA']);
    expect($updated->name)->toBe('Matematika X IPA');
});

test('Assignment CRUD', function () {
    $repo = app(AssignmentRepository::class);
    $course = Course::factory()->create();
    $teacher = Teacher::factory()->create();
    $created = $repo->create([
        'course_id' => $course->id,
        'teacher_id' => $teacher->id,
        'title' => 'Tugas 1',
        'type' => 'essay',
        'max_score' => 100,
        'due_date' => now()->addDays(7),
    ]);
    expect($created->title)->toBe('Tugas 1');
    $updated = $repo->update($created->id, ['title' => 'Tugas 1 Revisi']);
    expect($updated->title)->toBe('Tugas 1 Revisi');
});

test('Material CRUD', function () {
    $repo = app(MaterialRepository::class);
    $course = Course::factory()->create();
    $created = $repo->create([
        'course_id' => $course->id,
        'title' => 'Bab 1',
        'order' => 1,
    ]);
    expect($created->title)->toBe('Bab 1');
    $updated = $repo->update($created->id, ['order' => 2]);
    expect($updated->order)->toBe(2);
});

test('Quiz CRUD', function () {
    $repo = app(QuizRepository::class);
    $course = Course::factory()->create();
    $teacher = Teacher::factory()->create();
    $created = $repo->create([
        'course_id' => $course->id,
        'teacher_id' => $teacher->id,
        'title' => 'Quiz 1',
        'time_limit' => 30,
        'passing_score' => 70,
    ]);
    expect($created->title)->toBe('Quiz 1');
    $updated = $repo->update($created->id, ['time_limit' => 45]);
    expect($updated->time_limit)->toBe(45);
});

test('Attendance CRUD', function () {
    $repo = app(AttendanceRepository::class);
    $course = Course::factory()->create();
    $student = Student::factory()->create();
    $teacher = Teacher::factory()->create();
    $created = $repo->create([
        'course_id' => $course->id,
        'student_id' => $student->id,
        'teacher_id' => $teacher->id,
        'date' => now()->format('Y-m-d'),
        'status' => 'present',
    ]);
    expect($created->status)->toBe('present');
    $updated = $repo->update($created->id, ['status' => 'absent']);
    expect($updated->status)->toBe('absent');
});

test('Grade CRUD', function () {
    $repo = app(GradeRepository::class);
    $course = Course::factory()->create();
    $student = Student::factory()->create();
    $semester = Semester::factory()->create();
    $academicYear = AcademicYear::factory()->create();
    $created = $repo->create([
        'student_id' => $student->id,
        'course_id' => $course->id,
        'academic_year_id' => $academicYear->id,
        'semester_id' => $semester->id,
        'assignment_score' => 85,
        'quiz_score' => 80,
        'midterm_score' => 90,
        'final_exam_score' => 88,
    ]);
    expect((float) $created->assignment_score)->toEqual(85.0);
    $updated = $repo->update($created->id, ['assignment_score' => 90]);
    expect((float) $updated->assignment_score)->toEqual(90.0);
});

test('AssignmentSubmission creation', function () {
    $assignment = Assignment::factory()->create();
    $student = Student::factory()->create();
    $submission = AssignmentSubmission::factory()->create([
        'assignment_id' => $assignment->id,
        'student_id' => $student->id,
    ]);
    expect($submission->assignment_id)->toBe($assignment->id);
});

test('QuizQuestion creation', function () {
    $quiz = Quiz::factory()->create();
    $question = QuizQuestion::factory()->create([
        'quiz_id' => $quiz->id,
    ]);
    expect($question->quiz_id)->toBe($quiz->id);
});
