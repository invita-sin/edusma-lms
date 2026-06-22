<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\StudentResource\Pages;
use App\Models\Student;
use Filament\Forms\Components\DatePicker;
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

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-user';

    protected static string | UnitEnum | null $navigationGroup = 'Manajemen Pengguna';

    protected static ?int $navigationSort = 2;

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
                    ->unique(ignoreRecord: true)
                    ->placeholder('e.g. 1234567890'),
                TextInput::make('nis')
                    ->label('NIS')
                    ->required()
                    ->maxLength(20)
                    ->unique(ignoreRecord: true)
                    ->placeholder('e.g. 9876543210'),
                Select::make('classroom_id')
                    ->label('Kelas')
                    ->relationship('classroom', 'name')
                    ->required()
                    ->helperText('Wajib diisi agar siswa dapat mengakses course, materi, dan tugas.'),
                TextInput::make('phone')
                    ->label('No. Telepon')
                    ->maxLength(20)
                    ->tel()
                    ->placeholder('e.g. 08123456789'),
                TextInput::make('address')
                    ->label('Alamat'),
                Select::make('gender')
                    ->label('Jenis Kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ])
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
