<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ClassroomResource\Pages;
use App\Models\Classroom;
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

class ClassroomResource extends Resource
{
    protected static ?string $model = Classroom::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-building-library';

    protected static string | UnitEnum | null $navigationGroup = 'Akademik';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('major_id')
                    ->label('Jurusan')
                    ->relationship('major', 'name')
                    ->required(),
                TextInput::make('name')
                    ->label('Nama Kelas')
                    ->required()
                    ->maxLength(100)
                    ->placeholder('e.g. X IPA 1'),
                Select::make('level')
                    ->label('Tingkat')
                    ->options([
                        '10' => 'X (Sepuluh)',
                        '11' => 'XI (Sebelas)',
                        '12' => 'XII (Dua Belas)',
                    ])
                    ->required(),
                TextInput::make('capacity')
                    ->label('Kapasitas')
                    ->numeric()
                    ->default(36)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Kelas')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('major.name')
                    ->label('Jurusan')
                    ->sortable(),
                TextColumn::make('level')
                    ->label('Tingkat'),
                TextColumn::make('students_count')
                    ->label('Jml Siswa')
                    ->counts('students'),
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
            'index' => Pages\ListClassrooms::route('/'),
            'create' => Pages\CreateClassroom::route('/create'),
            'edit' => Pages\EditClassroom::route('/{record}/edit'),
        ];
    }
}
