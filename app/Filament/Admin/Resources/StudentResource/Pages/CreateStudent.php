<?php

namespace App\Filament\Admin\Resources\StudentResource\Pages;

use App\Filament\Admin\Resources\StudentResource;
use App\DTOs\CreateStudentDTO;
use App\Services\StudentService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $service = App::make(StudentService::class);
        $dto = new CreateStudentDTO(
            userId: $data['user_id'],
            nisn: $data['nisn'],
            nis: $data['nis'],
            classroomId: $data['classroom_id'] ?? null,
            phone: $data['phone'] ?? null,
            address: $data['address'] ?? null,
            gender: $data['gender'],
            birthDate: $data['birth_date'] ? Carbon::parse($data['birth_date']) : null,
        );
        return $service->create($dto);
    }
}
