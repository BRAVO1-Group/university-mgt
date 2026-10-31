@extends('layouts.dashboard')

@section('title', 'Create New Course')
@section('page_title', 'Create New Course')
@section('page_subtitle', 'Define course codes, titles, assigning lecturers, credits, and schedule')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs">
        <div class="flex items-center justify-between pb-6 mb-6 border-b border-slate-100">
            <div>
                <h2 class="text-base font-bold text-slate-900">Course Syllabus &amp; Allocation Details</h2>
                <p class="text-xs text-slate-500">Configure academic catalog parameters</p>
            </div>
            <a href="{{ route('admin.courses.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Back to catalog
            </a>
        </div>

        <form action="{{ route('admin.courses.store') }}" method="POST" class="space-y-5">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="code" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Course Code <span class="text-rose-500">*</span></label>
                    <input type="text" id="code" name="code" value="{{ old('code') }}" required placeholder="e.g. CS205"
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm font-mono focus:bg-white focus:outline-none focus:border-blue-500">
                </div>
                <div class="sm:col-span-2">
                    <label for="title" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Course Title <span class="text-rose-500">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required placeholder="e.g. Object Oriented Programming"
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="department_id" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Department <span class="text-rose-500">*</span></label>
                    <select id="department_id" name="department_id" required
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                        <option value="">Select Department...</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="lecturer_id" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Assign Lecturer</label>
                    <select id="lecturer_id" name="lecturer_id"
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                        <option value="">No Lecturer Assigned Yet</option>
                        @foreach($lecturers as $lec)
                            <option value="{{ $lec->id }}" {{ old('lecturer_id') == $lec->id ? 'selected' : '' }}>
                                {{ $lec->title }} {{ $lec->user->name ?? 'Staff' }} ({{ $lec->department->code ?? '' }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div>
                    <label for="credits" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Credit Units <span class="text-rose-500">*</span></label>
                    <input type="number" id="credits" name="credits" value="{{ old('credits', 3) }}" required min="1" max="10"
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label for="max_capacity" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Max Capacity <span class="text-rose-500">*</span></label>
                    <input type="number" id="max_capacity" name="max_capacity" value="{{ old('max_capacity', 50) }}" required min="1" max="500"
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label for="semester" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Semester <span class="text-rose-500">*</span></label>
                    <select id="semester" name="semester" required
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                        <option value="Semester 1" {{ old('semester') === 'Semester 1' ? 'selected' : '' }}>Semester 1</option>
                        <option value="Semester 2" {{ old('semester') === 'Semester 2' ? 'selected' : '' }}>Semester 2</option>
                        <option value="Recess Term" {{ old('semester') === 'Recess Term' ? 'selected' : '' }}>Recess Term</option>
                    </select>
                </div>
                <div>
                    <label for="academic_year" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Academic Year <span class="text-rose-500">*</span></label>
                    <input type="text" id="academic_year" name="academic_year" value="{{ old('academic_year', '2025/2026') }}" required
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="room" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Classroom / Laboratory</label>
                    <input type="text" id="room" name="room" value="{{ old('room') }}" placeholder="e.g. Science Lab 3, Hall B1"
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label for="schedule" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Lecture Schedule</label>
                    <input type="text" id="schedule" name="schedule" value="{{ old('schedule') }}" placeholder="e.g. Tue & Thu 09:00 - 11:00 AM"
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                </div>
            </div>

            <div>
                <label for="description" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Course Description &amp; Objectives</label>
                <textarea id="description" name="description" rows="3" placeholder="Syllabus overview, prerequisites, learning outcomes..."
                    class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">{{ old('description') }}</textarea>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('admin.courses.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#2563eb] text-white text-xs font-semibold hover:bg-[#1d4ed8] shadow-sm transition inline-flex items-center gap-2">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>Create Course</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

