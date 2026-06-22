<?php

namespace App\Filament\Student\Resources;

use App\Filament\Student\Resources\GradeResource\Pages;
use App\Models\Grade;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use BackedEnum;
use UnitEnum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class GradeResource extends Resource
{
    protected static ?string $model = Grade::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-academic-cap';

    protected static string | UnitEnum | null $navigationGroup = 'Akademik';

    protected static ?int $navigationSort = 5;

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $student = Auth::user()->student;
        return parent::getEloquentQuery()->when($student, fn($q) => $q->where('student_id', $student->id));
    }

    public static function form(Schema $schema): Schema
    {
        return $schema;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('course.name')
                    ->label('Course')
                    ->sortable(),
                TextColumn::make('total_score')
                    ->label('Total')
                    ->sortable(),
                TextColumn::make('grade')
                    ->label('Grade')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'A' => 'success',
                        'B' => 'info',
                        'C' => 'warning',
                        'D' => 'danger',
                        'E' => 'gray',
                        default => 'gray',
                    }),
                TextColumn::make('semester.name')
                    ->label('Semester'),
            ])
            ->defaultSort('grade');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGrades::route('/'),
        ];
    }
}
