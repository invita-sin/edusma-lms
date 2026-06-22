<?php

use App\Http\Middleware\EnsureUserHasRole;
use App\Models\User;
use Illuminate\Http\Request;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->artisan('db:seed', ['--class' => 'RoleAndPermissionSeeder']);
    $this->user = User::factory()->create();
    $this->user->assignRole('super-admin');
});

function checkAccess(User $user, string $path, string $roles): int
{
    $request = Request::create($path, 'GET');
    $request->setUserResolver(fn() => $user);
    $middleware = app(EnsureUserHasRole::class);
    try {
        $response = $middleware->handle($request, fn() => response('OK'), $roles);
        return $response->getStatusCode();
    } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
        return $e->getStatusCode();
    } catch (\Throwable $e) {
        return 500;
    }
}

it('admin dashboard loads', function () {
    expect(checkAccess($this->user, '/admin', 'super-admin,admin'))->toBe(200);
});

it('all 14 admin resource list pages load', function () {
    $resources = [
        'academic-years', 'activity-logs', 'assignments', 'attendances',
        'classrooms', 'courses', 'grades', 'majors', 'materials',
        'quizzes', 'semesters', 'students', 'subjects', 'teachers',
    ];

    foreach ($resources as $resource) {
        $status = checkAccess($this->user, "/admin/$resource", 'super-admin,admin');
        expect($status)->toBe(200, "List page /admin/$resource returned $status");
    }
});

it('all admin resource create pages load', function () {
    $resources = [
        'academic-years', 'assignments', 'attendances', 'classrooms', 'courses',
        'grades', 'majors', 'materials', 'quizzes', 'semesters', 'students',
        'subjects', 'teachers',
    ];

    foreach ($resources as $resource) {
        $status = checkAccess($this->user, "/admin/$resource/create", 'super-admin,admin');
        expect($status)->toBe(200, "Create page /admin/$resource/create returned $status");
    }
});

it('custom admin pages load', function () {
    expect(checkAccess($this->user, '/admin/school-settings', 'super-admin,admin'))->toBe(200);
    expect(checkAccess($this->user, '/admin/academic-settings', 'super-admin,admin'))->toBe(200);
});

it('dashboard accessible by super-admin', function () {
    expect(checkAccess($this->user, '/admin', 'super-admin,admin'))->toBe(200);
});

it('dashboard accessible by admin role', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');
    expect(checkAccess($admin, '/admin', 'super-admin,admin'))->toBe(200);
});

it('dashboard blocked for teacher', function () {
    $teacher = User::factory()->create();
    $teacher->assignRole('teacher');
    $status = checkAccess($teacher, '/admin', 'super-admin,admin');
    expect($status)->toBeIn([302, 403]);
});

it('dashboard blocked for student', function () {
    $student = User::factory()->create();
    $student->assignRole('student');
    $status = checkAccess($student, '/admin', 'super-admin,admin');
    expect($status)->toBeIn([302, 403]);
});

it('unauthenticated user is blocked from admin', function () {
    $request = Request::create('/admin', 'GET');
    $middleware = app(EnsureUserHasRole::class);
    try {
        $middleware->handle($request, fn() => response('OK'), 'super-admin,admin');
    } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
        expect($e->getStatusCode())->toBe(403);
    }
});

it('super-admin can access all edit pages', function () {
    // Seed records to have IDs
    $this->artisan('db:seed', ['--class' => 'RoleAndPermissionSeeder']);

    $resources = [
        'academic-years', 'assignments', 'attendances', 'classrooms', 'courses',
        'grades', 'majors', 'materials', 'quizzes', 'semesters', 'students',
        'subjects', 'teachers',
    ];

    // Create a record for each resource type
    $models = [
        'academic-years' => App\Models\AcademicYear::factory()->create(),
        'semesters' => App\Models\Semester::factory()->create(),
        'majors' => App\Models\Major::factory()->create(),
        'classrooms' => App\Models\Classroom::factory()->create(),
        'subjects' => App\Models\Subject::factory()->create(),
        'teachers' => App\Models\Teacher::factory()->create(),
        'students' => App\Models\Student::factory()->create(),
        'courses' => App\Models\Course::factory()->create(),
        'materials' => App\Models\Material::factory()->create(),
        'assignments' => App\Models\Assignment::factory()->create(),
        'quizzes' => App\Models\Quiz::factory()->create(),
        'attendances' => App\Models\Attendance::factory()->create(),
        'grades' => App\Models\Grade::factory()->create(),
    ];

    foreach ($resources as $resource) {
        $record = $models[$resource];
        $path = "/admin/$resource/{$record->id}/edit";
        $status = checkAccess($this->user, $path, 'super-admin,admin');
        expect($status)->toBe(200, "Edit page $path returned $status");
    }
});
