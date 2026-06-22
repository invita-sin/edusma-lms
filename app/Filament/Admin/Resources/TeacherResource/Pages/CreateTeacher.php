<?php

namespace App\Filament\Admin\Resources\TeacherResource\Pages;

use App\Filament\Admin\Resources\TeacherResource;
use App\DTOs\CreateTeacherDTO;
use App\Services\TeacherService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

class CreateTeacher extends CreateRecord
{
    protected static string $resource = TeacherResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $service = App::make(TeacherService::class);
        $dto = new CreateTeacherDTO(
            userId: $data['user_id'],
            nip: $data['nip'],
            nuptk: $data['nuptk'] ?? null,
            phone: $data['phone'] ?? null,
            address: $data['address'] ?? null,
            gender: $data['gender'],
            specialization: $data['specialization'] ?? null,
            birthDate: $data['birth_date'] ? Carbon::parse($data['birth_date']) : null,
        );
        return $service->create($dto);
    }
}
