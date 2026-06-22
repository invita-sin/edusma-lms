<?php

namespace App\Filament\Admin\Resources\MajorResource\Pages;

use App\Filament\Admin\Resources\MajorResource;
use App\DTOs\CreateMajorDTO;
use App\Services\MajorService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class CreateMajor extends CreateRecord
{
    protected static string $resource = MajorResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $service = App::make(MajorService::class);
        $dto = new CreateMajorDTO(
            code: $data['code'],
            name: $data['name'],
            description: $data['description'] ?? null,
        );
        return $service->create($dto);
    }
}
