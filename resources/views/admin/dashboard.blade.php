@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')
@section('page_title', 'Academic Administration Dashboard')
@section('page_subtitle', 'System overview and management of students, courses, lecturers and registrations')

@section('content')
<div class="space-y-6">
    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="p-5 bg-white rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Students</p>
                <p class="text-2xl font-black text-slate-900 mt-1">{{ $stats['students_count'] ?? 0 }}</p>
                <a href="{{ route('admin.students.index') }}" class="text-xs text-[#2563eb] hover:underline font-medium mt-1 inline-block">Manage students →</a>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="p-5 bg-white rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Lecturers</p>
                <p class="text-2xl font-black text-slate-900 mt-1">{{ $stats['lecturers_count'] ?? 0 }}</p>
                <a href="{{ route('admin.lecturers.index') }}" class="text-xs text-emerald-600 hover:underline font-medium mt-1 inline-block">Manage lecturers →</a>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <i data-lucide="graduation-cap" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="p-5 bg-white rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Courses</p>
                <p class="text-2xl font-black text-slate-900 mt-1">{{ $stats['courses_count'] ?? 0 }}</p>
                <a href="{{ route('admin.courses.index') }}" class="text-xs text-purple-600 hover:underline font-medium mt-1 inline-block">Manage catalog →</a>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                <i data-lucide="book-open" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="p-5 bg-white rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Registrations</p>
                <p class="text-2xl font-black text-slate-900 mt-1">{{ $stats['registrations_count'] ?? 0 }}</p>
                <a href="{{ route('admin.registrations.index') }}" class="text-xs text-amber-600 hover:underline font-medium mt-1 inline-block">View records →</a>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <i data-lucide="clipboard-check" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="p-5 bg-white rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Departments</p>
                <p class="text-2xl font-black text-slate-900 mt-1">{{ $stats['departments_count'] ?? 0 }}</p>
                <a href="{{ route('admin.departments.index') }}" class="text-xs text-indigo-600 hover:underline font-medium mt-1 inline-block">View units →</a>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                <i data-lucide="building-2" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <!-- Quick Actions Bar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
        <h2 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Quick Academic Management Actions</h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <a href="{{ route('admin.students.create') }}" class="flex items-center gap-2.5 p-3 rounded-xl border border-slate-200 bg-slate-50 hover:bg-blue-50 hover:border-blue-200 transition text-slate-800 hover:text-blue-700 text-xs font-semibold">
                <i data-lucide="user-plus" class="w-4 h-4 text-blue-600"></i>
                <span>Register Student</span>
            </a>
            <a href="{{ route('admin.lecturers.create') }}" class="flex items-center gap-2.5 p-3 rounded-xl border border-slate-200 bg-slate-50 hover:bg-emerald-50 hover:border-emerald-200 transition text-slate-800 hover:text-emerald-700 text-xs font-semibold">
                <i data-lucide="user-check" class="w-4 h-4 text-emerald-600"></i>
                <span>Add Lecturer</span>
            </a>
            <a href="{{ route('admin.courses.create') }}" class="flex items-center gap-2.5 p-3 rounded-xl border border-slate-200 bg-slate-50 hover:bg-purple-50 hover:border-purple-200 transition text-slate-800 hover:text-purple-700 text-xs font-semibold">
                <i data-lucide="plus-circle" class="w-4 h-4 text-purple-600"></i>
                <span>Create New Course</span>
            </a>
            <a href="{{ route('admin.registrations.index') }}" class="flex items-center gap-2.5 p-3 rounded-xl border border-slate-200 bg-slate-50 hover:bg-amber-50 hover:border-amber-200 transition text-slate-800 hover:text-amber-700 text-xs font-semibold">
                <i data-lucide="clipboard-list" class="w-4 h-4 text-amber-600"></i>
                <span>Manage Enrollments</span>
            </a>
        </div>
    </div>

    <!-- Main 2-Column Grid: Recent Registrations & Department Breakdown -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Registrations Table -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Recent Course Registrations</h2>
                    <p class="text-xs text-slate-500">Live student enrollments across university courses</p>
                </div>
                <a href="{{ route('admin.registrations.index') }}" class="text-xs font-semibold text-[#2563eb] hover:underline">
                    View all ({{ $stats['registrations_count'] ?? 0 }}) →
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-100">
                        <tr>
                            <th class="py-3 px-4">Student</th>
                            <th class="py-3 px-4">Course</th>
                            <th class="py-3 px-4">Lecturer</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-right">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($recentRegistrations as $reg)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-3 px-4">
                                    <div class="font-semibold text-slate-900">{{ $reg->student->user->name ?? 'Student' }}</div>
                                    <div class="text-[11px] text-slate-500 font-mono">{{ $reg->student->student_id_number ?? 'N/A' }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="inline-block px-1.5 py-0.5 rounded bg-blue-50 text-blue-700 font-mono font-semibold text-[11px]">
                                        {{ $reg->course->code ?? 'N/A' }}
                                    </span>
                                    <div class="text-[11px] text-slate-600 truncate max-w-[180px]">{{ $reg->course->title ?? '' }}</div>
                                </td>
                                <td class="py-3 px-4 text-slate-600">
                                    {{ $reg->course->lecturer->user->name ?? 'Unassigned' }}
                                </td>
                                <td class="py-3 px-4">
                                    @if($reg->status === 'registered')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Enrolled
                                        </span>
                                    @elseif($reg->status === 'dropped')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                            Dropped
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-700">
                                            {{ ucfirst($reg->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-right text-slate-500 text-[11px]">
                                    {{ $reg->created_at->diffForHumans() }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-500">
                                    No course registrations recorded yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Department Summary & Course Utilization -->
        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base font-bold text-slate-900">Departments</h2>
                    <a href="{{ route('admin.departments.index') }}" class="text-xs font-semibold text-[#2563eb] hover:underline">Manage</a>
                </div>
                <div class="space-y-3">
                    @forelse($departments as $dept)
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/70 flex items-center justify-between">
                            <div class="min-w-0 pr-2">
                                <p class="text-xs font-bold text-slate-900 truncate">{{ $dept->name }}</p>
                                <p class="text-[11px] text-slate-500">{{ $dept->code }} · {{ $dept->building ?? 'Campus' }}</p>
                            </div>
                            <div class="text-right shrink-0">
                                <span class="text-xs font-bold text-blue-700">{{ $dept->courses_count }}</span>
                                <span class="text-[10px] text-slate-500 block">Courses</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-500">No departments found.</p>
                    @endforelse
                </div>
            </div>

            <!-- Active Course Capacity Snapshot -->
            <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base font-bold text-slate-900">Course Capacity</h2>
                    <a href="{{ route('admin.courses.index') }}" class="text-xs font-semibold text-[#2563eb] hover:underline">All courses</a>
                </div>
                <div class="space-y-3">
                    @foreach($courses as $c)
                        <div>
                            <div class="flex items-center justify-between text-xs mb-1">
                                <span class="font-bold text-slate-800">{{ $c->code }}</span>
                                <span class="text-slate-500">{{ $c->registrations_count }} / {{ $c->max_capacity }} enrolled</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                @php
                                    $pct = $c->max_capacity > 0 ? min(100, round(($c->registrations_count / $c->max_capacity) * 100)) : 0;
                                @endphp
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
