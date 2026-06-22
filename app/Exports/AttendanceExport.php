<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(
        private ?int $courseId = null,
        private ?string $startDate = null,
        private ?string $endDate = null,
    ) {}

    public function collection()
    {
        $query = Attendance::with('student.user', 'course');

        if ($this->courseId) {
            $query->where('course_id', $this->courseId);
        }
        if ($this->startDate) {
            $query->where('date', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->where('date', '<=', $this->endDate);
        }

        return $query->orderBy('date', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'NISN',
            'Nama Siswa',
            'Course',
            'Tanggal',
            'Status',
            'Catatan',
        ];
    }

    public function map($attendance): array
    {
        $statusLabels = [
            'present' => 'Hadir',
            'absent' => 'Alpa',
            'sick' => 'Sakit',
            'permission' => 'Izin',
            'late' => 'Terlambat',
        ];

        return [
            $attendance->student->nisn,
            $attendance->student->user->name,
            $attendance->course->name,
            $attendance->date->format('d/m/Y'),
            $statusLabels[$attendance->status] ?? $attendance->status,
            $attendance->notes,
        ];
    }
}
