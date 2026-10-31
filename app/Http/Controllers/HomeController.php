<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Course;
use App\Models\Department;
use App\Models\Lecturer;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $stats = [
            'students' => Student::count(),
            'lecturers' => Lecturer::count(),
            'courses' => Course::count(),
            'departments' => Department::count(),
        ];

        $featuredCourses = Course::with(['department', 'lecturer.user'])
            ->withCount('registrations')
            ->take(6)
            ->get();

        $departments = Department::withCount('courses')->take(4)->get();

        return view('index', compact('stats', 'featuredCourses', 'departments'));
    }

    public function dashboard(): RedirectResponse|View
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        /** @var User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isLecturer()) {
            return redirect()->route('lecturer.dashboard');
        }

        return redirect()->route('student.dashboard');
    }

    public function contact(): View
    {
        return view('contact');
    }

    public function contactList(): View
    {
        $contacts = Contact::latest()->paginate(10);

        return view('contact-list', compact('contacts'));
    }
}
