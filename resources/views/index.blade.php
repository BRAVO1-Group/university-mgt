@extends('layouts.main')

@section('title', 'University Management System — Campus Academic Portal')

@section('content')
    <!-- Hero Section -->
    <section class="relative pt-28 pb-16 lg:pt-32 lg:pb-24 bg-gradient-to-b from-blue-50/70 via-white to-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-7 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full border border-blue-200 bg-white shadow-xs text-xs font-semibold text-[#2563eb] mb-6">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Academic Year 2025/2026 · Semester 1 Active
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 leading-tight mb-6">
                        University Academic &amp; Course
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Management System</span>
                    </h1>

                    <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto lg:mx-0 mb-8 leading-relaxed">
                        A centralized platform for university administrators to manage records, lecturers to oversee assigned classes and enrolled rosters, and students to register for available courses.
                    </p>

                    <!-- Fast Action Buttons -->
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 mb-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-[#2563eb] text-white rounded-xl font-semibold text-sm hover:bg-[#1d4ed8] shadow-md transition">
                                <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                                Enter Your Portal ({{ ucfirst(Auth::user()->role) }})
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-[#2563eb] text-white rounded-xl font-semibold text-sm hover:bg-[#1d4ed8] shadow-md transition">
                                <i data-lucide="log-in" class="w-4 h-4"></i>
                                Sign in to Portal
                            </a>
                            <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-white border border-slate-300 text-slate-800 rounded-xl font-semibold text-sm hover:bg-slate-50 shadow-xs transition">
                                <i data-lucide="user-plus" class="w-4 h-4 text-blue-600"></i>
                                New Student Registration
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Right Side Stats / Highlights Cards -->
                <div class="lg:col-span-5">
                    <div class="relative">
                        <div class="absolute -top-6 -left-6 w-72 h-72 bg-blue-200/40 rounded-full blur-3xl pointer-events-none"></div>
                        <div class="relative bg-white rounded-2xl border border-slate-200 p-6 sm:p-7 shadow-xl space-y-6">
                            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                                <div>
                                    <h3 class="font-bold text-slate-900 text-base">Campus Academic Overview</h3>
                                    <p class="text-xs text-slate-500">Live system statistics</p>
                                </div>
                                <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-100">
                                    Live Sync
                                </span>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                                    <p class="text-2xl font-black text-slate-900">{{ $stats['students'] ?? 0 }}</p>
                                    <p class="text-xs font-medium text-slate-500 mt-1 flex items-center gap-1">
                                        <i data-lucide="users" class="w-3.5 h-3.5 text-blue-600"></i>
                                        Enrolled Students
                                    </p>
                                </div>
                                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                                    <p class="text-2xl font-black text-slate-900">{{ $stats['lecturers'] ?? 0 }}</p>
                                    <p class="text-xs font-medium text-slate-500 mt-1 flex items-center gap-1">
                                        <i data-lucide="graduation-cap" class="w-3.5 h-3.5 text-emerald-600"></i>
                                        Active Lecturers
                                    </p>
                                </div>
                                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                                    <p class="text-2xl font-black text-slate-900">{{ $stats['courses'] ?? 0 }}</p>
                                    <p class="text-xs font-medium text-slate-500 mt-1 flex items-center gap-1">
                                        <i data-lucide="book-open" class="w-3.5 h-3.5 text-purple-600"></i>
                                        Active Courses
                                    </p>
                                </div>
                                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                                    <p class="text-2xl font-black text-slate-900">{{ $stats['departments'] ?? 0 }}</p>
                                    <p class="text-xs font-medium text-slate-500 mt-1 flex items-center gap-1">
                                        <i data-lucide="building-2" class="w-3.5 h-3.5 text-amber-600"></i>
                                        Departments
                                    </p>
                                </div>
                            </div>

                            <div class="p-4 rounded-xl bg-blue-50/70 border border-blue-100 flex items-center gap-3">
                                <i data-lucide="info" class="w-5 h-5 text-blue-600 shrink-0"></i>
                                <p class="text-xs text-blue-900 leading-relaxed">
                                    Semester course add/drop registration is currently active. Students can enroll with immediate credit calculation.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Role Responsibilities Grid -->
    <section class="py-16 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="text-xs font-bold text-[#2563eb] uppercase tracking-wider">Role Capabilities</span>
                <h2 class="text-3xl font-bold text-slate-900 mt-1">Built for the Entire Academic Community</h2>
                <p class="text-sm text-slate-500 mt-2">Tailored interfaces for administrators, lecturers, and enrolled students.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Admin Card -->
                <div class="p-6 rounded-2xl border border-slate-200 bg-white shadow-xs hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center mb-5 border border-purple-100">
                        <i data-lucide="shield-check" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Administrators</h3>
                    <p class="text-sm text-slate-500 mb-4 leading-relaxed">
                        Full administrative oversight over student profiles, lecturer credentials, departments, course catalog offerings, and official enrollments.
                    </p>
                    <ul class="text-xs text-slate-600 space-y-2 mb-6">
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-purple-600"></i> Manage Student &amp; Lecturer records</li>
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-purple-600"></i> Create &amp; assign courses with capacity limits</li>
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-purple-600"></i> Oversee campus registrations and rosters</li>
                    </ul>
                    <a href="{{ route('login') }}" class="text-xs font-semibold text-purple-700 hover:text-purple-900 inline-flex items-center gap-1">
                        Open Admin Portal <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>

                <!-- Lecturer Card -->
                <div class="p-6 rounded-2xl border border-slate-200 bg-white shadow-xs hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-5 border border-emerald-100">
                        <i data-lucide="graduation-cap" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Lecturers &amp; Faculty</h3>
                    <p class="text-sm text-slate-500 mb-4 leading-relaxed">
                        View assigned teaching courses, access live registered student rosters, track class sizes, and manage academic performance.
                    </p>
                    <ul class="text-xs text-slate-600 space-y-2 mb-6">
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-emerald-600"></i> View assigned course allocations</li>
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-emerald-600"></i> Real-time registered student lists with IDs</li>
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-emerald-600"></i> Classroom venue and schedule details</li>
                    </ul>
                    <a href="{{ route('login') }}" class="text-xs font-semibold text-emerald-700 hover:text-emerald-900 inline-flex items-center gap-1">
                        Open Lecturer Portal <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>

                <!-- Student Card -->
                <div class="p-6 rounded-2xl border border-slate-200 bg-white shadow-xs hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-5 border border-blue-100">
                        <i data-lucide="book-open" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Students</h3>
                    <p class="text-sm text-slate-500 mb-4 leading-relaxed">
                        Explore available department courses, register for subjects in 1 click, track accumulated credit units, and manage enrolled modules.
                    </p>
                    <ul class="text-xs text-slate-600 space-y-2 mb-6">
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-blue-600"></i> Browse semester course catalog</li>
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-blue-600"></i> 1-click self-service course registration</li>
                        <li class="flex items-center gap-2"><i data-lucide="check" class="w-3.5 h-3.5 text-blue-600"></i> View registered timetable &amp; credit points</li>
                    </ul>
                    <a href="{{ route('login') }}" class="text-xs font-semibold text-blue-700 hover:text-blue-900 inline-flex items-center gap-1">
                        Open Student Portal <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Courses Section -->
    <section id="courses" class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
                <div>
                    <span class="text-xs font-bold text-[#2563eb] uppercase tracking-wider">Course Catalog</span>
                    <h2 class="text-3xl font-bold text-slate-900 mt-1">Featured University Courses</h2>
                    <p class="text-sm text-slate-500 mt-1">Currently open for student registration.</p>
                </div>
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#2563eb] hover:text-[#1d4ed8]">
                    Explore all available courses <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($featuredCourses as $course)
                    <div class="p-5 rounded-2xl bg-white border border-slate-200/90 shadow-xs hover:border-blue-300 transition flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-blue-50 text-[#2563eb] border border-blue-100 font-mono">
                                    {{ $course->code }}
                                </span>
                                <span class="text-xs font-medium text-slate-500">
                                    {{ $course->credits }} Credits
                                </span>
                            </div>

                            <h3 class="font-bold text-slate-900 text-base leading-snug mb-2">{{ $course->title }}</h3>
                            <p class="text-xs text-slate-500 line-clamp-2 mb-4">{{ $course->description ?? 'Comprehensive university undergraduate module.' }}</p>
                        </div>

                        <div class="pt-4 border-t border-slate-100 space-y-2 text-xs text-slate-600">
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400">Department:</span>
                                <span class="font-medium text-slate-700">{{ $course->department->name ?? 'General' }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400">Lecturer:</span>
                                <span class="font-medium text-slate-700">{{ $course->lecturer->user->name ?? 'TBA' }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400">Schedule:</span>
                                <span class="font-medium text-slate-700">{{ $course->schedule ?? 'TBA' }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12 text-slate-500">
                        No courses available at this time.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Departments Section -->
    <section id="departments" class="py-16 bg-white border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-xs font-bold text-[#2563eb] uppercase tracking-wider">Faculties</span>
                <h2 class="text-3xl font-bold text-slate-900 mt-1">Academic Departments</h2>
                <p class="text-sm text-slate-500 mt-1">Supporting academic excellence across diverse disciplines.</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($departments as $dept)
                    <div class="p-5 rounded-xl border border-slate-200 bg-slate-50/50 hover:bg-slate-50 transition">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm">
                                {{ $dept->code }}
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 text-sm">{{ $dept->name }}</h3>
                                <p class="text-[11px] text-slate-500">{{ $dept->building ?? 'Campus Academic Block' }}</p>
                            </div>
                        </div>
                        <p class="text-xs text-slate-600 line-clamp-2 mb-3">{{ $dept->description ?? 'Undergraduate and postgraduate department.' }}</p>
                        <div class="text-[11px] text-[#2563eb] font-semibold">
                            {{ $dept->courses_count }} Courses Offered
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-6 text-slate-500">
                        No departments found.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
