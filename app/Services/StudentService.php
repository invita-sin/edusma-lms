<?php

namespace App\Services;

use App\DTOs\CreateStudentDTO;
use App\DTOs\UpdateStudentDTO;
use App\Models\Student;
use App\Repositories\StudentRepository;

class StudentService
{
    public function __construct(
        private readonly StudentRepository $repository,
    ) {}

    public function create(CreateStudentDTO $dto): Student
    {
        return $this->repository->create([
            'user_id' => $dto->userId,
            'classroom_id' => $dto->classroomId,
            'nisn' => $dto->nisn,
            'nis' => $dto->nis,
            'phone' => $dto->phone,
            'address' => $dto->address,
            'gender' => $dto->gender,
            'birth_date' => $dto->birthDate,
        ]);
    }

    public function update(int $id, UpdateStudentDTO $dto): Student
    {
        return $this->repository->update($id, [
            'user_id' => $dto->userId,
            'classroom_id' => $dto->classroomId,
            'nisn' => $dto->nisn,
            'nis' => $dto->nis,
            'phone' => $dto->phone,
            'address' => $dto->address,
            'gender' => $dto->gender,
            'birth_date' => $dto->birthDate,
        ]);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    public function findById(int $id): ?Student
    {
        return $this->repository->findById($id);
    }

    public function findByUserId(int $userId): ?Student
    {
        return $this->repository->findByUserId($userId);
    }
}
