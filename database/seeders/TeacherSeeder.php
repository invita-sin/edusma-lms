<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'teacher@edusma.sch.id'],
            [
                'name' => 'Guru Contoh',
                'password' => bcrypt('password'),
            ]
        );
        $user->assignRole('teacher');

        Teacher::create([
            'user_id' => $user->id,
            'nip' => '1234567890',
            'nuptk' => '9876543210',
            'phone' => '08123456789',
            'address' => 'Jl. Contoh No. 1',
            'gender' => 'L',
            'specialization' => 'Matematika',
            'birth_date' => '1990-01-01',
        ]);
    }
}
