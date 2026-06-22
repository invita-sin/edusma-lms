<?php

namespace App\Filament\Student\Resources;

use App\Filament\Student\Resources\AssignmentResource\Pages;
use App\Models\Assignment;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use BackedEnum;
use UnitEnum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class AssignmentResource extends Resource
{
    protected static ?string $model = Assignment::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static string | UnitEnum | null $navigationGroup = 'Akademik';

    protected static ?int $navigationSort = 2;

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
                TextColumn::make('type')
                    ->label('Tipe'),
                TextColumn::make('due_date')
                    ->label('Batas')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('due_date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssignments::route('/'),
        ];
    }
}
