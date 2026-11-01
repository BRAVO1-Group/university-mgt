<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UniversitySeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            DepartmentSeeder::class,
            UserRoleSeeder::class,
            LecturerSeeder::class,
            StudentSeeder::class,
            CourseSeeder::class,
            CourseRegistrationSeeder::class,
        ]);
    }
}
