<?php

namespace App\DTOs;

readonly class CreateSubmissionDTO
{
    public function __construct(
        public int $assignmentId,
        public int $studentId,
        public ?string $content = null,
        public ?string $filePath = null,
    ) {}

    public function toArray(): array
    {
        return [
            'assignment_id' => $this->assignmentId,
            'student_id' => $this->studentId,
            'content' => $this->content,
            'file_path' => $this->filePath,
        ];
    }
}
