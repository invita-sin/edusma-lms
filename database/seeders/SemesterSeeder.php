<?php

namespace Database\Seeders;

use App\Models\Semester;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    public function run(): void
    {
        $academicYear = \App\Models\AcademicYear::first();

        if (!$academicYear) {
            return;
        }

        Semester::create([
            'academic_year_id' => $academicYear->id,
            'name' => 'Ganjil',
            'is_active' => true,
        ]);

        Semester::create([
            'academic_year_id' => $academicYear->id,
            'name' => 'Genap',
            'is_active' => false,
        ]);
    }
}
