<?php

namespace App\Filament\Admin\Resources\QuizResource\Pages;

use App\Filament\Admin\Resources\QuizResource;
use App\DTOs\UpdateQuizDTO;
use App\Services\QuizService;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Carbon;
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
            timeLimit: $data['time_limit'] ? (int) $data['time_limit'] : null,
            passingScore: (int) ($data['passing_score'] ?? 70),
            isRandom: $data['is_random'] ?? false,
            isPublished: $data['is_published'] ?? false,
            startDate: $data['start_date'] ? Carbon::parse($data['start_date']) : null,
            endDate: $data['end_date'] ? Carbon::parse($data['end_date']) : null,
        );
        $service->update($this->record->id, $dto);
    }
}
