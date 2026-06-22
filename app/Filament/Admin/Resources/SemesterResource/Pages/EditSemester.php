<?php

namespace App\Filament\Admin\Resources\SemesterResource\Pages;

use App\Filament\Admin\Resources\SemesterResource;
use App\DTOs\UpdateSemesterDTO;
use App\Services\SemesterService;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\App;

class EditSemester extends EditRecord
{
    protected static string $resource = SemesterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $data = $this->form->getState();
        $service = App::make(SemesterService::class);
        $dto = new UpdateSemesterDTO(
            academicYearId: $data['academic_year_id'],
            name: $data['name'],
            isActive: $data['is_active'] ?? false,
        );
        $service->update($this->record->id, $dto);
    }
}
