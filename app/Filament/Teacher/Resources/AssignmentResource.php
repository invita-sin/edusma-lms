<?php

namespace App\Filament\Teacher\Resources;

use App\Filament\Teacher\Resources\AssignmentResource\Pages;
use App\Models\Assignment;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use BackedEnum;
use UnitEnum;
use Filament\Actions\EditAction;
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
        $teacher = Auth::user()->teacher;
        return parent::getEloquentQuery()->when($teacher, fn($q) => $q->where('teacher_id', $teacher->id));
    }

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
                    ->default(Auth::user()->teacher?->id)
                    ->disabled()
                    ->dehydrated()
                    ->required(),
                TextInput::make('title')
                    ->label('Judul Tugas')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->label('Deskripsi'),
                Select::make('type')
                    ->label('Tipe')
                    ->options([
                        'essay' => 'Essay',
                        'file_upload' => 'Upload File',
                    ])
                    ->required(),
                TextInput::make('max_score')
                    ->label('Nilai Maksimal')
                    ->numeric()
                    ->default(100)
                    ->required(),
                DateTimePicker::make('due_date')
                    ->label('Batas Pengumpulan')
                    ->required(),
                FileUpload::make('file_path')
                    ->label('File Lampiran')
                    ->disk('public')
                    ->directory('assignments'),
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
                TextColumn::make('type')
                    ->label('Tipe'),
                TextColumn::make('due_date')
                    ->label('Batas')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('submissions_count')
                    ->label('Pengumpulan')
                    ->counts('submissions'),
            ])
            ->defaultSort('due_date', 'desc')
            ->actions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssignments::route('/'),
            'create' => Pages\CreateAssignment::route('/create'),
            'edit' => Pages\EditAssignment::route('/{record}/edit'),
        ];
    }
}
