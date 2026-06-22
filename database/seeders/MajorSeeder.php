<?php

namespace Database\Seeders;

use App\Models\Major;
use Illuminate\Database\Seeder;

class MajorSeeder extends Seeder
{
    public function run(): void
    {
        $majors = [
            ['code' => 'IPA', 'name' => 'Ilmu Pengetahuan Alam', 'description' => 'Jurusan IPA'],
            ['code' => 'IPS', 'name' => 'Ilmu Pengetahuan Sosial', 'description' => 'Jurusan IPS'],
            ['code' => 'BHS', 'name' => 'Bahasa', 'description' => 'Jurusan Bahasa'],
            ['code' => 'AGM', 'name' => 'Agama', 'description' => 'Jurusan Keagamaan'],
        ];

        foreach ($majors as $major) {
            Major::create($major);
        }
    }
}
