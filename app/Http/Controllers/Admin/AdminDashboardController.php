<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\Department;
use App\Models\Lecturer;
use App\Models\Student;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'students_count' => Student::count(),
            'lecturers_count' => Lecturer::count(),
            'courses_count' => Course::count(),
            'registrations_count' => CourseRegistration::where('status', 'registered')->count(),
            'departments_count' => Department::count(),
        ];

        $recentRegistrations = CourseRegistration::with(['student.user', 'course.department', 'course.lecturer.user'])
            ->latest()
            ->take(8)
            ->get();

        $departments = Department::withCount(['students', 'courses', 'lecturers'])->get();
        $courses = Course::with(['department', 'lecturer.user'])->withCount('registrations')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentRegistrations', 'departments', 'courses'));
    }
}
