<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentActivitiesWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                AssignmentSubmission::query()
                    ->with('assignment', 'student.user')
                    ->whereNotNull('submitted_at')
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('student.user.name')
                    ->label('Siswa'),
                TextColumn::make('assignment.title')
                    ->label('Tugas'),
                TextColumn::make('submitted_at')
                    ->label('Dikumpulkan')
                    ->dateTime(),
                TextColumn::make('score')
                    ->label('Nilai'),
            ]);
    }
}
