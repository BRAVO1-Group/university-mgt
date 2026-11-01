<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Lecturer;
use App\Models\Role;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Muwanga samuel',
                'email' => 'admin1@gmail.com',
                'password' => Hash::make('Admin123'),
                'role' => 'Admin',
            ],
            [
                'name' => 'peterson',
                'email' => 'lecturer@gmail.com',
                'password' => Hash::make('Lecturer123'),
                'role' => 'Lecturer',
            ],
            [
                'name' => 'Mukama shafiq',
                'email' => 'student@gmail.com',
                'password' => Hash::make('Student123'),
                'role' => 'Student',
            ],
        ];

        $dept = Department::first();

        foreach ($users as $userData) {
            $role = Role::where('name', $userData['role'])->first();

            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => $userData['password'],
                    'role_id' => $role?->id,
                    'role' => strtolower($userData['role']),
                ]
            );

            if ($user->isLecturer() && ! $user->lecturer) {
                Lecturer::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'staff_id' => 'LEC-'.str_pad((string) $user->id, 4, '0', STR_PAD_LEFT),
                        'title' => 'Lecturer',
                        'qualification' => 'Master of Science in Information Technology',
                        'office_location' => 'Faculty Building, Room 201',
                        'department_id' => $dept?->id,
                    ]
                );
            } elseif ($user->isStudent() && ! $user->student) {
                Student::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'student_id_number' => 'STU-'.date('Y').'-'.str_pad((string) $user->id, 3, '0', STR_PAD_LEFT),
                        'program' => 'BSc Information Technology',
                        'year_of_study' => 1,
                        'status' => 'active',
                        'department_id' => $dept?->id,
                    ]
                );
            }
        }
    }
}
