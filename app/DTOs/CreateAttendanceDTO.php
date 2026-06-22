<?php

namespace App\DTOs;

use Illuminate\Support\Carbon;

readonly class CreateAttendanceDTO
{
    public function __construct(
        public int $courseId,
        public int $studentId,
        public int $teacherId,
        public Carbon $date,
        public string $status = 'present',
        public ?string $notes = null,
    ) {}

    public function toArray(): array
    {
        return [
            'course_id' => $this->courseId,
            'student_id' => $this->studentId,
            'teacher_id' => $this->teacherId,
            'date' => $this->date,
            'status' => $this->status,
            'notes' => $this->notes,
        ];
    }
}
