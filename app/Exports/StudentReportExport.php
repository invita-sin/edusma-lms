<?php

namespace App\Exports;

use App\Models\Grade;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentReportExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(
        private int $studentId,
    ) {}

    public function collection()
    {
        return Grade::where('student_id', $this->studentId)
            ->with('course', 'semester', 'academicYear')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Course',
            'Tahun Ajaran',
            'Semester',
            'Nilai Tugas (20%)',
            'Nilai Quiz (20%)',
            'Nilai UTS (30%)',
            'Nilai UAS (30%)',
            'Total',
            'Grade',
        ];
    }

    public function map($grade): array
    {
        return [
            $grade->course->name,
            $grade->academicYear->name,
            $grade->semester->name,
            $grade->assignment_score,
            $grade->quiz_score,
            $grade->midterm_score,
            $grade->final_exam_score,
            $grade->total_score,
            $grade->grade,
        ];
    }
}
