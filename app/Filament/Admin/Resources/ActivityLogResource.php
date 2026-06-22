<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ActivityLogResource\Pages;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use BackedEnum;
use UnitEnum;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Spatie\Activitylog\Models\Activity;

class ActivityLogResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-clock';

    protected static string | UnitEnum | null $navigationGroup = 'Pengaturan';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('log_name')
                    ->label('Tipe')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Aktivitas')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('causer.name')
                    ->label('Pengguna')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                ViewAction::make()
                    ->form([
                        TextColumn::make('description'),
                        TextColumn::make('log_name'),
                        TextColumn::make('causer.name'),
                        TextColumn::make('subject_type')
                            ->label('Model'),
                        TextColumn::make('subject_id')
                            ->label('ID Model'),
                        TextColumn::make('properties')
                            ->label('Data')
                            ->getStateUsing(fn($record) => json_encode($record->properties, JSON_PRETTY_PRINT)),
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivityLogs::route('/'),
        ];
    }
}
