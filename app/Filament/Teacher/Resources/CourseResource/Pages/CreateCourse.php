<?php

namespace App\Filament\Teacher\Resources\CourseResource\Pages;

use App\Filament\Teacher\Resources\CourseResource;
use App\DTOs\CreateCourseDTO;
use App\Services\CourseService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class CreateCourse extends CreateRecord
{
    protected static string $resource = CourseResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $service = App::make(CourseService::class);
        $dto = new CreateCourseDTO(
            academicYearId: $data['academic_year_id'],
            semesterId: $data['semester_id'],
            classroomId: $data['classroom_id'],
            subjectId: $data['subject_id'],
            teacherId: $data['teacher_id'],
            code: $data['code'],
            name: $data['name'],
            description: $data['description'] ?? null,
            totalHours: (int) ($data['total_hours'] ?? 0),
        );
        return $service->create($dto);
    }
}
