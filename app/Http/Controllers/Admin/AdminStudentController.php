<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminStudentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Student::with(['user', 'department', 'courseRegistrations.course']);

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('student_id_number', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->input('department_id'));
        }

        if ($request->filled('year')) {
            $query->where('year_of_study', $request->input('year'));
        }

        $students = $query->latest()->paginate(10)->withQueryString();
        $departments = Department::orderBy('name')->get();

        return view('admin.students.index', compact('students', 'departments'));
    }

    public function create(): View
    {
        $departments = Department::orderBy('name')->get();

        return view('admin.students.create', compact('departments'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'student_id_number' => ['required', 'string', 'max:50', 'unique:students,student_id_number'],
            'department_id' => ['required', 'exists:departments,id'],
            'program' => ['required', 'string', 'max:255'],
            'year_of_study' => ['required', 'integer', 'min:1', 'max:7'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'student',
                'phone' => $validated['phone'] ?? null,
            ]);

            Student::create([
                'user_id' => $user->id,
                'department_id' => $validated['department_id'],
                'student_id_number' => $validated['student_id_number'],
                'program' => $validated['program'],
                'year_of_study' => $validated['year_of_study'],
                'status' => 'active',
            ]);
        });

        return redirect()->route('admin.students.index')->with('success', 'Student registered successfully.');
    }

    public function edit(Student $student): View
    {
        $student->load(['user', 'department']);
        $departments = Department::orderBy('name')->get();

        return view('admin.students.edit', compact('student', 'departments'));
    }

    public function update(Request $request, Student $student): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$student->user_id],
            'student_id_number' => ['required', 'string', 'max:50', 'unique:students,student_id_number,'.$student->id],
            'department_id' => ['required', 'exists:departments,id'],
            'program' => ['required', 'string', 'max:255'],
            'year_of_study' => ['required', 'integer', 'min:1', 'max:7'],
            'status' => ['required', 'string', 'in:active,graduated,suspended'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        DB::transaction(function () use ($validated, $student) {
            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
            ];

            if (! empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $student->user->update($userData);

            $student->update([
                'department_id' => $validated['department_id'],
                'student_id_number' => $validated['student_id_number'],
                'program' => $validated['program'],
                'year_of_study' => $validated['year_of_study'],
                'status' => $validated['status'],
            ]);
        });

        return redirect()->route('admin.students.index')->with('success', 'Student details updated successfully.');
    }

    public function destroy(Student $student): RedirectResponse
    {
        DB::transaction(function () use ($student) {
            $user = $student->user;
            $student->delete();
            if ($user) {
                $user->delete();
            }
        });

        return redirect()->route('admin.students.index')->with('success', 'Student removed successfully.');
    }
}
