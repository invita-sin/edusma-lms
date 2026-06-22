<?php

namespace App\Filament\Admin\Resources\AcademicYearResource\Pages;

use App\Filament\Admin\Resources\AcademicYearResource;
use App\DTOs\CreateAcademicYearDTO;
use App\Services\AcademicYearService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

class CreateAcademicYear extends CreateRecord
{
    protected static string $resource = AcademicYearResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $service = App::make(AcademicYearService::class);
        $dto = new CreateAcademicYearDTO(
            name: $data['name'],
            startDate: Carbon::parse($data['start_date']),
            endDate: Carbon::parse($data['end_date']),
            isActive: $data['is_active'] ?? false,
        );
        return $service->create($dto);
    }
}
