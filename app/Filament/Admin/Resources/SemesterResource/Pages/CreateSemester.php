<?php

namespace App\Filament\Admin\Resources\SemesterResource\Pages;

use App\Filament\Admin\Resources\SemesterResource;
use App\DTOs\CreateSemesterDTO;
use App\Services\SemesterService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class CreateSemester extends CreateRecord
{
    protected static string $resource = SemesterResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $service = App::make(SemesterService::class);
        $dto = new CreateSemesterDTO(
            academicYearId: $data['academic_year_id'],
            name: $data['name'],
            isActive: $data['is_active'] ?? false,
        );
        return $service->create($dto);
    }
}
