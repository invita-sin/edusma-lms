<?php

namespace App\Repositories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;

class StudentRepository
{
    public function all(): Collection
    {
        return Student::with('user', 'classroom')->get();
    }

    public function findById(int $id): ?Student
    {
        return Student::with('user', 'classroom')->find($id);
    }

    public function findByNisn(string $nisn): ?Student
    {
        return Student::where('nisn', $nisn)->first();
    }

    public function findByUserId(int $userId): ?Student
    {
        return Student::where('user_id', $userId)->first();
    }

    public function create(array $data): Student
    {
        return Student::create($data);
    }

    public function update(int $id, array $data): Student
    {
        $student = Student::findOrFail($id);
        $student->update($data);
        return $student;
    }

    public function delete(int $id): void
    {
        Student::destroy($id);
    }

    public function getByClassroom(int $classroomId): Collection
    {
        return Student::where('classroom_id', $classroomId)->with('user')->get();
    }
}
