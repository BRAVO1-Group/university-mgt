@extends('layouts.dashboard')

@section('title', 'Lecturer Dashboard')
@section('page_title', 'Lecturer Academic Portal')
@section('page_subtitle', 'View your assigned courses, lecture timetables, and student class rosters')

@section('content')
<div class="space-y-6">
    <!-- Lecturer Profile Banner -->
    <div class="p-6 rounded-2xl bg-gradient-to-r from-emerald-800 to-teal-900 text-white shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-700/60 text-emerald-200 text-xs font-semibold mb-2">
                <i data-lucide="award" class="w-3.5 h-3.5"></i>
                Faculty Member · {{ $lecturer->department->name ?? 'Academic Faculty' }}
            </div>
            <h2 class="text-2xl font-extrabold">{{ $lecturer->title }} {{ Auth::user()->name }}</h2>
            <p class="text-xs text-emerald-200 mt-1">
                Staff ID: <span class="font-mono font-semibold">{{ $lecturer->staff_id }}</span> ·
                Office: {{ $lecturer->office_location ?? 'Faculty Complex' }} ·
                {{ $lecturer->qualification ?? 'Faculty Lecturer' }}
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('lecturer.courses') }}" class="px-4 py-2.5 rounded-xl bg-white text-emerald-900 font-bold text-xs hover:bg-emerald-50 transition inline-flex items-center gap-2 shadow-xs">
                <i data-lucide="book-open" class="w-4 h-4"></i>
                View My Courses ({{ $courses->count() }})
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="p-5 bg-white rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Assigned Courses</p>
                <p class="text-3xl font-black text-slate-900 mt-1">{{ $courses->count() }}</p>
                <span class="text-xs text-emerald-600 font-medium">Semester 1 Active</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <i data-lucide="book-marked" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="p-5 bg-white rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Enrolled Students</p>
                <p class="text-3xl font-black text-slate-900 mt-1">{{ $totalStudents }}</p>
                <span class="text-xs text-blue-600 font-medium">Across all class sections</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="p-5 bg-white rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Weekly Contact Hours</p>
                <p class="text-3xl font-black text-slate-900 mt-1">{{ $courses->sum('credits') * 2 }} hrs</p>
                <span class="text-xs text-purple-600 font-medium">Lectures &amp; Lab sessions</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                <i data-lucide="clock" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <!-- Assigned Courses Cards -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Assigned Courses &amp; Classes</h3>
                <p class="text-xs text-slate-500">Select a course to view the registered students roster</p>
            </div>
            <a href="{{ route('lecturer.courses') }}" class="text-xs font-semibold text-emerald-700 hover:underline">
                View all courses →
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($courses as $course)
                <div class="p-5 bg-white rounded-2xl border border-slate-200/90 shadow-xs hover:border-emerald-300 transition flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2 py-0.5 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 font-mono">
                                {{ $course->code }}
                            </span>
                            <span class="text-xs font-semibold text-slate-600">
                                {{ $course->credits }} Credit Units
                            </span>
                        </div>

                        <h4 class="font-bold text-slate-900 text-sm leading-snug mb-2">{{ $course->title }}</h4>
                        <p class="text-xs text-slate-500 line-clamp-2 mb-4">{{ $course->description ?? 'Undergraduate module.' }}</p>
                    </div>

                    <div class="pt-3 border-t border-slate-100 space-y-2 text-xs">
                        <div class="flex items-center justify-between text-slate-600">
                            <span class="text-slate-400">Classroom:</span>
                            <span class="font-medium text-slate-800">{{ $course->room ?? 'TBA' }}</span>
                        </div>
                        <div class="flex items-center justify-between text-slate-600">
                            <span class="text-slate-400">Schedule:</span>
                            <span class="font-medium text-slate-800">{{ $course->schedule ?? 'TBA' }}</span>
                        </div>
                        <div class="flex items-center justify-between text-slate-600">
                            <span class="text-slate-400">Enrolled:</span>
                            <span class="font-bold text-emerald-700">{{ $course->registrations_count }} / {{ $course->max_capacity }} Students</span>
                        </div>

                        <div class="pt-2">
                            <a href="{{ route('lecturer.courses.students', $course) }}" class="w-full flex items-center justify-center gap-1.5 py-2 px-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs transition shadow-xs">
                                <i data-lucide="users" class="w-3.5 h-3.5"></i>
                                <span>View Registered Students ({{ $course->registrations_count }})</span>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 bg-white p-10 rounded-2xl border border-slate-200 text-center text-slate-500">
                    <i data-lucide="book-open" class="w-8 h-8 text-slate-300 mx-auto mb-2"></i>
                    <p class="font-semibold text-sm">No courses assigned yet</p>
                    <p class="text-xs text-slate-400 mt-1">The university administrator will allocate teaching modules to you shortly.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Recent Class Registrations -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100">
            <h3 class="text-base font-bold text-slate-900">Recent Student Registrations in Your Courses</h3>
            <p class="text-xs text-slate-500">Newly enrolled students joining your class lists</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-100">
                    <tr>
                        <th class="py-3 px-4">Student</th>
                        <th class="py-3 px-4">Student ID</th>
                        <th class="py-3 px-4">Course</th>
                        <th class="py-3 px-4">Enrolled At</th>
                        <th class="py-3 px-4 text-right">Roster</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($recentRegistrations as $reg)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3 px-4 font-bold text-slate-900">
                                {{ $reg->student->user->name ?? 'Student' }}
                            </td>
                            <td class="py-3 px-4 font-mono text-blue-700">
                                {{ $reg->student->student_id_number ?? 'N/A' }}
                            </td>
                            <td class="py-3 px-4">
                                <span class="font-mono font-semibold text-slate-800">{{ $reg->course->code }}</span>
                                <span class="text-slate-500 text-[11px] block">{{ $reg->course->title }}</span>
                            </td>
                            <td class="py-3 px-4 text-slate-500">
                                {{ $reg->created_at->diffForHumans() }}
                            </td>
                            <td class="py-3 px-4 text-right">
                                <a href="{{ route('lecturer.courses.students', $reg->course) }}" class="text-xs font-semibold text-emerald-700 hover:underline">
                                    View class roster →
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-500">
                                No student enrollments yet in your assigned courses.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

