<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            ['code' => 'MTK', 'name' => 'Matematika Wajib', 'description' => null],
            ['code' => 'MTKL', 'name' => 'Matematika Lanjutan', 'description' => null],
            ['code' => 'BIN', 'name' => 'Bahasa Indonesia', 'description' => null],
            ['code' => 'BING', 'name' => 'Bahasa Inggris', 'description' => null],
            ['code' => 'FIS', 'name' => 'Fisika', 'description' => null],
            ['code' => 'KIM', 'name' => 'Kimia', 'description' => null],
            ['code' => 'BIO', 'name' => 'Biologi', 'description' => null],
            ['code' => 'SEJ', 'name' => 'Sejarah', 'description' => null],
            ['code' => 'GEO', 'name' => 'Geografi', 'description' => null],
            ['code' => 'EKO', 'name' => 'Ekonomi', 'description' => null],
            ['code' => 'SOS', 'name' => 'Sosiologi', 'description' => null],
            ['code' => 'PKN', 'name' => 'Pendidikan Kewarganegaraan', 'description' => null],
            ['code' => 'PAI', 'name' => 'Pendidikan Agama Islam', 'description' => null],
            ['code' => 'PJOK', 'name' => 'Pendidikan Jasmani', 'description' => null],
            ['code' => 'SBK', 'name' => 'Seni Budaya', 'description' => null],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}
