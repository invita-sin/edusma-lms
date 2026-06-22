<?php

namespace Database\Factories;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'nip' => fake()->unique()->numerify('19##########'),
            'nuptk' => fake()->optional()->numerify('20##########'),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'gender' => fake()->randomElement(['L', 'P']),
            'specialization' => fake()->optional()->jobTitle(),
            'birth_date' => fake()->optional()->date(),
        ];
    }
}
