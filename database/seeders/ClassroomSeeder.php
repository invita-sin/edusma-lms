<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Major;
use Illuminate\Database\Seeder;

class ClassroomSeeder extends Seeder
{
    public function run(): void
    {
        $majorIPA = Major::where('code', 'IPA')->first();
        $majorIPS = Major::where('code', 'IPS')->first();

        if (!$majorIPA || !$majorIPS) {
            return;
        }

        $classrooms = [
            ['major_id' => $majorIPA->id, 'name' => 'X IPA 1', 'level' => '10', 'capacity' => 36],
            ['major_id' => $majorIPA->id, 'name' => 'X IPA 2', 'level' => '10', 'capacity' => 36],
            ['major_id' => $majorIPS->id, 'name' => 'X IPS 1', 'level' => '10', 'capacity' => 36],
            ['major_id' => $majorIPA->id, 'name' => 'XI IPA 1', 'level' => '11', 'capacity' => 36],
            ['major_id' => $majorIPS->id, 'name' => 'XI IPS 1', 'level' => '11', 'capacity' => 36],
            ['major_id' => $majorIPA->id, 'name' => 'XII IPA 1', 'level' => '12', 'capacity' => 36],
            ['major_id' => $majorIPS->id, 'name' => 'XII IPS 1', 'level' => '12', 'capacity' => 36],
        ];

        foreach ($classrooms as $classroom) {
            Classroom::firstOrCreate(
                ['name' => $classroom['name']],
                $classroom,
            );
        }
    }
}
