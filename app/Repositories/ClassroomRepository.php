<?php

namespace App\Repositories;

use App\Models\Classroom;
use Illuminate\Database\Eloquent\Collection;

class ClassroomRepository
{
    public function all(): Collection
    {
        return Classroom::with('major')->get();
    }

    public function findById(int $id): ?Classroom
    {
        return Classroom::with('major')->find($id);
    }

    public function create(array $data): Classroom
    {
        return Classroom::create($data);
    }

    public function update(int $id, array $data): Classroom
    {
        $classroom = Classroom::findOrFail($id);
        $classroom->update($data);
        return $classroom;
    }

    public function delete(int $id): void
    {
        Classroom::destroy($id);
    }

    public function getByMajor(int $majorId): Collection
    {
        return Classroom::where('major_id', $majorId)->with('major')->get();
    }

    public function getByLevel(string $level): Collection
    {
        return Classroom::where('level', $level)->with('major')->get();
    }
}
