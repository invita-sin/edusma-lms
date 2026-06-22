<?php

namespace App\DTOs;

use Illuminate\Support\Carbon;

readonly class CreateStudentDTO
{
    public function __construct(
        public int $userId,
        public string $nisn,
        public string $nis,
        public ?int $classroomId = null,
        public ?string $phone = null,
        public ?string $address = null,
        public string $gender = 'L',
        public ?Carbon $birthDate = null,
    ) {}

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'nisn' => $this->nisn,
            'nis' => $this->nis,
            'classroom_id' => $this->classroomId,
            'phone' => $this->phone,
            'address' => $this->address,
            'gender' => $this->gender,
            'birth_date' => $this->birthDate,
        ];
    }
}
