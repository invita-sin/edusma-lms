<?php

namespace App\Services;

use App\DTOs\CreateMajorDTO;
use App\DTOs\UpdateMajorDTO;
use App\Models\Major;
use App\Repositories\MajorRepository;

class MajorService
{
    public function __construct(
        private readonly MajorRepository $repository,
    ) {}

    public function create(CreateMajorDTO $dto): Major
    {
        return $this->repository->create([
            'code' => $dto->code,
            'name' => $dto->name,
            'description' => $dto->description,
        ]);
    }

    public function update(int $id, UpdateMajorDTO $dto): Major
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

    public function findById(int $id): ?Major
    {
        return $this->repository->findById($id);
    }

    public function findByCode(string $code): ?Major
    {
        return $this->repository->findByCode($code);
    }
}
