<?php

namespace Database\Factories;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'student_id' => Student::factory(),
            'teacher_id' => Teacher::factory(),
            'date' => fake()->date(),
            'status' => fake()->randomElement(['present', 'absent', 'sick', 'permission', 'late']),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
