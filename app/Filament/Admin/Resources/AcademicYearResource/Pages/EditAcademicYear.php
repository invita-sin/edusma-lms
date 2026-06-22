<?php

namespace App\Filament\Admin\Resources\AcademicYearResource\Pages;

use App\Filament\Admin\Resources\AcademicYearResource;
use App\DTOs\UpdateAcademicYearDTO;
use App\Services\AcademicYearService;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\App;

class EditAcademicYear extends EditRecord
{
    protected static string $resource = AcademicYearResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $data = $this->form->getState();
        $service = App::make(AcademicYearService::class);
        $dto = new UpdateAcademicYearDTO(
            name: $data['name'],
            startDate: \Illuminate\Support\Carbon::parse($data['start_date']),
            endDate: \Illuminate\Support\Carbon::parse($data['end_date']),
            isActive: $data['is_active'] ?? false,
        );
        $service->update($this->record->id, $dto);
    }
}
