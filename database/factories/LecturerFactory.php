<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lecturer>
 */
class LecturerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state(['role' => 'lecturer']),
            'department_id' => Department::factory(),
            'staff_id' => fake()->unique()->bothify('LEC-???-###'),
            'title' => fake()->randomElement(['Dr.', 'Prof.', 'Mr.', 'Ms.']),
            'qualification' => fake()->sentence(4),
            'office_location' => fake()->optional()->buildingNumber(),
        ];
    }
}
