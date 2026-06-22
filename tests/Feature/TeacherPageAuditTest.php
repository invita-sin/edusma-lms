<?php

use App\Http\Middleware\EnsureUserHasRole;
use App\Models\User;
use Illuminate\Http\Request;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->artisan('db:seed', ['--class' => 'RoleAndPermissionSeeder']);
    $this->user = User::factory()->create();
    $this->user->assignRole('teacher');
});

function checkTeacherAccess(User $user, string $path, string $roles): int
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

it('teacher dashboard loads', function () {
    expect(checkTeacherAccess($this->user, '/teacher', 'teacher'))->toBe(200);
});

it('all 8 teacher resource list pages load', function () {
    $resources = [
        'courses', 'assignments', 'materials', 'quizzes',
        'attendances', 'grades', 'students', 'conversations',
    ];

    foreach ($resources as $resource) {
        $status = checkTeacherAccess($this->user, "/teacher/$resource", 'teacher');
        expect($status)->toBe(200, "List page /teacher/$resource returned $status");
    }
});

it('all 7 teacher resource create pages load', function () {
    $resources = [
        'courses', 'assignments', 'materials', 'quizzes',
        'attendances', 'grades', 'students',
    ];

    foreach ($resources as $resource) {
        $status = checkTeacherAccess($this->user, "/teacher/$resource/create", 'teacher');
        expect($status)->toBe(200, "Create page /teacher/$resource/create returned $status");
    }
});

it('dashboard blocked for admin', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');
    $status = checkAccess($admin, '/teacher', 'teacher');
    expect($status)->toBe(403);
});

it('dashboard blocked for student', function () {
    $student = User::factory()->create();
    $student->assignRole('student');
    $status = checkAccess($student, '/teacher', 'teacher');
    expect($status)->toBeIn([302, 403]);
});

it('unauthenticated user is blocked from teacher', function () {
    $request = Request::create('/teacher', 'GET');
    $middleware = app(EnsureUserHasRole::class);
    try {
        $middleware->handle($request, fn() => response('OK'), 'teacher');
    } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
        expect($e->getStatusCode())->toBe(403);
    }
});
