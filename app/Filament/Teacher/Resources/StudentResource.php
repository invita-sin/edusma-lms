<?php

namespace App\Filament\Teacher\Resources;

use App\Filament\Teacher\Resources\StudentResource\Pages;
use App\Models\Classroom;
use App\Models\Course;
use App\Models\Student;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use BackedEnum;
use UnitEnum;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-user';

    protected static string | UnitEnum | null $navigationGroup = 'Manajemen Pengguna';

    protected static ?int $navigationSort = 7;

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $teacher = Auth::user()->teacher;
        return parent::getEloquentQuery()->when($teacher, fn($q) => $q->whereIn('classroom_id', function ($sub) use ($teacher) {
            $sub->select('classroom_id')
                ->from('courses')
                ->where('teacher_id', $teacher->id)
                ->whereNotNull('classroom_id');
        }));
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('nisn')
                    ->label('NISN')
                    ->required()
                    ->maxLength(20)
                    ->unique(ignoreRecord: true),
                TextInput::make('nis')
                    ->label('NIS')
                    ->required()
                    ->maxLength(20)
                    ->unique(ignoreRecord: true),
                Select::make('classroom_id')
                    ->label('Kelas')
                    ->options(function () {
                        $teacher = Auth::user()->teacher;
                        if (!$teacher) return [];
                        return Classroom::whereIn('id',
                            Course::where('teacher_id', $teacher->id)
                                ->whereNotNull('classroom_id')
                                ->pluck('classroom_id')
                        )->pluck('name', 'id');
                    })
                    ->required()
                    ->helperText('Wajib diisi agar siswa dapat mengakses course, materi, dan tugas.'),
                TextInput::make('phone')
                    ->label('No. Telepon')
                    ->maxLength(20)
                    ->tel(),
                TextInput::make('address')
                    ->label('Alamat'),
                Select::make('gender')
                    ->label('Jenis Kelamin')
                    ->options(['L' => 'Laki-laki', 'P' => 'Perempuan'])
                    ->required(),
                DatePicker::make('birth_date')
                    ->label('Tanggal Lahir'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nisn')
                    ->label('NISN')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nis')
                    ->label('NIS')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('classroom.name')
                    ->label('Kelas'),
                TextColumn::make('gender')
                    ->label('L/P'),
            ])
            ->actions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
