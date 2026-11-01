<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Department;
use App\Models\Lecturer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'department_id' => Department::factory(),
            'lecturer_id' => Lecturer::factory(),
            'code' => fake()->unique()->bothify('???###'),
            'title' => fake()->unique()->words(3, true),
            'description' => fake()->sentence(),
            'credits' => fake()->numberBetween(1, 6),
            'semester' => 'Semester 1',
            'academic_year' => '2025/2026',
            'max_capacity' => fake()->numberBetween(20, 100),
            'room' => fake()->optional()->bothify('Room ##'),
            'schedule' => fake()->optional()->dayOfWeek().' '.fake()->time('H:i'),
        ];
    }
}
