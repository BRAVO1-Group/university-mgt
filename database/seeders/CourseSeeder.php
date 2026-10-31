<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $courses = [
            [
                'title' => 'Database Systems',
                'code' => 'BIT101',
                'department_id' => 1
            ],
            [
                'title' => 'Web Development',
                'code' => 'BIT102',
                  'department_id' => 2
            ],
            [
                'title' => 'Computer Networks',
                'code' => 'BIT103',
                  'department_id' => 3
            ],
            [
                'title' => 'Software Engineering',
                'code' => 'BIT104',
                  'department_id' => 4
            ],
        ];

        foreach ($courses as $course) {
            Course::updateOrCreate(
                ['code' => $course['code']],
                $course
            );
        }
    }
}
