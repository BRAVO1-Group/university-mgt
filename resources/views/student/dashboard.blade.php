@extends('layouts.dashboard')

@section('title', 'Student Dashboard')
@section('page_title', 'Student Academic Portal')
@section('page_subtitle', 'View your course registrations, accumulated credit units, and available catalog courses')

@section('content')
<div class="space-y-6">
    <!-- Student Profile Banner -->
    <div class="p-6 rounded-2xl bg-gradient-to-r from-blue-700 to-indigo-800 text-white shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-blue-600/60 text-blue-100 text-xs font-semibold mb-2">
                <i data-lucide="award" class="w-3.5 h-3.5"></i>
                Enrolled Student · {{ $student->department->name ?? 'Undergraduate Faculty' }}
            </div>
            <h2 class="text-2xl font-extrabold">{{ Auth::user()->name }}</h2>
            <p class="text-xs text-blue-200 mt-1">
                Student ID: <span class="font-mono font-bold">{{ $student->student_id_number }}</span> ·
                Program: {{ $student->program }} ·
                Year: {{ $student->year_of_study }} (Semester 1)
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('student.courses') }}" class="px-4 py-2.5 rounded-xl bg-white text-blue-900 font-bold text-xs hover:bg-blue-50 transition inline-flex items-center gap-2 shadow-xs">
                <i data-lucide="plus-circle" class="w-4 h-4 text-blue-600"></i>
                Browse &amp; Register Courses
            </a>
        </div>
    </div>

    <!-- Quick Stats Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="p-5 bg-white rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Enrolled Courses</p>
                <p class="text-3xl font-black text-slate-900 mt-1">{{ $registrations->where('status', 'registered')->count() }}</p>
                <a href="{{ route('student.registrations') }}" class="text-xs text-[#2563eb] font-semibold hover:underline mt-1 inline-block">
                    View registrations →
                </a>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <i data-lucide="book-open" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="p-5 bg-white rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Registered Credit Units</p>
                <p class="text-3xl font-black text-slate-900 mt-1">{{ $totalCredits }} <span class="text-sm font-normal text-slate-500">/ 24 max</span></p>
                <span class="text-xs text-emerald-600 font-medium">Within academic limit</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <i data-lucide="check-circle" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="p-5 bg-white rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Academic Term</p>
                <p class="text-xl font-bold text-slate-900 mt-1">Semester 1</p>
                <span class="text-xs text-slate-400">Academic Year 2025/2026</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                <i data-lucide="calendar" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <!-- Active Registered Courses Section -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="text-base font-bold text-slate-900">My Registered Courses</h3>
                <p class="text-xs text-slate-500">Your confirmed classes for this semester</p>
            </div>
            <a href="{{ route('student.registrations') }}" class="text-xs font-semibold text-[#2563eb] hover:underline">
                Manage registrations →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-100">
                    <tr>
                        <th class="py-3 px-4">Code</th>
                        <th class="py-3 px-4">Course Title</th>
                        <th class="py-3 px-4">Lecturer</th>
                        <th class="py-3 px-4">Credits</th>
                        <th class="py-3 px-4">Room &amp; Schedule</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($registrations->where('status', 'registered') as $reg)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3 px-4 font-mono font-bold text-blue-700">
                                {{ $reg->course->code }}
                            </td>
                            <td class="py-3 px-4">
                                <div class="font-bold text-slate-900 text-sm">{{ $reg->course->title }}</div>
                                <div class="text-slate-500 text-[11px]">{{ $reg->course->department->name ?? 'General' }}</div>
                            </td>
                            <td class="py-3 px-4 text-slate-600">
                                {{ $reg->course->lecturer->user->name ?? 'To Be Assigned' }}
                            </td>
                            <td class="py-3 px-4 font-semibold text-slate-800">
                                {{ $reg->course->credits }} CUs
                            </td>
                            <td class="py-3 px-4 text-slate-600">
                                <div>{{ $reg->course->room ?? 'TBA' }}</div>
                                <div class="text-slate-400 text-[10px]">{{ $reg->course->schedule ?? 'TBA' }}</div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Enrolled
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <form method="POST" action="{{ route('student.registrations.drop', $reg) }}" onsubmit="return confirm('Are you sure you want to drop {{ $reg->course->code }}?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1 rounded text-xs font-semibold text-rose-600 hover:text-rose-800 hover:bg-rose-50 transition">
                                        Drop Course
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-10 text-center text-slate-500">
                                <i data-lucide="book-open" class="w-8 h-8 text-slate-300 mx-auto mb-2"></i>
                                <p class="font-semibold text-sm">No courses registered yet</p>
                                <p class="text-xs text-slate-400 mt-1 mb-3">Browse available course offerings and enroll today.</p>
                                <a href="{{ route('student.courses') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#2563eb] text-white font-semibold text-xs hover:bg-[#1d4ed8]">
                                    Browse Course Catalog
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Suggested / Available Courses to Add -->
    @if($availableCourses->isNotEmpty())
        <div>
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Available Courses You Can Register</h3>
                    <p class="text-xs text-slate-500">Pick courses to complete your academic credit requirement</p>
                </div>
                <a href="{{ route('student.courses') }}" class="text-xs font-semibold text-[#2563eb] hover:underline">
                    View entire catalog →
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($availableCourses as $course)
                    <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between gap-4">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="px-2 py-0.5 rounded font-mono font-bold text-xs bg-blue-50 text-blue-700">
                                    {{ $course->code }}
                                </span>
                                <span class="text-xs text-slate-500">{{ $course->credits }} CUs</span>
                            </div>
                            <h4 class="font-bold text-slate-900 text-sm truncate">{{ $course->title }}</h4>
                            <p class="text-[11px] text-slate-500 mt-0.5">
                                {{ $course->lecturer->user->name ?? 'Lecturer TBA' }} · {{ $course->schedule ?? 'Schedule TBA' }}
                            </p>
                        </div>

                        <form method="POST" action="{{ route('student.courses.register') }}" class="shrink-0">
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs shadow-xs transition">
                                <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                                <span>Register</span>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection

