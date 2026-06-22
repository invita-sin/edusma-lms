<?php

namespace App\DTOs;

readonly class CreateAttemptDTO
{
    public function __construct(
        public int $quizId,
        public int $studentId,
    ) {}

    public function toArray(): array
    {
        return [
            'quiz_id' => $this->quizId,
            'student_id' => $this->studentId,
        ];
    }
}
