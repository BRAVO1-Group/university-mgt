<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            ['alex.kamau@student.ac.ug', 'Alex Kamau', '+256 771 998 811', 'CS', 'STU-2025-001', 'BSc Computer Science', 2],
            ['grace.nakato@student.ac.ug', 'Grace Nakato', '+256 772 887 722', 'CS', 'STU-2025-002', 'BSc Software Engineering', 1],
            ['john.okello@student.ac.ug', 'John Okello', '+256 773 776 633', 'ENG', 'STU-2024-045', 'BSc Electrical Engineering', 3],
            ['mary.atuhairwe@student.ac.ug', 'Mary Atuhairwe', '+256 774 665 544', 'BUS', 'STU-2025-089', 'Bachelor of Business Administration', 2],
            ['faith.abadde@student.ac.ug', 'Faith Abadde', '+256 775 554 433', 'CS', 'STU-2025-003', 'BSc Computer Science', 1],
        ];

        foreach ($students as [$email, $name, $phone, $departmentCode, $studentNumber, $program, $year]) {
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => Hash::make('password'),
                    'role' => 'student',
                    'phone' => $phone,
                ],
            );

            Student::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'department_id' => Department::where('code', $departmentCode)->firstOrFail()->id,
                    'student_id_number' => $studentNumber,
                    'program' => $program,
                    'year_of_study' => $year,
                    'status' => 'active',
                ],
            );
        }
    }
}
