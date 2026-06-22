<?php

namespace App\Repositories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;

class CourseRepository
{
    public function all(): Collection
    {
        return Course::with('academicYear', 'semester', 'classroom', 'subject', 'teacher.user')->get();
    }

    public function findById(int $id): ?Course
    {
        return Course::with('academicYear', 'semester', 'classroom', 'subject', 'teacher.user')->find($id);
    }

    public function findByCode(string $code): ?Course
    {
        return Course::where('code', $code)->first();
    }

    public function create(array $data): Course
    {
        return Course::create($data);
    }

    public function update(int $id, array $data): Course
    {
        $course = Course::findOrFail($id);
        $course->update($data);
        return $course;
    }

    public function delete(int $id): void
    {
        Course::destroy($id);
    }

    public function getByTeacher(int $teacherId): Collection
    {
        return Course::where('teacher_id', $teacherId)
            ->with('academicYear', 'semester', 'classroom', 'subject')
            ->get();
    }

    public function getByClassroom(int $classroomId): Collection
    {
        return Course::where('classroom_id', $classroomId)
            ->with('academicYear', 'semester', 'subject', 'teacher.user')
            ->get();
    }

    public function getByAcademicYear(int $academicYearId): Collection
    {
        return Course::where('academic_year_id', $academicYearId)
            ->with('classroom', 'subject', 'teacher.user')
            ->get();
    }
}
