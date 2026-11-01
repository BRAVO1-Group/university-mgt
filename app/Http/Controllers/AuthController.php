<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Lecturer;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            /** @var User $user */
            $user = Auth::user();

            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'))->with('success', "Welcome back, {$user->name}!");
            }

            if ($user->isLecturer()) {
                return redirect()->intended(route('lecturer.dashboard'))->with('success', "Welcome back, {$user->name}!");
            }

            return redirect()->intended(route('student.dashboard'))->with('success', "Welcome back, {$user->name}!");
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegisterForm(): View
    {
        $departments = Department::orderBy('name')->get();

        return view('register', compact('departments'));
    }

    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['required', 'string', 'in:student,lecturer,admin'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'id_number' => ['nullable', 'string', 'max:50'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user = User::create([
            'name' => $request->string('name'),
            'email' => $request->string('email'),
            'role' => $request->string('role'),
            'phone' => $request->string('phone'),
            'password' => Hash::make($request->string('password')),
        ]);

        if ($user->role === 'student') {
            Student::create([
                'user_id' => $user->id,
                'department_id' => $request->input('department_id'),
                'student_id_number' => $request->input('id_number') ?: 'STU-'.date('Y').'-'.str_pad((string) $user->id, 3, '0', STR_PAD_LEFT),
                'program' => 'Undergraduate Degree',
                'year_of_study' => 1,
                'status' => 'active',
            ]);
        } elseif ($user->role === 'lecturer') {
            Lecturer::create([
                'user_id' => $user->id,
                'department_id' => $request->input('department_id'),
                'staff_id' => $request->input('id_number') ?: 'LEC-'.str_pad((string) $user->id, 4, '0', STR_PAD_LEFT),
                'title' => 'Lecturer',
                'office_location' => 'Faculty Building',
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('success', 'Account created successfully!');
        }

        if ($user->isLecturer()) {
            return redirect()->route('lecturer.dashboard')->with('success', 'Account created successfully!');
        }

        return redirect()->route('student.dashboard')->with('success', 'Account created successfully!');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'You have been signed out.');
    }
}
