@extends('layouts.dashboard')

@section('title', 'Manage Students')
@section('page_title', 'Student Records Management')
@section('page_subtitle', 'Browse, filter, register, update, and manage student enrollments')

@section('content')
<div class="space-y-6">
    <!-- Action Bar & Filter Bar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
        <!-- Search and Filters -->
        <form method="GET" action="{{ route('admin.students.index') }}" class="flex-1 flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[200px]">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, student ID, email..."
                    class="w-full pl-9 pr-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-300 text-slate-800 focus:bg-white focus:outline-none focus:border-blue-500">
            </div>

            <select name="department_id" class="text-xs py-2 px-3 rounded-xl bg-slate-50 border border-slate-300 text-slate-700 focus:bg-white focus:outline-none">
                <option value="">All Departments</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                @endforeach
            </select>

            <select name="year" class="text-xs py-2 px-3 rounded-xl bg-slate-50 border border-slate-300 text-slate-700 focus:bg-white focus:outline-none">
                <option value="">All Years</option>
                <option value="1" {{ request('year') == '1' ? 'selected' : '' }}>Year 1</option>
                <option value="2" {{ request('year') == '2' ? 'selected' : '' }}>Year 2</option>
                <option value="3" {{ request('year') == '3' ? 'selected' : '' }}>Year 3</option>
                <option value="4" {{ request('year') == '4' ? 'selected' : '' }}>Year 4</option>
            </select>

            <button type="submit" class="px-4 py-2 rounded-xl bg-slate-800 text-white text-xs font-semibold hover:bg-slate-900 transition">
                Filter
            </button>
            @if(request()->hasAny(['search', 'department_id', 'year']))
                <a href="{{ route('admin.students.index') }}" class="px-3 py-2 rounded-xl border border-slate-300 text-slate-600 text-xs hover:bg-slate-50">
                    Reset
                </a>
            @endif
        </form>

        <!-- Add Student CTA -->
        <a href="{{ route('admin.students.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#2563eb] text-white text-xs font-semibold hover:bg-[#1d4ed8] shadow-xs shrink-0 transition">
            <i data-lucide="user-plus" class="w-4 h-4"></i>
            <span>Register New Student</span>
        </a>
    </div>

    <!-- Students Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-4 whitespace-nowrap">Student ID</th>
                        <th class="py-3.5 px-4 min-w-[180px]">Student Name &amp; Contact</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Department &amp; Program</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Year</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Registered Courses</th>
                        <th class="py-3.5 px-4 whitespace-nowrap">Status</th>
                        <th class="py-3.5 px-4 text-right whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($students as $student)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3 px-4 font-mono font-bold text-blue-700">
                                {{ $student->student_id_number }}
                            </td>
                            <td class="py-3 px-4">
                                <div class="font-bold text-slate-900 text-sm">{{ $student->user->name ?? 'Unknown' }}</div>
                                <div class="text-slate-500 text-[11px] flex items-center gap-2 mt-0.5">
                                    <span>{{ $student->user->email ?? 'No email' }}</span>
                                    @if($student->user->phone ?? false)
                                        <span>•</span>
                                        <span>{{ $student->user->phone }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="font-medium text-slate-900">{{ $student->department->name ?? 'Unassigned' }}</div>
                                <div class="text-slate-500 text-[11px]">{{ $student->program }}</div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 font-semibold text-[11px]">
                                    Year {{ $student->year_of_study }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                    <i data-lucide="book" class="w-3 h-3"></i>
                                    {{ $student->courseRegistrations->where('status', 'registered')->count() }} Active
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                @if($student->status === 'active')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Active
                                    </span>
                                @elseif($student->status === 'graduated')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                        Graduated
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                        Suspended
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('admin.students.edit', $student) }}" class="p-1.5 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-blue-50 transition" title="Edit Student">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.students.destroy', $student) }}" onsubmit="return confirm('Are you sure you want to remove this student record?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition" title="Delete Student">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-500">
                                <i data-lucide="users" class="w-8 h-8 text-slate-300 mx-auto mb-2"></i>
                                <p class="text-sm font-semibold">No students found</p>
                                <p class="text-xs text-slate-400 mt-1">Try adjusting your filters or register a new student.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($students->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $students->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

