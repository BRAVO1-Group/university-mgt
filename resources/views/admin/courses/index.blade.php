@extends('layouts.dashboard')

@section('title', 'Manage Courses')
@section('page_title', 'Course Curriculum & Catalog')
@section('page_subtitle', 'Create courses, assign lecturers, configure credit values and capacity quotas')

@section('content')
<div class="space-y-6">
    <!-- Filters & Action Bar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.courses.index') }}" class="flex-1 flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[200px]">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by code, title, room..."
                    class="w-full pl-9 pr-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-300 text-slate-800 focus:bg-white focus:outline-none focus:border-blue-500">
            </div>

            <select name="department_id" class="text-xs py-2 px-3 rounded-xl bg-slate-50 border border-slate-300 text-slate-700 focus:bg-white focus:outline-none">
                <option value="">All Departments</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                @endforeach
            </select>

            <select name="lecturer_id" class="text-xs py-2 px-3 rounded-xl bg-slate-50 border border-slate-300 text-slate-700 focus:bg-white focus:outline-none">
                <option value="">All Lecturers</option>
                @foreach($lecturers as $lec)
                    <option value="{{ $lec->id }}" {{ request('lecturer_id') == $lec->id ? 'selected' : '' }}>{{ $lec->title }} {{ $lec->user->name ?? 'Staff' }}</option>
                @endforeach
            </select>

            <button type="submit" class="px-4 py-2 rounded-xl bg-slate-800 text-white text-xs font-semibold hover:bg-slate-900 transition">
                Filter
            </button>
            @if(request()->hasAny(['search', 'department_id', 'lecturer_id']))
                <a href="{{ route('admin.courses.index') }}" class="px-3 py-2 rounded-xl border border-slate-300 text-slate-600 text-xs hover:bg-slate-50">
                    Reset
                </a>
            @endif
        </form>

        <a href="{{ route('admin.courses.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#2563eb] text-white text-xs font-semibold hover:bg-[#1d4ed8] shadow-xs shrink-0 transition">
            <i data-lucide="plus-circle" class="w-4 h-4"></i>
            <span>Create New Course</span>
        </a>
    </div>

    <!-- Courses Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-4">Course Code</th>
                        <th class="py-3.5 px-4">Title &amp; Department</th>
                        <th class="py-3.5 px-4">Assigned Lecturer</th>
                        <th class="py-3.5 px-4">Credits</th>
                        <th class="py-3.5 px-4">Term</th>
                        <th class="py-3.5 px-4">Capacity / Enrolled</th>
                        <th class="py-3.5 px-4">Room &amp; Schedule</th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($courses as $course)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3 px-4 font-mono font-bold text-blue-700">
                                {{ $course->code }}
                            </td>
                            <td class="py-3 px-4">
                                <div class="font-bold text-slate-900 text-sm">{{ $course->title }}</div>
                                <div class="text-slate-500 text-[11px] mt-0.5">{{ $course->department->name ?? 'General' }}</div>
                            </td>
                            <td class="py-3 px-4">
                                @if($course->lecturer)
                                    <div class="font-medium text-slate-900">
                                        {{ $course->lecturer->title }} {{ $course->lecturer->user->name ?? 'Staff' }}
                                    </div>
                                    <div class="text-slate-500 text-[10px]">{{ $course->lecturer->staff_id }}</div>
                                @else
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                        Unassigned
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 font-semibold text-slate-800">
                                {{ $course->credits }} CUs
                            </td>
                            <td class="py-3 px-4 text-slate-600 text-[11px]">
                                {{ $course->semester }}<br>
                                <span class="text-slate-400">{{ $course->academic_year }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold {{ $course->isFull() ? 'text-rose-600' : 'text-slate-900' }}">
                                        {{ $course->registrations_count }} / {{ $course->max_capacity }}
                                    </span>
                                    @if($course->isFull())
                                        <span class="text-[10px] px-1.5 py-0.5 rounded bg-rose-50 text-rose-700 font-semibold border border-rose-200">Full</span>
                                    @endif
                                </div>
                                <div class="w-24 bg-slate-100 rounded-full h-1.5 mt-1 overflow-hidden">
                                    @php
                                        $pct = $course->max_capacity > 0 ? min(100, round(($course->registrations_count / $course->max_capacity) * 100)) : 0;
                                    @endphp
                                    <div class="{{ $course->isFull() ? 'bg-rose-500' : 'bg-blue-600' }} h-1.5 rounded-full" style="width: {{ $pct }}%"></div>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-[11px] text-slate-600">
                                <span class="font-medium text-slate-800 block">{{ $course->room ?? 'TBA' }}</span>
                                <span class="text-slate-500">{{ $course->schedule ?? 'TBA' }}</span>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('admin.courses.edit', $course) }}" class="p-1.5 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-blue-50 transition" title="Edit Course">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.courses.destroy', $course) }}" onsubmit="return confirm('Are you sure you want to delete this course? All associated registrations will be affected.');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition" title="Delete Course">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-500">
                                <i data-lucide="book-open" class="w-8 h-8 text-slate-300 mx-auto mb-2"></i>
                                <p class="text-sm font-semibold">No courses found</p>
                                <p class="text-xs text-slate-400 mt-1">Create a new course or clear filters.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($courses->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $courses->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
