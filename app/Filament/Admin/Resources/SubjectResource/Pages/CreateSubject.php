<?php

namespace App\Filament\Admin\Resources\SubjectResource\Pages;

use App\Filament\Admin\Resources\SubjectResource;
use App\DTOs\CreateSubjectDTO;
use App\Services\SubjectService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class CreateSubject extends CreateRecord
{
    protected static string $resource = SubjectResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $service = App::make(SubjectService::class);
        $dto = new CreateSubjectDTO(
            code: $data['code'],
            name: $data['name'],
            description: $data['description'] ?? null,
        );
        return $service->create($dto);
    }
}
