<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $schoolSettings = [
            'school_name' => 'EduSMA',
            'school_address' => 'Jl. Pendidikan No. 1',
            'school_phone' => '021-12345678',
            'school_email' => 'info@edusma.sch.id',
            'school_logo' => null,
            'school_npsn' => '12345678',
        ];

        $academicSettings = [
            'passing_grade' => '75',
            'max_grade' => '100',
            'grade_a_min' => '92',
            'grade_b_min' => '83',
            'grade_c_min' => '75',
            'grade_d_min' => '60',
        ];

        foreach ($schoolSettings as $key => $value) {
            Setting::setValue($key, $value, 'school');
        }

        foreach ($academicSettings as $key => $value) {
            Setting::setValue($key, $value, 'academic');
        }
    }
}
