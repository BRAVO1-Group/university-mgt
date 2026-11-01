<?php

use App\Http\Controllers\Admin\AdminCourseController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminDepartmentController;
use App\Http\Controllers\Admin\AdminLecturerController;
use App\Http\Controllers\Admin\AdminRegistrationController;
use App\Http\Controllers\Admin\AdminStudentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Lecturer\LecturerPortalController;
use App\Http\Controllers\Student\StudentPortalController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/contact', [ContactController::class, 'contact'])->name('contact');
Route::get('/contact-list', [ContactController::class, 'ContactList'])->name('contact-list');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Unified dashboard redirector
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

// Authentication routes
Route::get('/auth/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/auth/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/auth/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/auth/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Portal Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Students CRUD
    Route::resource('students', AdminStudentController::class)->except(['show']);

    // Lecturers CRUD
    Route::resource('lecturers', AdminLecturerController::class)->except(['show']);

    // Courses CRUD
    Route::resource('courses', AdminCourseController::class)->except(['show']);

    // Course Registrations
    Route::get('/registrations', [AdminRegistrationController::class, 'index'])->name('registrations.index');
    Route::post('/registrations', [AdminRegistrationController::class, 'store'])->name('registrations.store');
    Route::put('/registrations/{registration}', [AdminRegistrationController::class, 'update'])->name('registrations.update');
    Route::delete('/registrations/{registration}', [AdminRegistrationController::class, 'destroy'])->name('registrations.destroy');

    // Departments
    Route::get('/departments', [AdminDepartmentController::class, 'index'])->name('departments.index');
    Route::post('/departments', [AdminDepartmentController::class, 'store'])->name('departments.store');
    Route::put('/departments/{department}', [AdminDepartmentController::class, 'update'])->name('departments.update');
    Route::delete('/departments/{department}', [AdminDepartmentController::class, 'destroy'])->name('departments.destroy');
});

// Lecturer Portal Routes
Route::prefix('lecturer')->name('lecturer.')->middleware(['auth', 'role:lecturer,admin'])->group(function () {
    Route::get('/dashboard', [LecturerPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/courses', [LecturerPortalController::class, 'courses'])->name('courses');
    Route::get('/courses/{course}/students', [LecturerPortalController::class, 'courseStudents'])->name('courses.students');
    Route::put('/courses/{course}/students/{registration}', [LecturerPortalController::class, 'updateGrade'])->name('courses.students.grade');
});

// Student Portal Routes
Route::prefix('student')->name('student.')->middleware(['auth', 'role:student,admin'])->group(function () {
    Route::get('/dashboard', [StudentPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/courses', [StudentPortalController::class, 'availableCourses'])->name('courses');
    Route::post('/courses/register', [StudentPortalController::class, 'registerCourse'])->name('courses.register');
    Route::get('/registrations', [StudentPortalController::class, 'myRegistrations'])->name('registrations');
    Route::delete('/registrations/{registration}', [StudentPortalController::class, 'dropCourse'])->name('registrations.drop');
});
