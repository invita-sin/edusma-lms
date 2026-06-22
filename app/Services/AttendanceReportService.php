<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Student;
use App\Repositories\AttendanceRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class AttendanceReportService
{
    public function __construct(
        private readonly AttendanceRepository $repository,
    ) {}

    public function getStudentReport(int $studentId, ?int $courseId = null, ?string $startDate = null, ?string $endDate = null): array
    {
        $query = Attendance::where('student_id', $studentId);

        if ($courseId) $query->where('course_id', $courseId);
        if ($startDate) $query->whereDate('date', '>=', $startDate);
        if ($endDate) $query->whereDate('date', '<=', $endDate);

        $stats = (clone $query)
            ->selectRaw("COUNT(*) as total")
            ->selectRaw("SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present")
            ->selectRaw("SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) as absent")
            ->selectRaw("SUM(CASE WHEN status = 'sick' THEN 1 ELSE 0 END) as sick")
            ->selectRaw("SUM(CASE WHEN status = 'permission' THEN 1 ELSE 0 END) as permission")
            ->selectRaw("SUM(CASE WHEN status = 'late' THEN 1 ELSE 0 END) as late")
            ->first();

        return [
            'student_id' => $studentId,
            'total' => (int) ($stats->total ?? 0),
            'present' => (int) ($stats->present ?? 0),
            'absent' => (int) ($stats->absent ?? 0),
            'sick' => (int) ($stats->sick ?? 0),
            'permission' => (int) ($stats->permission ?? 0),
            'late' => (int) ($stats->late ?? 0),
        ];
    }

    public function getCourseReport(int $courseId, ?Carbon $startDate = null, ?Carbon $endDate = null): Collection
    {
        $query = Attendance::where('course_id', $courseId);

        if ($startDate) {
            $query->where('date', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('date', '<=', $endDate);
        }

        return $query->with('student.user')
            ->get()
            ->groupBy('student_id')
            ->map(function ($attendances, $studentId) {
                $total = $attendances->count();
                $present = $attendances->where('status', 'present')->count();
                return [
                    'student' => $attendances->first()->student,
                    'total' => $total,
                    'present' => $present,
                    'percentage' => $total > 0 ? round(($present / $total) * 100, 2) : 0,
                ];
            })
            ->values();
    }
}
