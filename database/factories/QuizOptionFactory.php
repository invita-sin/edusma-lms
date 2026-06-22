<?php

namespace Database\Factories;

use App\Models\QuizOption;
use App\Models\QuizQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<QuizOption>
 */
class QuizOptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quiz_question_id' => QuizQuestion::factory(),
            'option' => fake()->sentence(4),
            'is_correct' => false,
        ];
    }

    public function correct(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_correct' => true,
        ]);
    }
}
