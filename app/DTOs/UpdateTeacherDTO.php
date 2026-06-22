<?php

namespace App\DTOs;

use Illuminate\Support\Carbon;

readonly class UpdateTeacherDTO
{
    public function __construct(
        public int $userId,
        public string $nip,
        public ?string $nuptk = null,
        public ?string $phone = null,
        public ?string $address = null,
        public string $gender = 'L',
        public ?string $specialization = null,
        public ?Carbon $birthDate = null,
    ) {}

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'nip' => $this->nip,
            'nuptk' => $this->nuptk,
            'phone' => $this->phone,
            'address' => $this->address,
            'gender' => $this->gender,
            'specialization' => $this->specialization,
            'birth_date' => $this->birthDate,
        ];
    }
}
