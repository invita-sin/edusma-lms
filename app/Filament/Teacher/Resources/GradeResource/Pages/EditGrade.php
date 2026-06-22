<?php

namespace App\Filament\Teacher\Resources\GradeResource\Pages;

use App\Filament\Teacher\Resources\GradeResource;
use App\Services\GradeCalculationService;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\App;

class EditGrade extends EditRecord
{
    protected static string $resource = GradeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $service = App::make(GradeCalculationService::class);
        $service->recalculate($this->record->id);
    }
}
