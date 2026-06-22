<?php

namespace App\Services;

use App\DTOs\CreateCourseDTO;
use App\DTOs\UpdateCourseDTO;
use App\Models\Course;
use App\Repositories\CourseRepository;

class CourseService
{
    public function __construct(
        private readonly CourseRepository $repository,
    ) {}

    public function create(CreateCourseDTO $dto): Course
    {
        return $this->repository->create([
            'academic_year_id' => $dto->academicYearId,
            'semester_id' => $dto->semesterId,
            'classroom_id' => $dto->classroomId,
            'subject_id' => $dto->subjectId,
            'teacher_id' => $dto->teacherId,
            'code' => $dto->code,
            'name' => $dto->name,
            'description' => $dto->description,
            'total_hours' => $dto->totalHours,
        ]);
    }

    public function update(int $id, UpdateCourseDTO $dto): Course
    {
        return $this->repository->update($id, [
            'academic_year_id' => $dto->academicYearId,
            'semester_id' => $dto->semesterId,
            'classroom_id' => $dto->classroomId,
            'subject_id' => $dto->subjectId,
            'teacher_id' => $dto->teacherId,
            'code' => $dto->code,
            'name' => $dto->name,
            'description' => $dto->description,
            'total_hours' => $dto->totalHours,
        ]);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    public function findById(int $id): ?Course
    {
        return $this->repository->findById($id);
    }

    public function getByTeacher(int $teacherId): \Illuminate\Database\Eloquent\Collection
    {
        return $this->repository->getByTeacher($teacherId);
    }
}
