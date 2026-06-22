<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Material;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Material>
 */
class MaterialFactory extends Factory
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
            'title' => fake()->sentence(4),
            'description' => fake()->optional()->paragraph(),
            'file_path' => null,
            'file_type' => null,
            'file_size' => null,
            'url' => fake()->optional()->url(),
            'order' => fake()->numberBetween(0, 10),
        ];
    }
}
