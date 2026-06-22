<?php

namespace Database\Factories;

use App\Models\AcademicYear;
use App\Models\Course;
use App\Models\Grade;
use App\Models\Semester;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Grade>
 */
class GradeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'course_id' => Course::factory(),
            'academic_year_id' => AcademicYear::factory(),
            'semester_id' => Semester::factory(),
            'assignment_score' => fake()->optional()->randomFloat(2, 0, 100),
            'quiz_score' => fake()->optional()->randomFloat(2, 0, 100),
            'midterm_score' => fake()->optional()->randomFloat(2, 0, 100),
            'final_exam_score' => fake()->optional()->randomFloat(2, 0, 100),
            'total_score' => null,
            'grade' => null,
            'notes' => null,
        ];
    }
}
