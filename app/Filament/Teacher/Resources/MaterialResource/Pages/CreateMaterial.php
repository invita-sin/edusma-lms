<?php

namespace App\Filament\Teacher\Resources\MaterialResource\Pages;

use App\Filament\Teacher\Resources\MaterialResource;
use App\DTOs\CreateMaterialDTO;
use App\Services\MaterialService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class CreateMaterial extends CreateRecord
{
    protected static string $resource = MaterialResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $service = App::make(MaterialService::class);
        $dto = new CreateMaterialDTO(
            courseId: $data['course_id'],
            title: $data['title'],
            description: $data['description'] ?? null,
            filePath: $data['file_path'] ?? null,
            url: $data['url'] ?? null,
            order: (int) ($data['order'] ?? 0),
        );
        return $service->create($dto);
    }
}
