<?php

namespace App\Repositories;

use App\Models\Assignment;
use Illuminate\Database\Eloquent\Collection;

class AssignmentRepository
{
    public function all(): Collection
    {
        return Assignment::with('course', 'teacher.user')->get();
    }

    public function findById(int $id): ?Assignment
    {
        return Assignment::with('course', 'teacher.user', 'submissions.student.user')->find($id);
    }

    public function create(array $data): Assignment
    {
        return Assignment::create($data);
    }

    public function update(int $id, array $data): Assignment
    {
        $assignment = Assignment::findOrFail($id);
        $assignment->update($data);
        return $assignment;
    }

    public function delete(int $id): void
    {
        Assignment::destroy($id);
    }

    public function getByCourse(int $courseId): Collection
    {
        return Assignment::where('course_id', $courseId)->with('teacher.user')->get();
    }

    public function getByTeacher(int $teacherId): Collection
    {
        return Assignment::where('teacher_id', $teacherId)->with('course')->get();
    }
}
