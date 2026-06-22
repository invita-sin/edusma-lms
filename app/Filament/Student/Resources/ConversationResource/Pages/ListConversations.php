<?php

namespace App\Filament\Student\Resources\ConversationResource\Pages;

use App\Filament\Student\Resources\ConversationResource;
use App\Models\Conversation;
use App\Models\Course;
use App\Services\ConversationService;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListConversations extends ListRecords
{
    protected static string $resource = ConversationResource::class;

    protected ?string $heading = 'Pesan';

    protected ?string $subheading = 'Pesan dengan guru';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('newChat')
                ->label('Pesan Baru')
                ->icon('heroicon-o-plus')
                ->form([
                    Select::make('course_id')
                        ->label('Course')
                        ->options(function () {
                            $student = Auth::user()->student;
                            if (!$student) return [];
                            return Course::where('classroom_id', $student->classroom_id)
                                ->with('teacher.user', 'subject')
                                ->get()
                                ->mapWithKeys(fn($c) => [
                                    $c->id => $c->name . ' — ' . ($c->teacher->user->name ?? 'N/A')
                                ]);
                        })
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(fn($state, callable $set) =>
                            $set('teacher_id', Course::find($state)?->teacher_id)
                        ),
                    Select::make('teacher_id')
                        ->label('Guru')
                        ->disabled()
                        ->dehydrated()
                        ->required(),
                    Textarea::make('message')
                        ->label('Pesan Awal')
                        ->required()
                        ->rows(3),
                ])
                ->action(function (array $data) {
                    $student = Auth::user()->student;
                    if (!$student) return;

                    $service = app(ConversationService::class);
                    $conversation = $service->findOrCreate(
                        $data['course_id'],
                        $data['teacher_id'],
                        $student->id
                    );
                    $service->sendMessage($conversation, $data['message'], 'student');

                    return redirect()->to(ConversationResource::getUrl('chat', ['record' => $conversation]));
                })
                ->modalWidth('lg'),
        ];
    }
}
