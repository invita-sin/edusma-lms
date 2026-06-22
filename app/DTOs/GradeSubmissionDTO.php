<?php

namespace App\DTOs;

readonly class GradeSubmissionDTO
{
    public function __construct(
        public int $score,
        public ?string $feedback = null,
    ) {}

    public function toArray(): array
    {
        return [
            'score' => $this->score,
            'feedback' => $this->feedback,
        ];
    }
}
