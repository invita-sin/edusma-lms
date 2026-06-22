<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\MajorResource\Pages;
use App\Models\Major;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Textarea;
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

class MajorResource extends Resource
{
    protected static ?string $model = Major::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-academic-cap';

    protected static string | UnitEnum | null $navigationGroup = 'Akademik';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make()->schema([
                    TextInput::make('code')
                        ->label('Kode Jurusan')
                        ->required()
                        ->maxLength(20)
                        ->unique(ignoreRecord: true)
                        ->placeholder('e.g. IPA'),
                    TextInput::make('name')
                        ->label('Nama Jurusan')
                        ->required()
                        ->maxLength(100)
                        ->placeholder('e.g. Ilmu Pengetahuan Alam'),
                    Textarea::make('description')
                        ->label('Deskripsi')
                        ->maxLength(255)
                        ->rows(2),
                ]),
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
                    ->label('Jurusan')
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListMajors::route('/'),
            'create' => Pages\CreateMajor::route('/create'),
            'edit' => Pages\EditMajor::route('/{record}/edit'),
        ];
    }
}
