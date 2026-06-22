<?php

namespace App\Filament\Teacher\Resources\AttendanceResource\Pages;

use App\Filament\Teacher\Resources\AttendanceResource;
use App\DTOs\CreateAttendanceDTO;
use App\Services\AttendanceService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class CreateAttendance extends CreateRecord
{
    protected static string $resource = AttendanceResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $service = App::make(AttendanceService::class);
        $dto = new CreateAttendanceDTO(
            courseId: $data['course_id'],
            studentId: $data['student_id'],
            teacherId: $data['teacher_id'],
            date: $data['date'],
            status: $data['status'],
            notes: $data['notes'] ?? null,
        );
        return $service->create($dto);
    }
}
