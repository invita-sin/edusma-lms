<?php

namespace App\Repositories;

use App\Models\Grade;
use Illuminate\Database\Eloquent\Collection;

class GradeRepository
{
    public function all(): Collection
    {
        return Grade::with('student.user', 'course', 'semester')->get();
    }

    public function findById(int $id): ?Grade
    {
        return Grade::with('student.user', 'course', 'semester', 'academicYear')->find($id);
    }

    public function create(array $data): Grade
    {
        return Grade::create($data);
    }

    public function update(int $id, array $data): Grade
    {
        $grade = Grade::findOrFail($id);
        $grade->update($data);
        return $grade;
    }

    public function delete(int $id): void
    {
        Grade::destroy($id);
    }

    public function getByStudent(int $studentId): Collection
    {
        return Grade::where('student_id', $studentId)
            ->with('course', 'semester', 'academicYear')
            ->get();
    }

    public function getByCourse(int $courseId): Collection
    {
        return Grade::where('course_id', $courseId)
            ->with('student.user')
            ->get();
    }

    public function findByStudentAndCourse(int $studentId, int $courseId, int $semesterId): ?Grade
    {
        return Grade::where('student_id', $studentId)
            ->where('course_id', $courseId)
            ->where('semester_id', $semesterId)
            ->first();
    }
}
