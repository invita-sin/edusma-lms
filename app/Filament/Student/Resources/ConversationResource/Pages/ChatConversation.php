<?php

namespace App\Filament\Student\Resources\ConversationResource\Pages;

use App\Filament\Student\Resources\ConversationResource;
use App\Models\Conversation;
use App\Services\ConversationService;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;

class ChatConversation extends ViewRecord
{
    protected static string $resource = ConversationResource::class;

    protected ?string $heading = 'Pesan';

    public array $messages = [];

    public function mount(int | string $record): void
    {
        parent::mount($record);
        $this->loadMessages();
    }

    protected function loadMessages(): void
    {
        $service = app(ConversationService::class);
        $service->markAsRead($this->record);
        $this->messages = $service->getMessages($this->record)->toArray();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('send')
                ->label('Kirim Pesan')
                ->icon('heroicon-o-paper-airplane')
                ->form([
                    Textarea::make('message')
                        ->label('Pesan')
                        ->required()
                        ->rows(3),
                ])
                ->action(function (array $data) {
                    $service = app(ConversationService::class);
                    $service->sendMessage($this->record, $data['message'], 'student');
                    $this->loadMessages();
                    $this->dispatch('message-sent');
                })
                ->modalWidth('lg'),
        ];
    }

    public function getView(): string
    {
        return 'filament.student.resources.conversation-resource.pages.chat-conversation';
    }

    public function getViewData(): array
    {
        return [
            'conversation' => $this->record,
            'messages' => $this->messages,
        ];
    }
}
