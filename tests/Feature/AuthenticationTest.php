<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->artisan('db:seed', ['--class' => 'RoleAndPermissionSeeder']);
});

it('can access admin panel login page', function () {
    $response = $this->get('/admin/login');
    $response->assertStatus(200);
});

it('can access teacher panel login page', function () {
    $response = $this->get('/teacher/login');
    $response->assertStatus(200);
});

it('can access student panel login page', function () {
    $response = $this->get('/student/login');
    $response->assertStatus(200);
});

it('can login as super-admin', function () {
    $user = User::firstOrCreate(
        ['email' => 'test@example.com'],
        ['name' => 'Test', 'password' => bcrypt('password')]
    );
    $user->assignRole('super-admin');

    $response = $this->post('/admin/login', [
        'email' => 'test@example.com',
        'password' => 'password',
    ]);
    $response->assertSessionHasNoErrors();
});

it('redirects unauthenticated user from admin', function () {
    $response = $this->get('/admin');
    $response->assertRedirect('/admin/login');
});
