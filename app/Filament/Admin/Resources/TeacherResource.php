<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TeacherResource\Pages;
use App\Models\Teacher;
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

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-user-group';

    protected static string | UnitEnum | null $navigationGroup = 'Manajemen Pengguna';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('nip')
                    ->label('NIP')
                    ->required()
                    ->maxLength(30)
                    ->unique(ignoreRecord: true)
                    ->placeholder('e.g. 1234567890'),
                TextInput::make('nuptk')
                    ->label('NUPTK')
                    ->maxLength(30)
                    ->placeholder('e.g. 9876543210'),
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
                TextInput::make('specialization')
                    ->label('Spesialisasi')
                    ->maxLength(255)
                    ->placeholder('e.g. Matematika'),
                DatePicker::make('birth_date')
                    ->label('Tanggal Lahir'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nip')
                    ->label('NIP')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('gender')
                    ->label('L/P'),
                TextColumn::make('specialization')
                    ->label('Spesialisasi')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Telepon'),
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
            'index' => Pages\ListTeachers::route('/'),
            'create' => Pages\CreateTeacher::route('/create'),
            'edit' => Pages\EditTeacher::route('/{record}/edit'),
        ];
    }
}
