<?php

namespace App\Repositories;

use App\Models\AcademicYear;
use Illuminate\Database\Eloquent\Collection;

class AcademicYearRepository
{
    public function all(): Collection
    {
        return AcademicYear::all();
    }

    public function findById(int $id): ?AcademicYear
    {
        return AcademicYear::find($id);
    }

    public function create(array $data): AcademicYear
    {
        return AcademicYear::create($data);
    }

    public function update(int $id, array $data): AcademicYear
    {
        $academicYear = AcademicYear::findOrFail($id);
        $academicYear->update($data);
        return $academicYear;
    }

    public function delete(int $id): void
    {
        AcademicYear::destroy($id);
    }

    public function getActive(): ?AcademicYear
    {
        return AcademicYear::where('is_active', true)->first();
    }

    public function deactivateAll(): void
    {
        AcademicYear::where('is_active', true)->update(['is_active' => false]);
    }
}
