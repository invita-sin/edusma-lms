<?php

namespace App\Services;

use App\DTOs\CreateAttendanceDTO;
use App\Models\Attendance;
use App\Repositories\AttendanceRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AttendanceService
{
    public function __construct(
        private readonly AttendanceRepository $repository,
    ) {}

    public function record(CreateAttendanceDTO $dto): Attendance
    {
        return $this->repository->createOrUpdate([
            'course_id' => $dto->courseId,
            'student_id' => $dto->studentId,
            'teacher_id' => $dto->teacherId,
            'date' => $dto->date->toDateString(),
            'status' => $dto->status,
            'notes' => $dto->notes,
        ]);
    }

    public function recordBulk(int $courseId, int $teacherId, Carbon $date, array $attendances): void
    {
        DB::transaction(function () use ($courseId, $teacherId, $date, $attendances) {
            foreach ($attendances as $att) {
                $this->repository->createOrUpdate([
                    'course_id' => $courseId,
                    'student_id' => $att['student_id'],
                    'teacher_id' => $teacherId,
                    'date' => $date->toDateString(),
                    'status' => $att['status'],
                    'notes' => $att['notes'] ?? null,
                ]);
            }
        });
    }

    public function findById(int $id): ?Attendance
    {
        return $this->repository->findById($id);
    }

    public function getByCourseAndDate(int $courseId, Carbon $date): \Illuminate\Database\Eloquent\Collection
    {
        return $this->repository->getByCourseAndDate($courseId, $date);
    }
}
