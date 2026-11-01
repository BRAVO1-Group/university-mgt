<?php

namespace Database\Factories;

use App\Models\Department;
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
            'user_id' => User::factory()->state(['role' => 'student']),
            'department_id' => Department::factory(),
            'student_id_number' => fake()->unique()->bothify('STU-####-###'),
            'program' => fake()->jobTitle(),
            'year_of_study' => fake()->numberBetween(1, 6),
            'status' => 'active',
        ];
    }
}
