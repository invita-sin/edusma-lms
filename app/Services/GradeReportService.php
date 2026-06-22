<?php

namespace App\Services;

use App\Models\Grade;
use App\Repositories\GradeRepository;
use Illuminate\Support\Collection;

class GradeReportService
{
    public function __construct(
        private readonly GradeRepository $repository,
    ) {}

    public function getStudentReport(int $studentId): Collection
    {
        return $this->repository->getByStudent($studentId);
    }

    public function getCourseReport(int $courseId): Collection
    {
        $grades = $this->repository->getByCourse($courseId);

        $total = $grades->count();
        $passed = $grades->where('grade', '!=', 'E')->count();
        $failed = $grades->where('grade', 'E')->count();

        $average = $total > 0 ? $grades->avg('total_score') : 0;

        return collect([
            'total_students' => $total,
            'passed' => $passed,
            'failed' => $failed,
            'average_score' => round($average, 2),
            'grades' => $grades,
        ]);
    }

    public function getStudentSummary(int $studentId): array
    {
        $grades = $this->repository->getByStudent($studentId);

        $totalCourses = $grades->count();
        $passedCourses = $grades->where('grade', '!=', 'E')->count();
        $averageScore = $totalCourses > 0 ? $grades->avg('total_score') : 0;

        return [
            'total_courses' => $totalCourses,
            'passed_courses' => $passedCourses,
            'average_score' => round($averageScore, 2),
            'grades' => $grades,
        ];
    }
}
