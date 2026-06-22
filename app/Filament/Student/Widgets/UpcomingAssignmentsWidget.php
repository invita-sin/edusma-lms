<?php

namespace App\Filament\Student\Widgets;

use App\Models\Assignment;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class UpcomingAssignmentsWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $student = Auth::user()->student;

        return $table
            ->query(
                Assignment::query()
                    ->with('course', 'teacher.user')
                    ->whereIn('course_id', function ($q) use ($student) {
                        $q->select('id')->from('courses')
                            ->where('classroom_id', $student->classroom_id);
                    })
                    ->where('due_date', '>=', now())
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('title')
                    ->label('Tugas'),
                TextColumn::make('course.name')
                    ->label('Course'),
                TextColumn::make('due_date')
                    ->label('Batas')
                    ->dateTime(),
            ]);
    }
}
