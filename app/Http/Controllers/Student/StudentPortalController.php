<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\Department;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class StudentPortalController extends Controller
{
    private function getStudent(): ?Student
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->student) {
            return $user->student;
        }

        // Fallback for demo/admin testing
        return Student::first();
    }

    public function dashboard(): View
    {
        $student = $this->getStudent();

        $registrations = CourseRegistration::where('student_id', $student?->id)
            ->with(['course.department', 'course.lecturer.user'])
            ->latest()
            ->get();

        $registeredCourseIds = $registrations->where('status', 'registered')->pluck('course_id');
        $totalCredits = Course::whereIn('id', $registeredCourseIds)->sum('credits');

        $availableCourses = Course::whereNotIn('id', $registeredCourseIds)
            ->with(['department', 'lecturer.user'])
            ->take(4)
            ->get();

        return view('student.dashboard', compact('student', 'registrations', 'totalCredits', 'availableCourses'));
    }

    public function availableCourses(Request $request): View
    {
        $student = $this->getStudent();

        $query = Course::with(['department', 'lecturer.user'])->withCount('registrations');

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%");
            });
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->input('department_id'));
        }

        $courses = $query->orderBy('code')->paginate(9)->withQueryString();
        $departments = Department::orderBy('name')->get();

        $registeredCourseIds = CourseRegistration::where('student_id', $student?->id)
            ->where('status', 'registered')
            ->pluck('course_id')
            ->toArray();

        return view('student.courses.index', compact('student', 'courses', 'departments', 'registeredCourseIds'));
    }

    public function registerCourse(Request $request): RedirectResponse
    {
        $student = $this->getStudent();

        if (! $student) {
            return back()->with('error', 'Student record not found.');
        }

        $validated = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
        ]);

        $course = Course::findOrFail($validated['course_id']);

        // Check if already registered
        $existing = CourseRegistration::where('student_id', $student->id)
            ->where('course_id', $course->id)
            ->where('semester', $course->semester)
            ->where('academic_year', $course->academic_year)
            ->first();

        if ($existing) {
            if ($existing->status === 'registered') {
                return back()->with('error', "You are already enrolled in {$course->code} - {$course->title}.");
            }

            // Re-activate if was dropped
            $existing->update(['status' => 'registered']);

            return back()->with('success', "Re-enrolled in {$course->code} - {$course->title} successfully!");
        }

        // Capacity check
        if ($course->isFull()) {
            return back()->with('error', "Cannot register: {$course->code} is currently full ({$course->max_capacity}/{$course->max_capacity} enrolled).");
        }

        CourseRegistration::create([
            'student_id' => $student->id,
            'course_id' => $course->id,
            'semester' => $course->semester,
            'academic_year' => $course->academic_year,
            'status' => 'registered',
        ]);

        return back()->with('success', "Enrolled in {$course->code} - {$course->title} successfully!");
    }

    public function myRegistrations(): View
    {
        $student = $this->getStudent();

        $registrations = CourseRegistration::where('student_id', $student?->id)
            ->with(['course.department', 'course.lecturer.user'])
            ->latest()
            ->paginate(10);

        $registeredCourses = $registrations->where('status', 'registered')->pluck('course');
        $totalCredits = $registeredCourses->sum('credits');

        return view('student.registrations.index', compact('student', 'registrations', 'totalCredits'));
    }

    public function dropCourse(CourseRegistration $registration): RedirectResponse
    {
        $student = $this->getStudent();

        if ($registration->student_id !== $student?->id && ! Auth::user()?->isAdmin()) {
            return back()->with('error', 'Unauthorized.');
        }

        $courseCode = $registration->course->code;
        $registration->update(['status' => 'dropped']);

        return back()->with('success', "Course {$courseCode} was dropped.");
    }
}
