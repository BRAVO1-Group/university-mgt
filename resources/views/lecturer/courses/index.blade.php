@extends('layouts.dashboard')

@section('title', 'My Assigned Courses')
@section('page_title', 'My Assigned Courses')
@section('page_subtitle', 'Courses allocated to you for teaching this academic session')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-base font-bold text-slate-900">Teaching Curriculum</h2>
                <p class="text-xs text-slate-500">You are teaching {{ $courses->count() }} courses in the current semester</p>
            </div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                Semester 1 · 2025/2026
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-4">Course Code</th>
                        <th class="py-3.5 px-4">Course Title &amp; Department</th>
                        <th class="py-3.5 px-4">Credits</th>
                        <th class="py-3.5 px-4">Venue &amp; Timetable</th>
                        <th class="py-3.5 px-4">Enrolled Students</th>
                        <th class="py-3.5 px-4 text-right">Class Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($courses as $course)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3.5 px-4 font-mono font-bold text-emerald-700 text-sm">
                                {{ $course->code }}
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-900 text-sm">{{ $course->title }}</div>
                                <div class="text-slate-500 text-[11px] mt-0.5">{{ $course->department->name ?? 'General' }}</div>
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-slate-800">
                                {{ $course->credits }} CUs
                            </td>
                            <td class="py-3.5 px-4 text-slate-600">
                                <div class="font-medium text-slate-800">{{ $course->room ?? 'TBA' }}</div>
                                <div class="text-slate-500 text-[11px]">{{ $course->schedule ?? 'TBA' }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-slate-900">
                                        {{ $course->registrations_count }} / {{ $course->max_capacity }}
                                    </span>
                                    <span class="text-[10px] text-slate-400">students</span>
                                </div>
                                <div class="w-24 bg-slate-100 rounded-full h-1.5 mt-1 overflow-hidden">
                                    @php
                                        $pct = $course->max_capacity > 0 ? min(100, round(($course->registrations_count / $course->max_capacity) * 100)) : 0;
                                    @endphp
                                    <div class="bg-emerald-600 h-1.5 rounded-full" style="width: {{ $pct }}%"></div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <a href="{{ route('lecturer.courses.students', $course) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs shadow-xs transition">
                                    <i data-lucide="users" class="w-3.5 h-3.5"></i>
                                    <span>View Registered Students</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-500">
                                <i data-lucide="book-open" class="w-8 h-8 text-slate-300 mx-auto mb-2"></i>
                                <p class="text-sm font-semibold">No assigned courses</p>
                                <p class="text-xs text-slate-400 mt-1">Contact the Academic Registrar if your course allocations have not been uploaded.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

