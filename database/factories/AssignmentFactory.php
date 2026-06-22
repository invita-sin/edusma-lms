<?php

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Assignment>
 */
class AssignmentFactory extends Factory
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
            'teacher_id' => Teacher::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->optional()->paragraph(),
            'file_path' => null,
            'type' => fake()->randomElement(['essay', 'file_upload']),
            'max_score' => 100,
            'due_date' => fake()->dateTimeBetween('+1 day', '+1 month'),
        ];
    }
}
