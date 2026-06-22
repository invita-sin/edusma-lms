<?php

namespace App\Repositories;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Collection;

class TeacherRepository
{
    public function all(): Collection
    {
        return Teacher::with('user')->get();
    }

    public function findById(int $id): ?Teacher
    {
        return Teacher::with('user')->find($id);
    }

    public function findByNip(string $nip): ?Teacher
    {
        return Teacher::where('nip', $nip)->first();
    }

    public function findByUserId(int $userId): ?Teacher
    {
        return Teacher::where('user_id', $userId)->first();
    }

    public function create(array $data): Teacher
    {
        return Teacher::create($data);
    }

    public function update(int $id, array $data): Teacher
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->update($data);
        return $teacher;
    }

    public function delete(int $id): void
    {
        Teacher::destroy($id);
    }
}
