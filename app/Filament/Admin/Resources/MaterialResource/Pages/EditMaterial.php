<?php

namespace App\Filament\Admin\Resources\MaterialResource\Pages;

use App\Filament\Admin\Resources\MaterialResource;
use App\DTOs\UpdateMaterialDTO;
use App\Services\MaterialService;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\App;

class EditMaterial extends EditRecord
{
    protected static string $resource = MaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $data = $this->form->getState();
        $service = App::make(MaterialService::class);
        $dto = new UpdateMaterialDTO(
            courseId: $data['course_id'],
            title: $data['title'],
            description: $data['description'] ?? null,
            filePath: $data['file_path'] ?? null,
            fileType: $data['file_path'] ? pathinfo($data['file_path'], PATHINFO_EXTENSION) : null,
            fileSize: null,
            url: $data['url'] ?? null,
            order: (int) ($data['order'] ?? 0),
        );
        $service->update($this->record->id, $dto);
    }
}
