<?php

namespace App\DTOs;

use Illuminate\Support\Carbon;

readonly class UpdateAssignmentDTO
{
    public function __construct(
        public int $courseId,
        public int $teacherId,
        public string $title,
        public ?string $description = null,
        public ?string $filePath = null,
        public string $type = 'essay',
        public int $maxScore = 100,
        public Carbon $dueDate,
    ) {}

    public function toArray(): array
    {
        return [
            'course_id' => $this->courseId,
            'teacher_id' => $this->teacherId,
            'title' => $this->title,
            'description' => $this->description,
            'file_path' => $this->filePath,
            'type' => $this->type,
            'max_score' => $this->maxScore,
            'due_date' => $this->dueDate,
        ];
    }
}
