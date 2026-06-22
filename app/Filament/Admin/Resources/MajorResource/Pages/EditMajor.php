<?php

namespace App\Filament\Admin\Resources\MajorResource\Pages;

use App\Filament\Admin\Resources\MajorResource;
use App\DTOs\UpdateMajorDTO;
use App\Services\MajorService;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\App;

class EditMajor extends EditRecord
{
    protected static string $resource = MajorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $data = $this->form->getState();
        $service = App::make(MajorService::class);
        $dto = new UpdateMajorDTO(
            code: $data['code'],
            name: $data['name'],
            description: $data['description'] ?? null,
        );
        $service->update($this->record->id, $dto);
    }
}
