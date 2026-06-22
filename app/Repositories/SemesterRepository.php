<?php

namespace App\Repositories;

use App\Models\Semester;
use Illuminate\Database\Eloquent\Collection;

class SemesterRepository
{
    public function all(): Collection
    {
        return Semester::with('academicYear')->get();
    }

    public function findById(int $id): ?Semester
    {
        return Semester::with('academicYear')->find($id);
    }

    public function create(array $data): Semester
    {
        return Semester::create($data);
    }

    public function update(int $id, array $data): Semester
    {
        $semester = Semester::findOrFail($id);
        $semester->update($data);
        return $semester;
    }

    public function delete(int $id): void
    {
        Semester::destroy($id);
    }

    public function getActive(): ?Semester
    {
        return Semester::where('is_active', true)->with('academicYear')->first();
    }

    public function deactivateAll(): void
    {
        Semester::where('is_active', true)->update(['is_active' => false]);
    }

    public function getByAcademicYear(int $academicYearId): Collection
    {
        return Semester::where('academic_year_id', $academicYearId)->get();
    }
}
