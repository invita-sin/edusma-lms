<?php

namespace App\Filament\Teacher\Resources\AssignmentResource\Pages;

use App\Filament\Teacher\Resources\AssignmentResource;
use App\DTOs\UpdateAssignmentDTO;
use App\Services\AssignmentService;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\App;

class EditAssignment extends EditRecord
{
    protected static string $resource = AssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $data = $this->form->getState();
        $service = App::make(AssignmentService::class);
        $dto = new UpdateAssignmentDTO(
            courseId: $data['course_id'],
            teacherId: $data['teacher_id'],
            title: $data['title'],
            description: $data['description'] ?? null,
            type: $data['type'],
            maxScore: (int) ($data['max_score'] ?? 100),
            dueDate: $data['due_date'],
            filePath: $data['file_path'] ?? null,
        );
        $service->update($this->record->id, $dto);
    }
}
