<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

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
                'email' => 'admin@gmail.com',
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

        foreach ($users as $userData) {
            $role = Role::where('name', $userData['role'])->firstOrFail();

            User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => $userData['password'],
                    'role_id' => $role->id,
                ]
            );
        }
    }
}
