<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\NotificationResource\Pages;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use BackedEnum;
use UnitEnum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class NotificationResource extends Resource
{
    protected static ?string $model = DatabaseNotification::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-bell';

    protected static string | UnitEnum | null $navigationGroup = 'Pengaturan';

    protected static ?int $navigationSort = 8;

    protected static ?string $navigationLabel = 'Notifikasi';

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->where('notifiable_id', Auth::id())
            ->where('notifiable_type', Auth::user()::class);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('data')
                    ->label('Pesan')
                    ->formatStateUsing(fn($state) => $state['title'] ?? ($state['message'] ?? '-'))
                    ->searchable()
                    ->limit(50),
                TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->formatStateUsing(fn($state) => class_basename($state)),
                TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('read_at')
                    ->label('Status')
                    ->formatStateUsing(fn($state) => $state ? 'Dibaca' : 'Belum')
                    ->badge()
                    ->color(fn($state) => $state ? 'success' : 'warning'),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Action::make('markAsRead')
                    ->label('Tandai Dibaca')
                    ->icon('heroicon-o-check-circle')
                    ->visible(fn(DatabaseNotification $record): bool => $record->read_at === null)
                    ->action(fn(DatabaseNotification $record) => $record->markAsRead()),
                Action::make('markAsUnread')
                    ->label('Tandai Belum')
                    ->icon('heroicon-o-x-circle')
                    ->visible(fn(DatabaseNotification $record): bool => $record->read_at !== null)
                    ->action(fn(DatabaseNotification $record) => $record->markAsUnread()),
                Action::make('delete')
                    ->label('Hapus')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->action(fn(DatabaseNotification $record) => $record->delete()),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    Action::make('markAllAsRead')
                        ->label('Tandai Semua Dibaca')
                        ->action(fn($records) => $records->each->markAsRead()),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNotifications::route('/'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $count = DatabaseNotification::where('notifiable_id', Auth::id())
            ->where('notifiable_type', Auth::user()::class)
            ->whereNull('read_at')
            ->count();
        return $count > 0 ? (string) $count : null;
    }
}
