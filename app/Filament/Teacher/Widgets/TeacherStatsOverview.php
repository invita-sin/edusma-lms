<?php

namespace App\Filament\Teacher\Widgets;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Course;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TeacherStatsOverview extends StatsOverviewWidget
{
    protected ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        if (!$teacher) {
            return [
                Stat::make('Course', 0),
                Stat::make('Tugas Aktif', 0),
                Stat::make('Pengumpulan', 0),
            ];
        }

        $cacheKey = 'teacher-dashboard-stats-' . $teacher->id;

        [$courseCount, $assignmentCount, $submissionCount] = Cache::remember($cacheKey, 300, function () use ($teacher) {
            $courseCount = Course::where('teacher_id', $teacher->id)->count();
            $assignmentCount = Assignment::where('teacher_id', $teacher->id)->count();
            $submissionCount = AssignmentSubmission::whereIn('assignment_id',
                Assignment::where('teacher_id', $teacher->id)->select('id')
            )->count();

            return [$courseCount, $assignmentCount, $submissionCount];
        });

        return [
            Stat::make('Course Saya', $courseCount)
                ->description('Total course yang diajar')
                ->icon('heroicon-o-book-open'),
            Stat::make('Tugas Dibuat', $assignmentCount)
                ->description('Total tugas')
                ->icon('heroicon-o-clipboard-document-list'),
            Stat::make('Pengumpulan', $submissionCount)
                ->description('Total jawaban siswa')
                ->icon('heroicon-o-inbox-arrow-down'),
        ];
    }
}
