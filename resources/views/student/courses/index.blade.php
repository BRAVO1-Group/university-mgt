@extends('layouts.dashboard')

@section('title', 'Available Courses')
@section('page_title', 'Course Registration Catalog')
@section('page_subtitle', 'Browse and register for available university courses in Semester 1')

@section('content')
<div class="space-y-6">
    <!-- Filter and Search Bar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
        <form method="GET" action="{{ route('student.courses') }}" class="flex-1 flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[220px]">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search courses by code or title..."
                    class="w-full pl-9 pr-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-300 text-slate-800 focus:bg-white focus:outline-none focus:border-blue-500">
            </div>

            <select name="department_id" class="text-xs py-2 px-3 rounded-xl bg-slate-50 border border-slate-300 text-slate-700 focus:bg-white focus:outline-none">
                <option value="">All Departments</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                @endforeach
            </select>

            <button type="submit" class="px-4 py-2 rounded-xl bg-slate-800 text-white text-xs font-semibold hover:bg-slate-900 transition">
                Filter Catalog
            </button>
            @if(request()->hasAny(['search', 'department_id']))
                <a href="{{ route('student.courses') }}" class="px-3 py-2 rounded-xl border border-slate-300 text-slate-600 text-xs hover:bg-slate-50">
                    Reset
                </a>
            @endif
        </form>

        <a href="{{ route('student.registrations') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl border border-blue-200 bg-blue-50 text-blue-700 hover:bg-blue-100 text-xs font-semibold shadow-xs transition">
            <i data-lucide="check-square" class="w-4 h-4"></i>
            <span>View My Registrations</span>
        </a>
    </div>

    <!-- Courses Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($courses as $course)
            @php
                $isRegistered = in_array($course->id, $registeredCourseIds, true);
                $isFull = $course->isFull();
            @endphp
            <div class="bg-white rounded-2xl border {{ $isRegistered ? 'border-emerald-300 ring-2 ring-emerald-50' : 'border-slate-200' }} p-6 shadow-xs flex flex-col justify-between hover:shadow-md transition">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-blue-50 text-blue-700 border border-blue-100">
                            {{ $course->code }}
                        </span>
                        <span class="text-xs font-semibold text-slate-700">
                            {{ $course->credits }} Credit Units
                        </span>
                    </div>

                    <h3 class="font-bold text-slate-900 text-base leading-snug mb-2">{{ $course->title }}</h3>
                    <p class="text-xs text-slate-500 line-clamp-2 mb-4">{{ $course->description ?? 'University academic module.' }}</p>
                </div>

                <div class="pt-4 border-t border-slate-100 space-y-2.5 text-xs">
                    <div class="flex items-center justify-between text-slate-600">
                        <span class="text-slate-400">Department:</span>
                        <span class="font-medium text-slate-800 truncate max-w-[170px]">{{ $course->department->name ?? 'General' }}</span>
                    </div>
                    <div class="flex items-center justify-between text-slate-600">
                        <span class="text-slate-400">Lecturer:</span>
                        <span class="font-medium text-slate-800">{{ $course->lecturer->user->name ?? 'TBA' }}</span>
                    </div>
                    <div class="flex items-center justify-between text-slate-600">
                        <span class="text-slate-400">Schedule:</span>
                        <span class="font-medium text-slate-800">{{ $course->schedule ?? 'TBA' }}</span>
                    </div>
                    <div class="flex items-center justify-between text-slate-600">
                        <span class="text-slate-400">Venue:</span>
                        <span class="font-medium text-slate-800">{{ $course->room ?? 'TBA' }}</span>
                    </div>

                    <!-- Capacity indicator -->
                    <div class="pt-1">
                        <div class="flex items-center justify-between text-[11px] mb-1">
                            <span class="text-slate-400">Class Enrolled:</span>
                            <span class="font-bold {{ $isFull ? 'text-rose-600' : 'text-slate-700' }}">
                                {{ $course->registrations_count }} / {{ $course->max_capacity }} seats
                            </span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                            @php
                                $pct = $course->max_capacity > 0 ? min(100, round(($course->registrations_count / $course->max_capacity) * 100)) : 0;
                            @endphp
                            <div class="{{ $isFull ? 'bg-rose-500' : 'bg-blue-600' }} h-1.5 rounded-full" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="pt-2">
                        @if($isRegistered)
                            <div class="w-full py-2.5 px-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 font-semibold text-xs text-center flex items-center justify-center gap-1.5">
                                <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600"></i>
                                <span>Already Registered</span>
                            </div>
                        @elseif($isFull)
                            <button disabled class="w-full py-2.5 px-3 rounded-xl bg-slate-100 border border-slate-200 text-slate-400 font-semibold text-xs cursor-not-allowed text-center flex items-center justify-center gap-1.5">
                                <i data-lucide="lock" class="w-4 h-4"></i>
                                <span>Course Full (Capacity Reached)</span>
                            </button>
                        @else
                            <form method="POST" action="{{ route('student.courses.register') }}">
                                @csrf
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                <button type="submit" class="w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl bg-[#2563eb] hover:bg-[#1d4ed8] text-white font-semibold text-xs shadow-sm transition">
                                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                                    <span>Register for this Course</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 py-16 text-center text-slate-500 bg-white rounded-2xl border border-slate-200">
                <i data-lucide="book-open" class="w-10 h-10 text-slate-300 mx-auto mb-2"></i>
                <p class="font-bold text-base text-slate-800">No courses match your query</p>
                <p class="text-xs text-slate-400 mt-1">Try resetting search keywords or choosing another department.</p>
            </div>
        @endforelse
    </div>

    @if($courses->hasPages())
        <div class="p-4 bg-white rounded-2xl border border-slate-200">
            {{ $courses->links() }}
        </div>
    @endif
</div>
@endsection

