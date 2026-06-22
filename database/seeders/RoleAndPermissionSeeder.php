<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view_users', 'create_users', 'update_users', 'delete_users',
            'view_teachers', 'create_teachers', 'update_teachers', 'delete_teachers',
            'view_students', 'create_students', 'update_students', 'delete_students',
            'view_courses', 'create_courses', 'update_courses', 'delete_courses',
            'view_materials', 'create_materials', 'update_materials', 'delete_materials',
            'view_assignments', 'create_assignments', 'update_assignments', 'delete_assignments',
            'view_quizzes', 'create_quizzes', 'update_quizzes', 'delete_quizzes',
            'view_attendances', 'create_attendances', 'update_attendances', 'delete_attendances',
            'view_grades', 'create_grades', 'update_grades', 'delete_grades',
            'view_academic_years', 'create_academic_years', 'update_academic_years', 'delete_academic_years',
            'view_semesters', 'create_semesters', 'update_semesters', 'delete_semesters',
            'view_majors', 'create_majors', 'update_majors', 'delete_majors',
            'view_classrooms', 'create_classrooms', 'update_classrooms', 'delete_classrooms',
            'view_subjects', 'create_subjects', 'update_subjects', 'delete_subjects',
            'view_reports', 'export_reports',
            'view_settings', 'update_settings',
            'view_activity_logs',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo([
            'view_teachers', 'create_teachers', 'update_teachers', 'delete_teachers',
            'view_students', 'create_students', 'update_students', 'delete_students',
            'view_courses', 'create_courses', 'update_courses', 'delete_courses',
            'view_materials', 'create_materials', 'update_materials', 'delete_materials',
            'view_assignments', 'create_assignments', 'update_assignments', 'delete_assignments',
            'view_quizzes', 'create_quizzes', 'update_quizzes', 'delete_quizzes',
            'view_attendances', 'create_attendances', 'update_attendances', 'delete_attendances',
            'view_grades', 'create_grades', 'update_grades', 'delete_grades',
            'view_academic_years', 'create_academic_years', 'update_academic_years', 'delete_academic_years',
            'view_semesters', 'create_semesters', 'update_semesters', 'delete_semesters',
            'view_majors', 'create_majors', 'update_majors', 'delete_majors',
            'view_classrooms', 'create_classrooms', 'update_classrooms', 'delete_classrooms',
            'view_subjects', 'create_subjects', 'update_subjects', 'delete_subjects',
            'view_reports', 'export_reports',
            'view_settings', 'update_settings',
        ]);

        $teacher = Role::firstOrCreate(['name' => 'teacher']);
        $teacher->givePermissionTo([
            'view_courses', 'create_courses', 'update_courses', 'delete_courses',
            'view_materials', 'create_materials', 'update_materials', 'delete_materials',
            'view_assignments', 'create_assignments', 'update_assignments', 'delete_assignments',
            'view_quizzes', 'create_quizzes', 'update_quizzes', 'delete_quizzes',
            'view_attendances', 'create_attendances', 'update_attendances',
            'view_grades', 'create_grades', 'update_grades',
            'view_reports',
        ]);

        $student = Role::firstOrCreate(['name' => 'student']);
        $student->givePermissionTo([
            'view_courses',
            'view_materials',
            'view_assignments',
            'view_quizzes',
            'view_grades',
            'view_attendances',
        ]);
    }
}
