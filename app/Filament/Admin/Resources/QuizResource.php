<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\QuizResource\Pages;
use App\Models\Quiz;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use BackedEnum;
use UnitEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class QuizResource extends Resource
{
    protected static ?string $model = Quiz::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static string | UnitEnum | null $navigationGroup = 'Akademik';

    protected static ?int $navigationSort = 9;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('course_id')
                    ->label('Course')
                    ->relationship('course', 'name')
                    ->required(),
                Select::make('teacher_id')
                    ->label('Guru')
                    ->relationship('teacher.user', 'name')
                    ->required(),
                TextInput::make('title')
                    ->label('Judul Quiz')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->label('Deskripsi'),
                TextInput::make('time_limit')
                    ->label('Batas Waktu (menit)')
                    ->numeric()
                    ->suffix('menit'),
                TextInput::make('passing_score')
                    ->label('Nilai Minimal')
                    ->numeric()
                    ->default(70)
                    ->suffix('%'),
                Toggle::make('is_random')
                    ->label('Acak Soal'),
                Toggle::make('is_published')
                    ->label('Publikasikan'),
                DateTimePicker::make('start_date')
                    ->label('Mulai'),
                DateTimePicker::make('end_date')
                    ->label('Selesai'),
            ]);
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
                TextColumn::make('teacher.user.name')
                    ->label('Guru'),
                IconColumn::make('is_published')
                    ->label('Publik')
                    ->boolean(),
                TextColumn::make('questions_count')
                    ->label('Soal')
                    ->counts('questions'),
                TextColumn::make('time_limit')
                    ->label('Durasi')
                    ->suffix(' menit'),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuizzes::route('/'),
            'create' => Pages\CreateQuiz::route('/create'),
            'edit' => Pages\EditQuiz::route('/{record}/edit'),
        ];
    }
}
