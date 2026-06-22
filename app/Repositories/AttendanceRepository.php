<?php

namespace App\Repositories;

use App\Models\Attendance;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class AttendanceRepository
{
    public function all(): Collection
    {
        return Attendance::with('course', 'student.user')->get();
    }

    public function findById(int $id): ?Attendance
    {
        return Attendance::with('course', 'student.user')->find($id);
    }

    public function create(array $data): Attendance
    {
        return Attendance::create($data);
    }

    public function createOrUpdate(array $data): Attendance
    {
        return Attendance::updateOrCreate(
            [
                'course_id' => $data['course_id'],
                'student_id' => $data['student_id'],
                'date' => $data['date'],
            ],
            $data
        );
    }

    public function update(int $id, array $data): Attendance
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->update($data);
        return $attendance;
    }

    public function delete(int $id): void
    {
        Attendance::destroy($id);
    }

    public function getByCourseAndDate(int $courseId, Carbon $date): Collection
    {
        return Attendance::where('course_id', $courseId)
            ->where('date', $date->toDateString())
            ->with('student.user')
            ->get();
    }

    public function getByStudent(int $studentId): Collection
    {
        return Attendance::where('student_id', $studentId)
            ->with('course')
            ->orderBy('date', 'desc')
            ->get();
    }
}
