<?php

namespace App\Filament\Student\Resources;

use App\Filament\Student\Resources\ConversationResource\Pages;
use App\Models\Conversation;
use Filament\Actions\Action;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use BackedEnum;
use UnitEnum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ConversationResource extends Resource
{
    protected static ?string $model = Conversation::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';

    protected static string | UnitEnum | null $navigationGroup = 'Komunikasi';

    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $student = Auth::user()->student;
        return parent::getEloquentQuery()->when($student, fn($q) => $q->where('student_id', $student->id));
    }

    public static function form(Schema $schema): Schema
    {
        return $schema;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('teacher.user.name')
                    ->label('Guru')
                    ->searchable(),
                TextColumn::make('course.name')
                    ->label('Course')
                    ->searchable(),
                TextColumn::make('last_message_at')
                    ->label('Pesan Terakhir')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('messages_count')
                    ->label('Jumlah Pesan')
                    ->counts('messages'),
            ])
            ->actions([
                Action::make('chat')
                    ->label('Pesan')
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->url(fn(Conversation $record): string => static::getUrl('chat', ['record' => $record])),
            ])
            ->defaultSort('last_message_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListConversations::route('/'),
            'chat' => Pages\ChatConversation::route('/{record}/chat'),
        ];
    }
}
