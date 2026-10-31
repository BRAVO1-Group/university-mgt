<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Department;
use App\Models\Lecturer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminCourseController extends Controller
{
    public function index(Request $request): View
    {
        $query = Course::with(['department', 'lecturer.user'])->withCount('registrations');

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhere('room', 'like', "%{$search}%");
            });
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->input('department_id'));
        }

        if ($request->filled('lecturer_id')) {
            $query->where('lecturer_id', $request->input('lecturer_id'));
        }

        $courses = $query->orderBy('code')->paginate(10)->withQueryString();
        $departments = Department::orderBy('name')->get();
        $lecturers = Lecturer::with('user')->get();

        return view('admin.courses.index', compact('courses', 'departments', 'lecturers'));
    }

    public function create(): View
    {
        $departments = Department::orderBy('name')->get();
        $lecturers = Lecturer::with('user')->get();

        return view('admin.courses.create', compact('departments', 'lecturers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:courses,code'],
            'title' => ['required', 'string', 'max:255'],
            'department_id' => ['required', 'exists:departments,id'],
            'lecturer_id' => ['nullable', 'exists:lecturers,id'],
            'credits' => ['required', 'integer', 'min:1', 'max:10'],
            'semester' => ['required', 'string', 'max:50'],
            'academic_year' => ['required', 'string', 'max:50'],
            'max_capacity' => ['required', 'integer', 'min:1', 'max:500'],
            'room' => ['nullable', 'string', 'max:100'],
            'schedule' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
        ]);

        Course::create($validated);

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully.');
    }

    public function edit(Course $course): View
    {
        $departments = Department::orderBy('name')->get();
        $lecturers = Lecturer::with('user')->get();

        return view('admin.courses.edit', compact('course', 'departments', 'lecturers'));
    }

    public function update(Request $request, Course $course): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:courses,code,'.$course->id],
            'title' => ['required', 'string', 'max:255'],
            'department_id' => ['required', 'exists:departments,id'],
            'lecturer_id' => ['nullable', 'exists:lecturers,id'],
            'credits' => ['required', 'integer', 'min:1', 'max:10'],
            'semester' => ['required', 'string', 'max:50'],
            'academic_year' => ['required', 'string', 'max:50'],
            'max_capacity' => ['required', 'integer', 'min:1', 'max:500'],
            'room' => ['nullable', 'string', 'max:100'],
            'schedule' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
        ]);

        $course->update($validated);

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course): RedirectResponse
    {
        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully.');
    }
}
