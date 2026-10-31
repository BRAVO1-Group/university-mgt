<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LecturerPortalController extends Controller
{
    private function getLecturer(): ?Lecturer
    {
        /** @var User $user */
        $user = Auth::user();

        return $user->lecturer ?? Lecturer::first();
    }

    public function dashboard(): View
    {
        $lecturer = $this->getLecturer();

        $courses = Course::where('lecturer_id', $lecturer?->id)
            ->with(['department'])
            ->withCount('registrations')
            ->get();

        $courseIds = $courses->pluck('id');

        $totalStudents = CourseRegistration::whereIn('course_id', $courseIds)
            ->where('status', 'registered')
            ->distinct('student_id')
            ->count('student_id');

        $recentRegistrations = CourseRegistration::whereIn('course_id', $courseIds)
            ->with(['student.user', 'course'])
            ->latest()
            ->take(6)
            ->get();

        return view('lecturer.dashboard', compact('lecturer', 'courses', 'totalStudents', 'recentRegistrations'));
    }

    public function courses(): View
    {
        $lecturer = $this->getLecturer();

        $courses = Course::where('lecturer_id', $lecturer?->id)
            ->with(['department'])
            ->withCount('registrations')
            ->get();

        return view('lecturer.courses.index', compact('lecturer', 'courses'));
    }

    public function courseStudents(Request $request, Course $course): View|RedirectResponse
    {
        $lecturer = $this->getLecturer();

        // Verify lecturer owns this course (unless admin)
        if ($course->lecturer_id !== $lecturer?->id && ! Auth::user()?->isAdmin()) {
            return redirect()->route('lecturer.courses')->with('error', 'You are not assigned as the lecturer for this course.');
        }

        $query = CourseRegistration::where('course_id', $course->id)
            ->with(['student.user', 'student.department']);

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->whereHas('student.user', function ($uq) use ($search) {
                $uq->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })->orWhereHas('student', function ($sq) use ($search) {
                $sq->where('student_id_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $registrations = $query->paginate(15)->withQueryString();

        return view('lecturer.courses.students', compact('course', 'registrations', 'lecturer'));
    }

    public function updateGrade(Request $request, Course $course, CourseRegistration $registration): RedirectResponse
    {
        $lecturer = $this->getLecturer();

        if ($course->lecturer_id !== $lecturer?->id && ! Auth::user()?->isAdmin()) {
            return back()->with('error', 'Unauthorized.');
        }

        $validated = $request->validate([
            'grade' => ['nullable', 'string', 'max:5'],
            'status' => ['required', 'string', 'in:registered,completed,dropped'],
        ]);

        $registration->update($validated);

        return back()->with('success', 'Student grade/status updated.');
    }
}
