<?php

namespace Database\Factories;

use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\Course;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'academic_year_id' => AcademicYear::factory(),
            'semester_id' => Semester::factory(),
            'classroom_id' => Classroom::factory(),
            'subject_id' => Subject::factory(),
            'teacher_id' => Teacher::factory(),
            'code' => fake()->unique()->bothify('CRS-####'),
            'name' => fake()->words(3, true),
            'description' => fake()->optional()->sentence(),
            'total_hours' => fake()->numberBetween(1, 6),
        ];
    }
}
