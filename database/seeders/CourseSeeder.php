<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\Course;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $academicYear = AcademicYear::first();
        $semester = Semester::first();
        $teacher = Teacher::first();

        if (!$academicYear || !$semester || !$teacher) {
            return;
        }

        $classrooms = Classroom::all();
        $subjects = Subject::take(3)->get();

        foreach ($classrooms as $classroom) {
            foreach ($subjects as $subject) {
                $code = "{$subject->code}-{$classroom->name}-{$academicYear->name}";
                $code = str_replace(['/', ' '], '', $code);

                Course::firstOrCreate(
                    ['code' => $code],
                    [
                        'academic_year_id' => $academicYear->id,
                        'semester_id' => $semester->id,
                        'classroom_id' => $classroom->id,
                        'subject_id' => $subject->id,
                        'teacher_id' => $teacher->id,
                        'code' => $code,
                        'name' => "{$subject->name} - {$classroom->name}",
                        'total_hours' => 36,
                    ]
                );
            }
        }
    }
}
