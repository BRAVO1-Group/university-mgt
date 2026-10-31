<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminRegistrationController extends Controller
{
    public function index(Request $request): View
    {
        $query = CourseRegistration::with(['student.user', 'student.department', 'course.department', 'course.lecturer.user']);

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('student.user', function ($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('student', function ($sq) use ($search) {
                    $sq->where('student_id_number', 'like', "%{$search}%");
                })->orWhereHas('course', function ($cq) use ($search) {
                    $cq->where('code', 'like', "%{$search}%")
                        ->orWhere('title', 'like', "%{$search}%");
                });
            });
        }

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->input('course_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $registrations = $query->latest()->paginate(12)->withQueryString();
        $courses = Course::orderBy('code')->get();
        $students = Student::with('user')->get();

        return view('admin.registrations.index', compact('registrations', 'courses', 'students'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'course_id' => ['required', 'exists:courses,id'],
            'semester' => ['required', 'string'],
            'academic_year' => ['required', 'string'],
            'status' => ['required', 'string', 'in:registered,dropped,completed'],
        ]);

        $exists = CourseRegistration::where('student_id', $validated['student_id'])
            ->where('course_id', $validated['course_id'])
            ->where('academic_year', $validated['academic_year'])
            ->where('semester', $validated['semester'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'This student is already registered for this course in the selected term.');
        }

        $course = Course::findOrFail($validated['course_id']);
        if ($course->isFull() && $validated['status'] === 'registered') {
            return back()->with('error', 'Warning: Course has reached maximum capacity.');
        }

        CourseRegistration::create($validated);

        return redirect()->route('admin.registrations.index')->with('success', 'Registration recorded successfully.');
    }

    public function update(Request $request, CourseRegistration $registration): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:registered,dropped,completed'],
            'grade' => ['nullable', 'string', 'max:5'],
        ]);

        $registration->update($validated);

        return redirect()->route('admin.registrations.index')->with('success', 'Registration status updated.');
    }

    public function destroy(CourseRegistration $registration): RedirectResponse
    {
        $registration->delete();

        return redirect()->route('admin.registrations.index')->with('success', 'Course registration removed.');
    }
}
