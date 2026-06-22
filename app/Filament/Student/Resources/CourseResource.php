<?php

namespace App\Filament\Student\Resources;

use App\Filament\Student\Resources\CourseResource\Pages;
use App\Models\Course;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use BackedEnum;
use UnitEnum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-bookmark';

    protected static string | UnitEnum | null $navigationGroup = 'Akademik';

    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $student = Auth::user()->student;
        return parent::getEloquentQuery()->when($student, fn($q) => $q->where('classroom_id', $student->classroom_id));
    }

    public static function form(Schema $schema): Schema
    {
        return $schema;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Kode')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Course')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('subject.name')
                    ->label('Mapel'),
                TextColumn::make('teacher.user.name')
                    ->label('Guru'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
        ];
    }
}
