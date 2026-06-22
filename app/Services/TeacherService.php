<?php

namespace App\Services;

use App\DTOs\CreateTeacherDTO;
use App\DTOs\UpdateTeacherDTO;
use App\Models\Teacher;
use App\Repositories\TeacherRepository;

class TeacherService
{
    public function __construct(
        private readonly TeacherRepository $repository,
    ) {}

    public function create(CreateTeacherDTO $dto): Teacher
    {
        return $this->repository->create([
            'user_id' => $dto->userId,
            'nip' => $dto->nip,
            'nuptk' => $dto->nuptk,
            'phone' => $dto->phone,
            'address' => $dto->address,
            'gender' => $dto->gender,
            'specialization' => $dto->specialization,
            'birth_date' => $dto->birthDate,
        ]);
    }

    public function update(int $id, UpdateTeacherDTO $dto): Teacher
    {
        return $this->repository->update($id, [
            'user_id' => $dto->userId,
            'nip' => $dto->nip,
            'nuptk' => $dto->nuptk,
            'phone' => $dto->phone,
            'address' => $dto->address,
            'gender' => $dto->gender,
            'specialization' => $dto->specialization,
            'birth_date' => $dto->birthDate,
        ]);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    public function findById(int $id): ?Teacher
    {
        return $this->repository->findById($id);
    }

    public function findByUserId(int $userId): ?Teacher
    {
        return $this->repository->findByUserId($userId);
    }
}
