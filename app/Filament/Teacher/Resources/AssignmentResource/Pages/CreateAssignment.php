<?php

namespace App\Filament\Teacher\Resources\AssignmentResource\Pages;

use App\Filament\Teacher\Resources\AssignmentResource;
use App\DTOs\CreateAssignmentDTO;
use App\Services\AssignmentService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

class CreateAssignment extends CreateRecord
{
    protected static string $resource = AssignmentResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $service = App::make(AssignmentService::class);
        $dto = new CreateAssignmentDTO(
            courseId: $data['course_id'],
            teacherId: $data['teacher_id'],
            title: $data['title'],
            description: $data['description'] ?? null,
            type: $data['type'],
            maxScore: (int) ($data['max_score'] ?? 100),
            dueDate: Carbon::parse($data['due_date']),
            filePath: $data['file_path'] ?? null,
        );
        return $service->create($dto);
    }
}
