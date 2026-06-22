<?php

use App\Models\AcademicYear;
use App\Models\User;
use App\Repositories\AcademicYearRepository;
use App\Services\AcademicYearService;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->artisan('db:seed', ['--class' => 'RoleAndPermissionSeeder']);
});

it('can create academic year via service', function () {
    $service = app(AcademicYearService::class);
    $dto = new \App\DTOs\CreateAcademicYearDTO(
        name: '2025/2026',
        startDate: now()->subYear(),
        endDate: now()->addYear(),
        isActive: true,
    );
    $academicYear = $service->create($dto);
    expect($academicYear)->toBeInstanceOf(AcademicYear::class)
        ->and($academicYear->name)->toBe('2025/2026');
});

it('can find academic year by id', function () {
    $year = AcademicYear::factory()->create();
    $service = app(AcademicYearService::class);
    $found = $service->findById($year->id);
    expect($found->id)->toBe($year->id);
});

it('can get active academic year', function () {
    AcademicYear::factory()->create(['is_active' => true]);
    $service = app(AcademicYearService::class);
    $active = $service->getActive();
    expect($active)->not->toBeNull()
        ->and($active->is_active)->toBeTrue();
});
