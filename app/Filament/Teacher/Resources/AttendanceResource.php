<?php

namespace App\Filament\Teacher\Resources;

use App\Filament\Teacher\Resources\AttendanceResource\Pages;
use App\Models\Attendance;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use BackedEnum;
use UnitEnum;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static string | UnitEnum | null $navigationGroup = 'Akademik';

    protected static ?int $navigationSort = 5;

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
                Select::make('student_id')
                    ->label('Siswa')
                    ->relationship('student.user', 'name')
                    ->required(),
                Select::make('teacher_id')
                    ->label('Guru')
                    ->relationship('teacher.user', 'name')
                    ->default(Auth::user()->teacher?->id)
                    ->disabled()
                    ->dehydrated()
                    ->required(),
                DatePicker::make('date')
                    ->label('Tanggal')
                    ->required(),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'present' => 'Hadir',
                        'absent' => 'Alpa',
                        'sick' => 'Sakit',
                        'permission' => 'Izin',
                        'late' => 'Terlambat',
                    ])
                    ->required(),
                Textarea::make('notes')
                    ->label('Catatan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.user.name')
                    ->label('Siswa')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('course.name')
                    ->label('Course'),
                TextColumn::make('date')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'present' => 'success',
                        'absent' => 'danger',
                        'sick' => 'warning',
                        'permission' => 'info',
                        'late' => 'gray',
                    }),
            ])
            ->defaultSort('date', 'desc')
            ->actions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }
}
