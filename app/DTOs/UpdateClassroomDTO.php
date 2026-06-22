<?php

namespace App\DTOs;

readonly class UpdateClassroomDTO
{
    public function __construct(
        public int $majorId,
        public string $name,
        public string $level,
        public int $capacity = 36,
    ) {}

    public function toArray(): array
    {
        return [
            'major_id' => $this->majorId,
            'name' => $this->name,
            'level' => $this->level,
            'capacity' => $this->capacity,
        ];
    }
}
