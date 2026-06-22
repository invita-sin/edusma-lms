<?php

namespace App\DTOs;

readonly class CreateGradeDTO
{
    public function __construct(
        public int $studentId,
        public int $courseId,
        public int $academicYearId,
        public int $semesterId,
        public ?float $assignmentScore = null,
        public ?float $quizScore = null,
        public ?float $midtermScore = null,
        public ?float $finalExamScore = null,
        public ?string $notes = null,
    ) {}

    public function toArray(): array
    {
        return [
            'student_id' => $this->studentId,
            'course_id' => $this->courseId,
            'academic_year_id' => $this->academicYearId,
            'semester_id' => $this->semesterId,
            'assignment_score' => $this->assignmentScore,
            'quiz_score' => $this->quizScore,
            'midterm_score' => $this->midtermScore,
            'final_exam_score' => $this->finalExamScore,
            'notes' => $this->notes,
        ];
    }
}
