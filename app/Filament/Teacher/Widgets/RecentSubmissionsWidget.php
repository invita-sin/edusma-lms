<?php

namespace App\Filament\Teacher\Widgets;

use App\Models\AssignmentSubmission;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class RecentSubmissionsWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $teacher = Auth::user()->teacher;

        return $table
            ->query(
                AssignmentSubmission::query()
                    ->with('assignment', 'student.user')
                    ->whereIn('assignment_id', function ($q) use ($teacher) {
                        $q->select('id')->from('assignments')->where('teacher_id', $teacher->id);
                    })
                    ->whereNull('score')
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
            ]);
    }
}
