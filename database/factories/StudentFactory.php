<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
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
            'nisn' => fake()->unique()->numerify('##########'),
            'nis' => fake()->unique()->numerify('########'),
            'classroom_id' => \App\Models\Classroom::inRandomOrder()->first()?->id,
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'gender' => fake()->randomElement(['L', 'P']),
            'birth_date' => fake()->optional()->date(),
        ];
    }
}
