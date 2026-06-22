<?php

namespace App\Filament\Teacher\Resources\AttendanceResource\Pages;

use App\Filament\Teacher\Resources\AttendanceResource;
use App\DTOs\UpdateAttendanceDTO;
use App\Services\AttendanceService;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\App;

class EditAttendance extends EditRecord
{
    protected static string $resource = AttendanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $data = $this->form->getState();
        $service = App::make(AttendanceService::class);
        $dto = new UpdateAttendanceDTO(
            courseId: $data['course_id'],
            studentId: $data['student_id'],
            teacherId: $data['teacher_id'],
            date: $data['date'],
            status: $data['status'],
            notes: $data['notes'] ?? null,
        );
        $service->update($this->record->id, $dto);
    }
}
