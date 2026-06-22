<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Student::with('user', 'classroom')->get();
    }

    public function headings(): array
    {
        return [
            'NISN',
            'NIS',
            'Nama',
            'Email',
            'Kelas',
            'Jenis Kelamin',
            'Telepon',
            'Alamat',
        ];
    }

    public function map($student): array
    {
        return [
            $student->nisn,
            $student->nis,
            $student->user->name,
            $student->user->email,
            $student->classroom?->name,
            $student->gender === 'L' ? 'Laki-laki' : 'Perempuan',
            $student->phone,
            $student->address,
        ];
    }
}
