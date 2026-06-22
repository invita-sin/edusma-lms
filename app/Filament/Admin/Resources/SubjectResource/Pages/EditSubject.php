<?php

namespace App\Filament\Admin\Resources\SubjectResource\Pages;

use App\Filament\Admin\Resources\SubjectResource;
use App\DTOs\UpdateSubjectDTO;
use App\Services\SubjectService;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\App;

class EditSubject extends EditRecord
{
    protected static string $resource = SubjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $data = $this->form->getState();
        $service = App::make(SubjectService::class);
        $dto = new UpdateSubjectDTO(
            code: $data['code'],
            name: $data['name'],
            description: $data['description'] ?? null,
        );
        $service->update($this->record->id, $dto);
    }
}
