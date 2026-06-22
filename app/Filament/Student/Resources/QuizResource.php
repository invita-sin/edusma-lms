<?php

namespace App\Filament\Student\Resources;

use App\Filament\Student\Resources\QuizResource\Pages;
use App\Models\Quiz;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use BackedEnum;
use UnitEnum;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class QuizResource extends Resource
{
    protected static ?string $model = Quiz::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static string | UnitEnum | null $navigationGroup = 'Akademik';

    protected static ?int $navigationSort = 4;

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $student = Auth::user()->student;
        return parent::getEloquentQuery()->when($student, fn($q) => $q->whereHas('course', fn($cq) => $cq->where('classroom_id', $student->classroom_id)));
    }

    public static function form(Schema $schema): Schema
    {
        return $schema;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('course.name')
                    ->label('Course'),
                TextColumn::make('questions_count')
                    ->label('Soal')
                    ->counts('questions'),
                TextColumn::make('time_limit')
                    ->label('Durasi')
                    ->suffix(' menit'),
                IconColumn::make('is_published')
                    ->label('Tersedia')
                    ->boolean(),
            ])
            ;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuizzes::route('/'),
        ];
    }
}
