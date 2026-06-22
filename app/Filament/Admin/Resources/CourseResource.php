<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CourseResource\Pages;
use App\Models\Course;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use BackedEnum;
use UnitEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-bookmark';

    protected static string | UnitEnum | null $navigationGroup = 'Akademik';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('academic_year_id')
                    ->label('Tahun Ajaran')
                    ->relationship('academicYear', 'name')
                    ->required(),
                Select::make('semester_id')
                    ->label('Semester')
                    ->relationship('semester', 'name')
                    ->required(),
                Select::make('classroom_id')
                    ->label('Kelas')
                    ->relationship('classroom', 'name')
                    ->required(),
                Select::make('subject_id')
                    ->label('Mata Pelajaran')
                    ->relationship('subject', 'name')
                    ->required(),
                Select::make('teacher_id')
                    ->label('Guru')
                    ->relationship('teacher.user', 'name')
                    ->required(),
                TextInput::make('code')
                    ->label('Kode Course')
                    ->required()
                    ->maxLength(50)
                    ->unique(ignoreRecord: true)
                    ->placeholder('e.g. MTK-X-IPA1-2526'),
                TextInput::make('name')
                    ->label('Nama Course')
                    ->required()
                    ->maxLength(255),
                TextInput::make('total_hours')
                    ->label('Total Jam')
                    ->numeric()
                    ->default(0),
            ]);
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
                TextColumn::make('classroom.name')
                    ->label('Kelas'),
                TextColumn::make('subject.name')
                    ->label('Mapel'),
                TextColumn::make('teacher.user.name')
                    ->label('Guru'),
                TextColumn::make('academicYear.name')
                    ->label('Tahun Ajaran'),
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
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}
