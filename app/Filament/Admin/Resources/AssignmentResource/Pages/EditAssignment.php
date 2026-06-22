<?php

namespace App\Filament\Admin\Resources\AssignmentResource\Pages;

use App\Filament\Admin\Resources\AssignmentResource;
use App\DTOs\UpdateAssignmentDTO;
use App\Services\AssignmentService;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Carbon;
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
            filePath: $data['file_path'] ?? null,
            type: $data['type'],
            maxScore: (int) ($data['max_score'] ?? 100),
            dueDate: Carbon::parse($data['due_date']),
        );
        $service->update($this->record->id, $dto);
    }
}
