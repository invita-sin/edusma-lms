<?php

namespace App\Filament\Teacher\Resources\CourseResource\Pages;

use App\Filament\Teacher\Resources\CourseResource;
use App\DTOs\UpdateCourseDTO;
use App\Services\CourseService;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\App;

class EditCourse extends EditRecord
{
    protected static string $resource = CourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $data = $this->form->getState();
        $service = App::make(CourseService::class);
        $dto = new UpdateCourseDTO(
            academicYearId: $data['academic_year_id'],
            semesterId: $data['semester_id'],
            classroomId: $data['classroom_id'],
            subjectId: $data['subject_id'],
            teacherId: $data['teacher_id'],
            code: $data['code'],
            name: $data['name'],
            description: $data['description'] ?? null,
            totalHours: (int) ($data['total_hours'] ?? 0),
        );
        $service->update($this->record->id, $dto);
    }
}
