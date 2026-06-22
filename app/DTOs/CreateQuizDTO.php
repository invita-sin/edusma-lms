<?php

namespace App\DTOs;

use Illuminate\Support\Carbon;

readonly class CreateQuizDTO
{
    public function __construct(
        public int $courseId,
        public int $teacherId,
        public string $title,
        public ?string $description = null,
        public ?int $timeLimit = null,
        public int $passingScore = 70,
        public bool $isRandom = false,
        public bool $isPublished = false,
        public ?Carbon $startDate = null,
        public ?Carbon $endDate = null,
    ) {}

    public function toArray(): array
    {
        return [
            'course_id' => $this->courseId,
            'teacher_id' => $this->teacherId,
            'title' => $this->title,
            'description' => $this->description,
            'time_limit' => $this->timeLimit,
            'passing_score' => $this->passingScore,
            'is_random' => $this->isRandom,
            'is_published' => $this->isPublished,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
        ];
    }
}
