<?php

namespace App\Filament\Teacher\Resources\QuizResource\Pages;

use App\Filament\Teacher\Resources\QuizResource;
use App\DTOs\UpdateQuizDTO;
use App\Services\QuizService;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\App;

class EditQuiz extends EditRecord
{
    protected static string $resource = QuizResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $data = $this->form->getState();
        $service = App::make(QuizService::class);
        $dto = new UpdateQuizDTO(
            courseId: $data['course_id'],
            teacherId: $data['teacher_id'],
            title: $data['title'],
            description: $data['description'] ?? null,
            timeLimit: (int) ($data['time_limit'] ?? 0),
            passingScore: (int) ($data['passing_score'] ?? 70),
            isRandom: (bool) ($data['is_random'] ?? false),
            isPublished: (bool) ($data['is_published'] ?? false),
            startDate: $data['start_date'] ?? null,
            endDate: $data['end_date'] ?? null,
        );
        $service->update($this->record->id, $dto);
    }
}
