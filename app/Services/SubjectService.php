<?php

namespace App\Services;

use App\DTOs\CreateSubjectDTO;
use App\DTOs\UpdateSubjectDTO;
use App\Models\Subject;
use App\Repositories\SubjectRepository;

class SubjectService
{
    public function __construct(
        private readonly SubjectRepository $repository,
    ) {}

    public function create(CreateSubjectDTO $dto): Subject
    {
        return $this->repository->create([
            'code' => $dto->code,
            'name' => $dto->name,
            'description' => $dto->description,
        ]);
    }

    public function update(int $id, UpdateSubjectDTO $dto): Subject
    {
        return $this->repository->update($id, [
            'code' => $dto->code,
            'name' => $dto->name,
            'description' => $dto->description,
        ]);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    public function findById(int $id): ?Subject
    {
        return $this->repository->findById($id);
    }

    public function findByCode(string $code): ?Subject
    {
        return $this->repository->findByCode($code);
    }
}
