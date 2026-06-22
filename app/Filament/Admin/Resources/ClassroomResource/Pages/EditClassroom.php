<?php

namespace App\Filament\Admin\Resources\ClassroomResource\Pages;

use App\Filament\Admin\Resources\ClassroomResource;
use App\DTOs\UpdateClassroomDTO;
use App\Services\ClassroomService;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\App;

class EditClassroom extends EditRecord
{
    protected static string $resource = ClassroomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $data = $this->form->getState();
        $service = App::make(ClassroomService::class);
        $dto = new UpdateClassroomDTO(
            majorId: $data['major_id'],
            name: $data['name'],
            level: $data['level'],
            capacity: (int) ($data['capacity'] ?? 36),
        );
        $service->update($this->record->id, $dto);
    }
}
