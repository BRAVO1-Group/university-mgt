@extends('layouts.dashboard')

@section('title', 'Academic Departments')
@section('page_title', 'Academic Departments & Faculties')
@section('page_subtitle', 'Manage campus departments, academic divisions, and campus buildings')

@section('content')
<div class="space-y-6">
    <!-- Action Bar & Search -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.departments.index') }}" class="flex-1 flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[220px]">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by department name, code, building..."
                    class="w-full pl-9 pr-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-300 text-slate-800 focus:bg-white focus:outline-none focus:border-blue-500">
            </div>

            <button type="submit" class="px-4 py-2 rounded-xl bg-slate-800 text-white text-xs font-semibold hover:bg-slate-900 transition">
                Filter
            </button>
            @if(request()->filled('search'))
                <a href="{{ route('admin.departments.index') }}" class="px-3 py-2 rounded-xl border border-slate-300 text-slate-600 text-xs hover:bg-slate-50">
                    Reset
                </a>
            @endif
        </form>

        <!-- Add Department Button triggering modal -->
        <label for="add-dept-modal" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#2563eb] text-white text-xs font-semibold hover:bg-[#1d4ed8] shadow-xs shrink-0 cursor-pointer transition">
            <i data-lucide="plus-circle" class="w-4 h-4"></i>
            <span>Add New Department</span>
        </label>
    </div>

    <!-- Departments Full-Width Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-900">Academic Units &amp; Faculties</h2>
                <p class="text-xs text-slate-500">Master list of departments organizing academic programs, lecturers, and courses</p>
            </div>
            <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                {{ $departments->count() }} {{ \Illuminate\Support\Str::plural('Department', $departments->count()) }}
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-5 whitespace-nowrap">Code</th>
                        <th class="py-3.5 px-5">Department Name &amp; Location</th>
                        <th class="py-3.5 px-5 whitespace-nowrap">Courses</th>
                        <th class="py-3.5 px-5 whitespace-nowrap">Lecturers</th>
                        <th class="py-3.5 px-5 whitespace-nowrap">Students</th>
                        <th class="py-3.5 px-5 text-right whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($departments as $dept)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3.5 px-5 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 font-mono font-bold text-xs border border-blue-100">
                                    {{ $dept->code }}
                                </span>
                            </td>
                            <td class="py-3.5 px-5">
                                <div class="font-bold text-slate-900 text-sm">{{ $dept->name }}</div>
                                <div class="text-slate-500 text-xs mt-0.5 flex items-center gap-1.5">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400 shrink-0"></i>
                                    <span>{{ $dept->building ?? 'Main Campus' }}</span>
                                </div>
                                @if($dept->description)
                                    <p class="text-slate-400 text-[11px] mt-1 max-w-lg leading-relaxed">{{ $dept->description }}</p>
                                @endif
                            </td>
                            <td class="py-3.5 px-5 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-100">
                                    <i data-lucide="book-open" class="w-3.5 h-3.5"></i>
                                    {{ $dept->courses_count }} Courses
                                </span>
                            </td>
                            <td class="py-3.5 px-5 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                    <i data-lucide="users" class="w-3.5 h-3.5"></i>
                                    {{ $dept->lecturers_count }} Faculty
                                </span>
                            </td>
                            <td class="py-3.5 px-5 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                    <i data-lucide="graduation-cap" class="w-3.5 h-3.5"></i>
                                    {{ $dept->students_count }} Students
                                </span>
                            </td>
                            <td class="py-3.5 px-5 text-right whitespace-nowrap">
                                <div class="inline-flex items-center justify-end gap-1.5">
                                    <!-- Edit Trigger -->
                                    <label for="edit-dept-{{ $dept->id }}-modal" class="p-1.5 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 cursor-pointer transition" title="Edit Department">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </label>

                                    <!-- Delete Button -->
                                    <form method="POST" action="{{ route('admin.departments.destroy', $dept) }}" onsubmit="return confirm('Are you sure you want to delete department {{ $dept->name }}?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition" title="Delete Department">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Department Modal for this row -->
                        <input type="checkbox" id="edit-dept-{{ $dept->id }}-modal" class="peer/edit-{{ $dept->id }} hidden">
                        <div class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs hidden peer-checked/edit-{{ $dept->id }}:flex items-center justify-center p-4">
                            <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl border border-slate-200 text-left">
                                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
                                    <div>
                                        <h3 class="text-base font-bold text-slate-900">Edit Department</h3>
                                        <p class="text-xs text-slate-500">Update details for {{ $dept->name }}</p>
                                    </div>
                                    <label for="edit-dept-{{ $dept->id }}-modal" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 cursor-pointer">
                                        <i data-lucide="x" class="w-5 h-5"></i>
                                    </label>
                                </div>

                                <form action="{{ route('admin.departments.update', $dept) }}" method="POST" class="space-y-4">
                                    @csrf
                                    @method('PUT')
                                    <div>
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Department Code <span class="text-rose-500">*</span></label>
                                        <input type="text" name="code" value="{{ old('code', $dept->code) }}" required maxlength="10"
                                            class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm font-mono uppercase focus:bg-white focus:outline-none focus:border-blue-500">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Department Name <span class="text-rose-500">*</span></label>
                                        <input type="text" name="name" value="{{ old('name', $dept->name) }}" required
                                            class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Campus Building / Location</label>
                                        <input type="text" name="building" value="{{ old('building', $dept->building) }}"
                                            class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Description</label>
                                        <textarea name="description" rows="3"
                                            class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">{{ old('description', $dept->description) }}</textarea>
                                    </div>

                                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                                        <label for="edit-dept-{{ $dept->id }}-modal" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 text-xs font-semibold hover:bg-slate-50 cursor-pointer">
                                            Cancel
                                        </label>
                                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#2563eb] text-white text-xs font-semibold hover:bg-[#1d4ed8] shadow-sm transition">
                                            Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-500">
                                <i data-lucide="building-2" class="w-8 h-8 text-slate-300 mx-auto mb-2"></i>
                                <p class="text-sm font-semibold">No departments found</p>
                                <p class="text-xs text-slate-400 mt-1">Add a new department or adjust your search filter.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create Department Modal (CSS Toggle) -->
    <input type="checkbox" id="add-dept-modal" class="peer/add hidden">
    <div class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs hidden peer-checked/add:flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl border border-slate-200">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Add New Department</h3>
                    <p class="text-xs text-slate-500">Create a new academic faculty or departmental unit</p>
                </div>
                <label for="add-dept-modal" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 cursor-pointer">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </label>
            </div>

            <form action="{{ route('admin.departments.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="code" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Code (e.g. CS, ENG, LAW) <span class="text-rose-500">*</span></label>
                    <input type="text" id="code" name="code" value="{{ old('code') }}" required maxlength="10" placeholder="e.g. MED"
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm font-mono uppercase focus:bg-white focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Department Name <span class="text-rose-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="e.g. Department of Medicine & Surgery"
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label for="building" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Campus Building / Location</label>
                    <input type="text" id="building" name="building" value="{{ old('building') }}" placeholder="e.g. Clinical Sciences Complex, Floor 2"
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label for="description" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Description</label>
                    <textarea id="description" name="description" rows="3" placeholder="Overview of department programs and disciplines..."
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">{{ old('description') }}</textarea>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                    <label for="add-dept-modal" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 text-xs font-semibold hover:bg-slate-50 cursor-pointer">
                        Cancel
                    </label>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#2563eb] text-white text-xs font-semibold hover:bg-[#1d4ed8] shadow-sm transition">
                        Create Department
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
