@extends('layouts.dashboard')

@section('title', 'Academic Departments')
@section('page_title', 'Academic Departments & Faculties')
@section('page_subtitle', 'Manage campus departments, academic divisions, and campus buildings')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Departments Table -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Academic Units &amp; Faculties</h2>
                    <p class="text-xs text-slate-500">Departments organizing degree programs and courses</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-100">
                        <tr>
                            <th class="py-3 px-4">Code</th>
                            <th class="py-3 px-4">Department Name &amp; Location</th>
                            <th class="py-3 px-4">Courses</th>
                            <th class="py-3 px-4">Lecturers</th>
                            <th class="py-3 px-4">Students</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($departments as $dept)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-3 px-4 font-mono font-bold text-blue-700">
                                    {{ $dept->code }}
                                </td>
                                <td class="py-3 px-4">
                                    <div class="font-bold text-slate-900 text-sm">{{ $dept->name }}</div>
                                    <div class="text-slate-500 text-[11px] mt-0.5">{{ $dept->building ?? 'Campus' }}</div>
                                    @if($dept->description)
                                        <div class="text-slate-400 text-[10px] truncate max-w-xs mt-0.5">{{ $dept->description }}</div>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-semibold bg-purple-50 text-purple-700 border border-purple-100">
                                        {{ $dept->courses_count }} Courses
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                        {{ $dept->lecturers_count }} Faculty
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                        {{ $dept->students_count }} Students
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <form method="POST" action="{{ route('admin.departments.destroy', $dept) }}" onsubmit="return confirm('Delete department?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50" title="Delete Department">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-10 text-center text-slate-500">
                                    No departments configured.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create Department Form -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs h-fit">
            <h3 class="text-base font-bold text-slate-900 mb-1">Add New Department</h3>
            <p class="text-xs text-slate-500 mb-5">Create a new academic faculty or departmental unit</p>

            <form action="{{ route('admin.departments.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="code" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Code (e.g. CS, ENG, LAW) <span class="text-rose-500">*</span></label>
                    <input type="text" id="code" name="code" value="{{ old('code') }}" required maxlength="10" placeholder="e.g. MED"
                        class="block w-full px-3.5 py-2 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm font-mono uppercase focus:bg-white focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Department Name <span class="text-rose-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="e.g. Department of Medicine & Surgery"
                        class="block w-full px-3.5 py-2 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label for="building" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Campus Building / Location</label>
                    <input type="text" id="building" name="building" value="{{ old('building') }}" placeholder="e.g. Clinical Sciences Complex, Floor 2"
                        class="block w-full px-3.5 py-2 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label for="description" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Description</label>
                    <textarea id="description" name="description" rows="3" placeholder="Overview of department programs and disciplines..."
                        class="block w-full px-3.5 py-2 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">{{ old('description') }}</textarea>
                </div>

                <button type="submit" class="w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl bg-[#2563eb] text-white font-semibold text-xs hover:bg-[#1d4ed8] shadow-sm transition">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>Create Department</span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
