<?php

namespace App\Filament\Admin\Resources\TeacherResource\Pages;

use App\Filament\Admin\Resources\TeacherResource;
use App\DTOs\UpdateTeacherDTO;
use App\Services\TeacherService;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

class EditTeacher extends EditRecord
{
    protected static string $resource = TeacherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $data = $this->form->getState();
        $service = App::make(TeacherService::class);
        $dto = new UpdateTeacherDTO(
            userId: $data['user_id'],
            nip: $data['nip'],
            nuptk: $data['nuptk'] ?? null,
            phone: $data['phone'] ?? null,
            address: $data['address'] ?? null,
            gender: $data['gender'],
            specialization: $data['specialization'] ?? null,
            birthDate: $data['birth_date'] ? Carbon::parse($data['birth_date']) : null,
        );
        $service->update($this->record->id, $dto);
    }
}
