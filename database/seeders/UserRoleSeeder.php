<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@university.ac.ug'],
            [
                'name' => 'Dean of Academics (Admin)',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '+256 700 111 222',
            ],
        );
    }
}
