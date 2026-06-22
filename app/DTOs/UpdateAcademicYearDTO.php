<?php

namespace App\DTOs;

use Illuminate\Support\Carbon;

readonly class UpdateAcademicYearDTO
{
    public function __construct(
        public string $name,
        public Carbon $startDate,
        public Carbon $endDate,
        public bool $isActive = false,
    ) {}

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'is_active' => $this->isActive,
        ];
    }
}
