<?php

use App\Http\Middleware\EnsureUserHasRole;
use App\Models\User;
use Illuminate\Http\Request;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->artisan('db:seed', ['--class' => 'RoleAndPermissionSeeder']);
});

function checkPageAccess(User $user, string $path, string $requiredRoles): int
{
    $request = Request::create($path, 'GET');
    $request->setUserResolver(fn() => $user);

    $middleware = app(EnsureUserHasRole::class);

    try {
        $response = $middleware->handle($request, fn() => response('OK'), $requiredRoles);
        return $response->getStatusCode();
    } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
        return $e->getStatusCode();
    }
}

it('teacher can access teacher pages', function () {
    $user = User::factory()->create();
    $user->assignRole('teacher');

    expect(checkPageAccess($user, '/teacher', 'teacher'))->toBe(200);
    expect(checkPageAccess($user, '/teacher/courses', 'teacher'))->toBe(200);
    expect(checkPageAccess($user, '/teacher/assignments', 'teacher'))->toBe(200);
    expect(checkPageAccess($user, '/teacher/materials', 'teacher'))->toBe(200);
    expect(checkPageAccess($user, '/teacher/quizzes', 'teacher'))->toBe(200);
    expect(checkPageAccess($user, '/teacher/attendances', 'teacher'))->toBe(200);
    expect(checkPageAccess($user, '/teacher/grades', 'teacher'))->toBe(200);
    expect(checkPageAccess($user, '/teacher/students', 'teacher'))->toBe(200);
});

it('student can access student pages', function () {
    $user = User::factory()->create();
    $user->assignRole('student');
    App\Models\Student::factory()->create(['user_id' => $user->id]);

    expect(checkPageAccess($user, '/student', 'student'))->toBe(200);
    expect(checkPageAccess($user, '/student/courses', 'student'))->toBe(200);
    expect(checkPageAccess($user, '/student/assignments', 'student'))->toBe(200);
    expect(checkPageAccess($user, '/student/materials', 'student'))->toBe(200);
    expect(checkPageAccess($user, '/student/quizzes', 'student'))->toBe(200);
    expect(checkPageAccess($user, '/student/grades', 'student'))->toBe(200);
    expect(checkPageAccess($user, '/student/attendances', 'student'))->toBe(200);
});
