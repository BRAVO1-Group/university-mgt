<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminLecturerController extends Controller
{
    public function index(Request $request): View
    {
        $query = Lecturer::with(['user', 'department', 'courses']);

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('staff_id', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->input('department_id'));
        }

        $lecturers = $query->latest()->paginate(10)->withQueryString();
        $departments = Department::orderBy('name')->get();

        return view('admin.lecturers.index', compact('lecturers', 'departments'));
    }

    public function create(): View
    {
        $departments = Department::orderBy('name')->get();

        return view('admin.lecturers.create', compact('departments'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'staff_id' => ['required', 'string', 'max:50', 'unique:lecturers,staff_id'],
            'department_id' => ['required', 'exists:departments,id'],
            'title' => ['required', 'string', 'max:50'],
            'qualification' => ['nullable', 'string', 'max:255'],
            'office_location' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'lecturer',
                'phone' => $validated['phone'] ?? null,
            ]);

            Lecturer::create([
                'user_id' => $user->id,
                'department_id' => $validated['department_id'],
                'staff_id' => $validated['staff_id'],
                'title' => $validated['title'],
                'qualification' => $validated['qualification'] ?? null,
                'office_location' => $validated['office_location'] ?? null,
            ]);
        });

        return redirect()->route('admin.lecturers.index')->with('success', 'Lecturer added successfully.');
    }

    public function edit(Lecturer $lecturer): View
    {
        $lecturer->load(['user', 'department']);
        $departments = Department::orderBy('name')->get();

        return view('admin.lecturers.edit', compact('lecturer', 'departments'));
    }

    public function update(Request $request, Lecturer $lecturer): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$lecturer->user_id],
            'staff_id' => ['required', 'string', 'max:50', 'unique:lecturers,staff_id,'.$lecturer->id],
            'department_id' => ['required', 'exists:departments,id'],
            'title' => ['required', 'string', 'max:50'],
            'qualification' => ['nullable', 'string', 'max:255'],
            'office_location' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        DB::transaction(function () use ($validated, $lecturer) {
            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
            ];

            if (! empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $lecturer->user->update($userData);

            $lecturer->update([
                'department_id' => $validated['department_id'],
                'staff_id' => $validated['staff_id'],
                'title' => $validated['title'],
                'qualification' => $validated['qualification'] ?? null,
                'office_location' => $validated['office_location'] ?? null,
            ]);
        });

        return redirect()->route('admin.lecturers.index')->with('success', 'Lecturer details updated successfully.');
    }

    public function destroy(Lecturer $lecturer): RedirectResponse
    {
        DB::transaction(function () use ($lecturer) {
            $user = $lecturer->user;
            $lecturer->delete();
            if ($user) {
                $user->delete();
            }
        });

        return redirect()->route('admin.lecturers.index')->with('success', 'Lecturer removed successfully.');
    }
}
