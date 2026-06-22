<?php

namespace App\DTOs;

readonly class CreateSemesterDTO
{
    public function __construct(
        public int $academicYearId,
        public string $name,
        public bool $isActive = false,
    ) {}

    public function toArray(): array
    {
        return [
            'academic_year_id' => $this->academicYearId,
            'name' => $this->name,
            'is_active' => $this->isActive,
        ];
    }
}
