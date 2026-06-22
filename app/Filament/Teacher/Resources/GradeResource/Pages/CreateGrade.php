<?php

namespace App\Filament\Teacher\Resources\GradeResource\Pages;

use App\Filament\Teacher\Resources\GradeResource;
use App\DTOs\CreateGradeDTO;
use App\Services\GradeCalculationService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class CreateGrade extends CreateRecord
{
    protected static string $resource = GradeResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $service = App::make(GradeCalculationService::class);
        $dto = new CreateGradeDTO(
            studentId: $data['student_id'],
            courseId: $data['course_id'],
            academicYearId: $data['academic_year_id'],
            semesterId: $data['semester_id'],
            assignmentScore: (float) ($data['assignment_score'] ?? 0),
            quizScore: (float) ($data['quiz_score'] ?? 0),
            midtermScore: (float) ($data['midterm_score'] ?? 0),
            finalExamScore: (float) ($data['final_exam_score'] ?? 0),
            notes: $data['notes'] ?? null,
        );
        return $service->calculate($dto);
    }
}
