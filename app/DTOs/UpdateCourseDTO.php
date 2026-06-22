<?php

namespace App\DTOs;

readonly class UpdateCourseDTO
{
    public function __construct(
        public int $academicYearId,
        public int $semesterId,
        public int $classroomId,
        public int $subjectId,
        public int $teacherId,
        public string $code,
        public string $name,
        public ?string $description = null,
        public int $totalHours = 0,
    ) {}

    public function toArray(): array
    {
        return [
            'academic_year_id' => $this->academicYearId,
            'semester_id' => $this->semesterId,
            'classroom_id' => $this->classroomId,
            'subject_id' => $this->subjectId,
            'teacher_id' => $this->teacherId,
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'total_hours' => $this->totalHours,
        ];
    }
}
