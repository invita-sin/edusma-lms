<?php

namespace App\Filament\Admin\Resources\ClassroomResource\Pages;

use App\Filament\Admin\Resources\ClassroomResource;
use App\DTOs\CreateClassroomDTO;
use App\Services\ClassroomService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class CreateClassroom extends CreateRecord
{
    protected static string $resource = ClassroomResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $service = App::make(ClassroomService::class);
        $dto = new CreateClassroomDTO(
            majorId: $data['major_id'],
            name: $data['name'],
            level: $data['level'],
            capacity: (int) ($data['capacity'] ?? 36),
        );
        return $service->create($dto);
    }
}
