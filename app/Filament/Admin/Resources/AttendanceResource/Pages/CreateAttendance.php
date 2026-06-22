<?php

namespace App\Filament\Admin\Resources\AttendanceResource\Pages;

use App\Filament\Admin\Resources\AttendanceResource;
use App\DTOs\CreateAttendanceDTO;
use App\Services\AttendanceService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
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
            date: Carbon::parse($data['date']),
            status: $data['status'],
            notes: $data['notes'] ?? null,
        );
        return $service->record($dto);
    }
}
