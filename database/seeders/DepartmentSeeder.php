<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'code' => 'CS',
                'name' => 'Computer Science & Software Engineering',
                'description' => 'Computing, information technology, and artificial intelligence.',
                'building' => 'Block C, Technology Wing, 3rd Floor',
            ],
            [
                'code' => 'ENG',
                'name' => 'Electrical & Electronic Engineering',
                'description' => 'Power systems, electronics, and telecommunications.',
                'building' => 'Engineering Complex, Level 1',
            ],
            [
                'code' => 'BUS',
                'name' => 'Business Administration & Management',
                'description' => 'Business, finance, accounting, and strategic management.',
                'building' => 'Senate House, Ground Floor',
            ],
        ];

        foreach ($departments as $department) {
            Department::updateOrCreate(
                ['code' => $department['code']],
                $department,
            );
        }
    }
}
