<?php

namespace Database\Factories;

use App\Models\Classroom;
use App\Models\Major;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Classroom>
 */
class ClassroomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'major_id' => Major::factory(),
            'name' => fake()->randomElement(['A', 'B', 'C', 'D']) . ' ' . fake()->word(),
            'level' => (string) fake()->randomElement(['10', '11', '12']),
            'capacity' => 36,
        ];
    }
}
