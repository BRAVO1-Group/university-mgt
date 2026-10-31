@extends('layouts.dashboard')

@section('title', 'Edit Student: ' . ($student->user->name ?? 'Student'))
@section('page_title', 'Edit Student Record')
@section('page_subtitle', 'Update student demographic, program enrollment, or status')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs">
        <div class="flex items-center justify-between pb-6 mb-6 border-b border-slate-100">
            <div>
                <h2 class="text-base font-bold text-slate-900">Editing: {{ $student->user->name ?? 'Student' }}</h2>
                <p class="text-xs text-slate-500 font-mono">{{ $student->student_id_number }}</p>
            </div>
            <a href="{{ route('admin.students.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Back to list
            </a>
        </div>

        <form action="{{ route('admin.students.update', $student) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Full Name <span class="text-rose-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $student->user->name ?? '') }}" required
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Email Address <span class="text-rose-500">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email', $student->user->email ?? '') }}" required
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="student_id_number" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Student ID Number <span class="text-rose-500">*</span></label>
                    <input type="text" id="student_id_number" name="student_id_number" value="{{ old('student_id_number', $student->student_id_number) }}" required
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm font-mono focus:bg-white focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label for="department_id" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Department <span class="text-rose-500">*</span></label>
                    <select id="department_id" name="department_id" required
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('department_id', $student->department_id) == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="program" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Program <span class="text-rose-500">*</span></label>
                    <input type="text" id="program" name="program" value="{{ old('program', $student->program) }}" required
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label for="year_of_study" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Year <span class="text-rose-500">*</span></label>
                    <select id="year_of_study" name="year_of_study" required
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                        <option value="1" {{ old('year_of_study', $student->year_of_study) == 1 ? 'selected' : '' }}>Year 1</option>
                        <option value="2" {{ old('year_of_study', $student->year_of_study) == 2 ? 'selected' : '' }}>Year 2</option>
                        <option value="3" {{ old('year_of_study', $student->year_of_study) == 3 ? 'selected' : '' }}>Year 3</option>
                        <option value="4" {{ old('year_of_study', $student->year_of_study) == 4 ? 'selected' : '' }}>Year 4</option>
                    </select>
                </div>
                <div>
                    <label for="status" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Status <span class="text-rose-500">*</span></label>
                    <select id="status" name="status" required
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                        <option value="active" {{ old('status', $student->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="graduated" {{ old('status', $student->status) === 'graduated' ? 'selected' : '' }}>Graduated</option>
                        <option value="suspended" {{ old('status', $student->status) === 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="phone" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Phone Number</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $student->user->phone ?? '') }}"
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Reset Password (leave empty to keep current)</label>
                    <input type="password" id="password" name="password" placeholder="Leave blank to preserve password"
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('admin.students.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#2563eb] text-white text-xs font-semibold hover:bg-[#1d4ed8] shadow-sm transition inline-flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    <span>Save Changes</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

