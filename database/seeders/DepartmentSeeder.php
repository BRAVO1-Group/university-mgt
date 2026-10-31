<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $departments = [
            ['name' => 'Information Technology',
             'code' => 'IT',
            ],

            ['name' => 'Computer Science',
             'code'=>'CS',
            ],

            ['name' => 'Business Administration',
            'code'=>'BA',
            ],
        ];

        foreach ($departments as $department) {
            Department::updateOrCreate(
                ['name' => $department['name']],
                $department
            );
        }
    }
}
