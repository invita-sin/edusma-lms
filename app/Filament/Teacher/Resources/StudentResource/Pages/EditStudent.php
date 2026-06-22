<?php

namespace App\Filament\Teacher\Resources\StudentResource\Pages;

use App\Filament\Teacher\Resources\StudentResource;
use App\DTOs\UpdateStudentDTO;
use App\Services\StudentService;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\App;

class EditStudent extends EditRecord
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $data = $this->form->getState();
        $service = App::make(StudentService::class);
        $dto = new UpdateStudentDTO(
            userId: $data['user_id'],
            nisn: $data['nisn'],
            nis: $data['nis'],
            classroomId: $data['classroom_id'] ?? null,
            phone: $data['phone'] ?? null,
            address: $data['address'] ?? null,
            gender: $data['gender'],
            birthDate: $data['birth_date'] ?? null,
        );
        $service->update($this->record->id, $dto);
    }
}
