<?php

namespace App\DTOs;

readonly class UpdateMajorDTO
{
    public function __construct(
        public string $code,
        public string $name,
        public ?string $description = null,
    ) {}

    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
