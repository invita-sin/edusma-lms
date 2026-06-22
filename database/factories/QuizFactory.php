<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Quiz;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Quiz>
 */
class QuizFactory extends Factory
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
            'time_limit' => fake()->optional()->numberBetween(10, 120),
            'passing_score' => 70,
            'is_random' => false,
            'is_published' => false,
            'start_date' => fake()->optional()->dateTimeBetween('now', '+1 week'),
            'end_date' => fake()->optional()->dateTimeBetween('+1 week', '+1 month'),
        ];
    }
}
