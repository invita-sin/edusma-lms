<?php

namespace App\Filament\Admin\Resources\GradeResource\Pages;

use App\Filament\Admin\Resources\GradeResource;
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
            assignmentScore: $data['assignment_score'] ? (float) $data['assignment_score'] : null,
            quizScore: $data['quiz_score'] ? (float) $data['quiz_score'] : null,
            midtermScore: $data['midterm_score'] ? (float) $data['midterm_score'] : null,
            finalExamScore: $data['final_exam_score'] ? (float) $data['final_exam_score'] : null,
            notes: $data['notes'] ?? null,
        );
        return $service->calculate($dto);
    }
}
