<?php

namespace App\DTOs;

readonly class CreateQuestionDTO
{
    public function __construct(
        public int $quizId,
        public string $question,
        public string $type = 'multiple_choice',
        public int $points = 1,
        public int $order = 0,
        public ?array $options = null,
    ) {}

    public function toArray(): array
    {
        return [
            'quiz_id' => $this->quizId,
            'question' => $this->question,
            'type' => $this->type,
            'points' => $this->points,
            'order' => $this->order,
            'options' => $this->options,
        ];
    }
}
