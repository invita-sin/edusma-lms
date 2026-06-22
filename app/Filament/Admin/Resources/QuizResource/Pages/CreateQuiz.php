<?php

namespace App\Filament\Admin\Resources\QuizResource\Pages;

use App\Filament\Admin\Resources\QuizResource;
use App\DTOs\CreateQuizDTO;
use App\Services\QuizService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
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
            timeLimit: $data['time_limit'] ? (int) $data['time_limit'] : null,
            passingScore: (int) ($data['passing_score'] ?? 70),
            isRandom: $data['is_random'] ?? false,
            isPublished: $data['is_published'] ?? false,
            startDate: $data['start_date'] ? Carbon::parse($data['start_date']) : null,
            endDate: $data['end_date'] ? Carbon::parse($data['end_date']) : null,
        );
        return $service->create($dto);
    }
}
