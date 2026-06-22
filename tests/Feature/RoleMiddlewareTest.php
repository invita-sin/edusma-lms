<?php

use App\Http\Middleware\EnsureUserHasRole;
use App\Models\User;
use Illuminate\Http\Request;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->artisan('db:seed', ['--class' => 'RoleAndPermissionSeeder']);
});

function runMiddleware(User $user, string $path, string $requiredRoles): int
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

it('allows super-admin on admin panel', function () {
    $user = User::factory()->create();
    $user->assignRole('super-admin');

    $status = runMiddleware($user, '/admin', 'super-admin,admin');

    expect($status)->toBe(200);
});

it('allows admin on admin panel', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');

    $status = runMiddleware($user, '/admin', 'super-admin,admin');

    expect($status)->toBe(200);
});

it('blocks teacher from admin panel', function () {
    $user = User::factory()->create();
    $user->assignRole('teacher');

    $status = runMiddleware($user, '/admin', 'super-admin,admin');

    // Redirects to teacher login because middleware has special redirect logic
    expect($status)->toBe(302);
});

it('allows teacher on teacher panel', function () {
    $user = User::factory()->create();
    $user->assignRole('teacher');

    $status = runMiddleware($user, '/teacher', 'teacher');

    expect($status)->toBe(200);
});

it('blocks admin from teacher panel', function () {
    $user = User::factory()->create();
    $user->assignRole('admin');

    $status = runMiddleware($user, '/teacher', 'teacher');

    expect($status)->toBe(403);
});

it('blocks student from teacher panel', function () {
    $user = User::factory()->create();
    $user->assignRole('student');

    $status = runMiddleware($user, '/teacher', 'teacher');

    // Redirects to student login because middleware has special redirect logic
    expect($status)->toBe(302);
});

it('allows student on student panel', function () {
    $user = User::factory()->create();
    $user->assignRole('student');

    $status = runMiddleware($user, '/student', 'student');

    expect($status)->toBe(200);
});

it('blocks teacher from student panel', function () {
    $user = User::factory()->create();
    $user->assignRole('teacher');

    $status = runMiddleware($user, '/student', 'student');

    // Redirects to teacher login because middleware has special redirect logic
    expect($status)->toBe(302);
});
