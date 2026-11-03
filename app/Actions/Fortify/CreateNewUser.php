<?php

namespace App\Actions\Fortify;

use App\Models\Department;
use App\Models\Role;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $studentRole = Role::whereIn('name', ['Student', 'student'])->first();
        $dept = Department::first();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role' => 'student',
            'role_id' => $studentRole?->id,
        ]);

        Student::create([
            'user_id' => $user->id,
            'department_id' => $dept?->id,
            'student_id_number' => 'STU-'.date('Y').'-'.str_pad((string) $user->id, 3, '0', STR_PAD_LEFT),
            'program' => 'BSc Computer Science',
            'year_of_study' => 1,
            'status' => 'active',
        ]);

        return $user;
    }
}
