@extends('layouts.dashboard')

@section('title', 'Manage Lecturers')
@section('page_title', 'Lecturer & Faculty Management')
@section('page_subtitle', 'Oversee academic staff, departmental appointments, and assigned courses')

@section('content')
<div class="space-y-6">
    <!-- Filter and CTA Bar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.lecturers.index') }}" class="flex-1 flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[200px]">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, staff ID, email..."
                    class="w-full pl-9 pr-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-300 text-slate-800 focus:bg-white focus:outline-none focus:border-blue-500">
            </div>

            <select name="department_id" class="text-xs py-2 px-3 rounded-xl bg-slate-50 border border-slate-300 text-slate-700 focus:bg-white focus:outline-none">
                <option value="">All Departments</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                @endforeach
            </select>

            <button type="submit" class="px-4 py-2 rounded-xl bg-slate-800 text-white text-xs font-semibold hover:bg-slate-900 transition">
                Filter
            </button>
            @if(request()->hasAny(['search', 'department_id']))
                <a href="{{ route('admin.lecturers.index') }}" class="px-3 py-2 rounded-xl border border-slate-300 text-slate-600 text-xs hover:bg-slate-50">
                    Reset
                </a>
            @endif
        </form>

        <a href="{{ route('admin.lecturers.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#2563eb] text-white text-xs font-semibold hover:bg-[#1d4ed8] shadow-xs shrink-0 transition">
            <i data-lucide="user-plus" class="w-4 h-4"></i>
            <span>Add New Lecturer</span>
        </a>
    </div>

    <!-- Lecturers Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-4">Staff ID</th>
                        <th class="py-3.5 px-4">Lecturer Name &amp; Contact</th>
                        <th class="py-3.5 px-4">Department</th>
                        <th class="py-3.5 px-4">Qualification</th>
                        <th class="py-3.5 px-4">Assigned Courses</th>
                        <th class="py-3.5 px-4">Office</th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($lecturers as $lec)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3 px-4 font-mono font-bold text-emerald-700">
                                {{ $lec->staff_id }}
                            </td>
                            <td class="py-3 px-4">
                                <div class="font-bold text-slate-900 text-sm">
                                    {{ $lec->title }} {{ $lec->user->name ?? 'Staff Member' }}
                                </div>
                                <div class="text-slate-500 text-[11px] flex items-center gap-2 mt-0.5">
                                    <span>{{ $lec->user->email ?? 'No email' }}</span>
                                    @if($lec->user->phone ?? false)
                                        <span>•</span>
                                        <span>{{ $lec->user->phone }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3 px-4 font-medium text-slate-800">
                                {{ $lec->department->name ?? 'Unassigned' }}
                            </td>
                            <td class="py-3 px-4 text-slate-600">
                                {{ $lec->qualification ?? 'N/A' }}
                            </td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                    <i data-lucide="book-open" class="w-3 h-3"></i>
                                    {{ $lec->courses->count() }} Courses
                                </span>
                            </td>
                            <td class="py-3 px-4 text-slate-600">
                                {{ $lec->office_location ?? 'TBA' }}
                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('admin.lecturers.edit', $lec) }}" class="p-1.5 rounded-lg text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 transition" title="Edit Lecturer">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.lecturers.destroy', $lec) }}" onsubmit="return confirm('Are you sure you want to remove this lecturer?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition" title="Delete Lecturer">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-500">
                                <i data-lucide="graduation-cap" class="w-8 h-8 text-slate-300 mx-auto mb-2"></i>
                                <p class="text-sm font-semibold">No lecturers found</p>
                                <p class="text-xs text-slate-400 mt-1">Add a new faculty member or adjust your filter query.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($lecturers->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $lecturers->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

