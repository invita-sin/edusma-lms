<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'student@edusma.sch.id'],
            [
                'name' => 'Siswa Contoh',
                'password' => bcrypt('password'),
            ]
        );
        $user->assignRole('student');

        Student::create([
            'user_id' => $user->id,
            'classroom_id' => Classroom::first()?->id,
            'nisn' => '1234567890',
            'nis' => '9876543210',
            'phone' => '08123456788',
            'address' => 'Jl. Siswa No. 1',
            'gender' => 'P',
            'birth_date' => '2008-01-01',
        ]);
    }
}
