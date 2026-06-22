<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            AcademicYearSeeder::class,
            SemesterSeeder::class,
            MajorSeeder::class,
            ClassroomSeeder::class,
            SubjectSeeder::class,
            TeacherSeeder::class,
            StudentSeeder::class,
            CourseSeeder::class,
            SettingSeeder::class,
            NotificationSeeder::class,
        ]);

        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@edusma.sch.id'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
            ]
        );
        $superAdmin->assignRole('super-admin');
    }
}

