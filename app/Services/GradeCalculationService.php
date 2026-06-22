<?php

namespace App\Services;

use App\DTOs\CreateGradeDTO;
use App\Models\Grade;
use App\Repositories\GradeRepository;

class GradeCalculationService
{
    public function __construct(
        private readonly GradeRepository $repository,
    ) {}

    public function calculate(CreateGradeDTO $dto): Grade
    {
        $assignmentWeight = 0.20;
        $quizWeight = 0.20;
        $midtermWeight = 0.30;
        $finalExamWeight = 0.30;

        $a = $dto->assignmentScore ?? 0;
        $q = $dto->quizScore ?? 0;
        $m = $dto->midtermScore ?? 0;
        $f = $dto->finalExamScore ?? 0;

        $totalScore = ($a * $assignmentWeight) + ($q * $quizWeight) + ($m * $midtermWeight) + ($f * $finalExamWeight);

        $grade = $this->convertToLetter($totalScore);

        return $this->repository->create([
            'student_id' => $dto->studentId,
            'course_id' => $dto->courseId,
            'academic_year_id' => $dto->academicYearId,
            'semester_id' => $dto->semesterId,
            'assignment_score' => $a,
            'quiz_score' => $q,
            'midterm_score' => $m,
            'final_exam_score' => $f,
            'total_score' => $totalScore,
            'grade' => $grade,
            'notes' => $dto->notes,
        ]);
    }

    public function recalculate(int $gradeId): Grade
    {
        $grade = $this->repository->findById($gradeId);
        if (!$grade) {
            throw new \RuntimeException('Grade not found');
        }

        $assignmentWeight = 0.20;
        $quizWeight = 0.20;
        $midtermWeight = 0.30;
        $finalExamWeight = 0.30;

        $a = $grade->assignment_score ?? 0;
        $q = $grade->quiz_score ?? 0;
        $m = $grade->midterm_score ?? 0;
        $f = $grade->final_exam_score ?? 0;

        $totalScore = ($a * $assignmentWeight) + ($q * $quizWeight) + ($m * $midtermWeight) + ($f * $finalExamWeight);

        $letterGrade = $this->convertToLetter($totalScore);

        $grade->update([
            'total_score' => $totalScore,
            'grade' => $letterGrade,
        ]);

        return $grade->fresh();
    }

    private function convertToLetter(float $score): string
    {
        return match (true) {
            $score >= 92 => 'A',
            $score >= 83 => 'B',
            $score >= 75 => 'C',
            $score >= 60 => 'D',
            default => 'E',
        };
    }
}
