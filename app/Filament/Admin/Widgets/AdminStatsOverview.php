<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;

class AdminStatsOverview extends StatsOverviewWidget
{
    protected ?string $pollingInterval = null;

    protected function getStats(): array
    {
        return Cache::remember('admin-dashboard-stats', 300, function () {
            return [
                Stat::make('Total Guru', Teacher::count())
                    ->description('Jumlah guru terdaftar')
                    ->icon('heroicon-o-user-group'),
                Stat::make('Total Siswa', Student::count())
                    ->description('Jumlah siswa terdaftar')
                    ->icon('heroicon-o-users'),
                Stat::make('Total Course', Course::count())
                    ->description('Jumlah mata pelajaran')
                    ->icon('heroicon-o-book-open'),
            ];
        });
    }
}
