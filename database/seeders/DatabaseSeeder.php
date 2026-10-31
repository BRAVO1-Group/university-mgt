<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
    RoleSeeder::class,
    UserSeeder::class,
    DepartmentSeeder::class,
    UniversitySeeder::class,
    StudentSeeder::class,
    LecturerSeeder::class,
    CourseSeeder::class,
    CourseRegistrationSeeder::class,
]);
    }
}
