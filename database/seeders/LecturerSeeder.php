<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LecturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lecturers = [
            [
                'email' => 'prof.smith@university.ac.ug',
                'name' => 'Prof. Alan Smith',
                'phone' => '+256 701 223 344',
                'department' => 'CS',
                'staff_id' => 'LEC-CS-001',
                'title' => 'Prof.',
                'qualification' => 'PhD in Computer Science',
                'office_location' => 'Block C, Room 304',
            ],
            [
                'email' => 'dr.muwanga@university.ac.ug',
                'name' => 'Dr. Peter Muwanga',
                'phone' => '+256 702 334 455',
                'department' => 'CS',
                'staff_id' => 'LEC-CS-002',
                'title' => 'Dr.',
                'qualification' => 'PhD in Software Engineering',
                'office_location' => 'Block C, Room 310',
            ],
            [
                'email' => 'dr.sarah@university.ac.ug',
                'name' => 'Dr. Sarah Namutebi',
                'phone' => '+256 703 445 566',
                'department' => 'ENG',
                'staff_id' => 'LEC-ENG-001',
                'title' => 'Dr.',
                'qualification' => 'PhD in Electrical Engineering',
                'office_location' => 'Engineering Complex, Room E-12',
            ],
        ];

        foreach ($lecturers as $lecturerData) {
            $user = User::firstOrCreate(
                ['email' => $lecturerData['email']],
                [
                    'name' => $lecturerData['name'],
                    'password' => Hash::make('password'),
                    'role' => 'lecturer',
                    'phone' => $lecturerData['phone'],
                ],
            );

            Lecturer::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'department_id' => Department::where('code', $lecturerData['department'])->firstOrFail()->id,
                    'staff_id' => $lecturerData['staff_id'],
                    'title' => $lecturerData['title'],
                    'qualification' => $lecturerData['qualification'],
                    'office_location' => $lecturerData['office_location'],
                ],
            );
        }
    }
}
