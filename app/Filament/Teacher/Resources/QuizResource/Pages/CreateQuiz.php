<?php

namespace App\Filament\Teacher\Resources\QuizResource\Pages;

use App\Filament\Teacher\Resources\QuizResource;
use App\DTOs\CreateQuizDTO;
use App\Services\QuizService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class CreateQuiz extends CreateRecord
{
    protected static string $resource = QuizResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $service = App::make(QuizService::class);
        $dto = new CreateQuizDTO(
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
        return $service->create($dto);
    }
}
