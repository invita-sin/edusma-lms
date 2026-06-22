<?php

namespace App\Services;

use App\DTOs\CreateClassroomDTO;
use App\DTOs\UpdateClassroomDTO;
use App\Models\Classroom;
use App\Repositories\ClassroomRepository;

class ClassroomService
{
    public function __construct(
        private readonly ClassroomRepository $repository,
    ) {}

    public function create(CreateClassroomDTO $dto): Classroom
    {
        return $this->repository->create([
            'major_id' => $dto->majorId,
            'name' => $dto->name,
            'level' => $dto->level,
            'capacity' => $dto->capacity,
        ]);
    }

    public function update(int $id, UpdateClassroomDTO $dto): Classroom
    {
        return $this->repository->update($id, [
            'major_id' => $dto->majorId,
            'name' => $dto->name,
            'level' => $dto->level,
            'capacity' => $dto->capacity,
        ]);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    public function findById(int $id): ?Classroom
    {
        return $this->repository->findById($id);
    }
}
