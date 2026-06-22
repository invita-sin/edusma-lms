<?php

namespace App\Filament\Student\Widgets;

use App\Models\AssignmentSubmission;
use App\Models\Course;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class StudentStatsOverview extends StatsOverviewWidget
{
    protected ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return [
                Stat::make('Course', 0),
                Stat::make('Tugas', 0),
                Stat::make('Nilai Rata-rata', 0),
            ];
        }

        $cacheKey = 'student-dashboard-stats-' . $student->id;

        [$courseCount, $submissionCount, $avgScore] = Cache::remember($cacheKey, 300, function () use ($student) {
            $courseCount = Course::where('classroom_id', $student->classroom_id)->count();
            $submissionCount = AssignmentSubmission::where('student_id', $student->id)->count();
            $avgScore = AssignmentSubmission::where('student_id', $student->id)
                ->whereNotNull('score')
                ->avg('score');

            return [$courseCount, $submissionCount, $avgScore ? round($avgScore, 2) : 0];
        });

        return [
            Stat::make('Course Saya', $courseCount)
                ->description('Total course')
                ->icon('heroicon-o-book-open'),
            Stat::make('Tugas Dikerjakan', $submissionCount)
                ->description('Total pengumpulan')
                ->icon('heroicon-o-clipboard-document-check'),
            Stat::make('Rata-rata Nilai', $avgScore ? round($avgScore, 2) : 0)
                ->description('Dari tugas yang dinilai')
                ->icon('heroicon-o-academic-cap'),
        ];
    }
}
