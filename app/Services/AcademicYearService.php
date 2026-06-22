<?php

namespace App\Services;

use App\DTOs\CreateAcademicYearDTO;
use App\DTOs\UpdateAcademicYearDTO;
use App\Models\AcademicYear;
use App\Repositories\AcademicYearRepository;

class AcademicYearService
{
    public function __construct(
        private readonly AcademicYearRepository $repository,
    ) {}

    public function create(CreateAcademicYearDTO $dto): AcademicYear
    {
        if ($dto->isActive) {
            $this->repository->deactivateAll();
        }

        return $this->repository->create([
            'name' => $dto->name,
            'start_date' => $dto->startDate,
            'end_date' => $dto->endDate,
            'is_active' => $dto->isActive,
        ]);
    }

    public function update(int $id, UpdateAcademicYearDTO $dto): AcademicYear
    {
        if ($dto->isActive) {
            $this->repository->deactivateAll();
        }

        return $this->repository->update($id, [
            'name' => $dto->name,
            'start_date' => $dto->startDate,
            'end_date' => $dto->endDate,
            'is_active' => $dto->isActive,
        ]);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    public function activate(int $id): AcademicYear
    {
        $this->repository->deactivateAll();
        return $this->repository->update($id, ['is_active' => true]);
    }

    public function findById(int $id): ?AcademicYear
    {
        return $this->repository->findById($id);
    }

    public function getActive(): ?AcademicYear
    {
        return $this->repository->getActive();
    }
}
