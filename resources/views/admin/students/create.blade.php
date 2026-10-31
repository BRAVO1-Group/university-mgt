@extends('layouts.dashboard')

@section('title', 'Register New Student')
@section('page_title', 'Register New Student')
@section('page_subtitle', 'Create a new student academic profile and login credentials')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs">
        <div class="flex items-center justify-between pb-6 mb-6 border-b border-slate-100">
            <div>
                <h2 class="text-base font-bold text-slate-900">Student Enrollment Details</h2>
                <p class="text-xs text-slate-500">All required fields are marked with an asterisk (*)</p>
            </div>
            <a href="{{ route('admin.students.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Back to list
            </a>
        </div>

        <form action="{{ route('admin.students.store') }}" method="POST" class="space-y-5">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Full Name <span class="text-rose-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="e.g. Juliet Nabwire"
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Email Address <span class="text-rose-500">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="j.nabwire@student.ac.ug"
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="student_id_number" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Student ID Number <span class="text-rose-500">*</span></label>
                    <input type="text" id="student_id_number" name="student_id_number" value="{{ old('student_id_number', 'STU-'.date('Y').'-'.rand(100, 999)) }}" required
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm font-mono focus:bg-white focus:outline-none focus:border-blue-500">
                </div>
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
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="program" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Degree Program <span class="text-rose-500">*</span></label>
                    <input type="text" id="program" name="program" value="{{ old('program', 'BSc Computer Science') }}" required
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label for="year_of_study" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Year of Study <span class="text-rose-500">*</span></label>
                    <select id="year_of_study" name="year_of_study" required
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                        <option value="1" {{ old('year_of_study') == 1 ? 'selected' : '' }}>Year 1 (Freshman)</option>
                        <option value="2" {{ old('year_of_study') == 2 ? 'selected' : '' }}>Year 2 (Sophomore)</option>
                        <option value="3" {{ old('year_of_study') == 3 ? 'selected' : '' }}>Year 3 (Junior)</option>
                        <option value="4" {{ old('year_of_study') == 4 ? 'selected' : '' }}>Year 4 (Senior)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="phone" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Phone Number</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+256 700 000 000"
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Initial Password <span class="text-rose-500">*</span></label>
                    <input type="password" id="password" name="password" value="password" required minlength="6"
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('admin.students.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#2563eb] text-white text-xs font-semibold hover:bg-[#1d4ed8] shadow-sm transition inline-flex items-center gap-2">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>Register Student</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

