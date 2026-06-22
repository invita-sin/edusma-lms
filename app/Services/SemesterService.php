<?php

namespace App\Services;

use App\DTOs\CreateSemesterDTO;
use App\DTOs\UpdateSemesterDTO;
use App\Models\Semester;
use App\Repositories\SemesterRepository;

class SemesterService
{
    public function __construct(
        private readonly SemesterRepository $repository,
    ) {}

    public function create(CreateSemesterDTO $dto): Semester
    {
        if ($dto->isActive) {
            $this->repository->deactivateAll();
        }

        return $this->repository->create([
            'academic_year_id' => $dto->academicYearId,
            'name' => $dto->name,
            'is_active' => $dto->isActive,
        ]);
    }

    public function update(int $id, UpdateSemesterDTO $dto): Semester
    {
        if ($dto->isActive) {
            $this->repository->deactivateAll();
        }

        return $this->repository->update($id, [
            'academic_year_id' => $dto->academicYearId,
            'name' => $dto->name,
            'is_active' => $dto->isActive,
        ]);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    public function activate(int $id): Semester
    {
        $this->repository->deactivateAll();
        return $this->repository->update($id, ['is_active' => true]);
    }

    public function findById(int $id): ?Semester
    {
        return $this->repository->findById($id);
    }

    public function getActive(): ?Semester
    {
        return $this->repository->getActive();
    }
}
