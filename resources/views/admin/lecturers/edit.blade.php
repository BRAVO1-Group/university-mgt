@extends('layouts.dashboard')

@section('title', 'Edit Lecturer: ' . ($lecturer->user->name ?? 'Lecturer'))
@section('page_title', 'Edit Faculty Record')
@section('page_subtitle', 'Update lecturer credentials, department, office location, or title')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs">
        <div class="flex items-center justify-between pb-6 mb-6 border-b border-slate-100">
            <div>
                <h2 class="text-base font-bold text-slate-900">Editing: {{ $lecturer->title }} {{ $lecturer->user->name ?? 'Lecturer' }}</h2>
                <p class="text-xs text-slate-500 font-mono">{{ $lecturer->staff_id }}</p>
            </div>
            <a href="{{ route('admin.lecturers.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Back to list
            </a>
        </div>

        <form action="{{ route('admin.lecturers.update', $lecturer) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="title" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Title <span class="text-rose-500">*</span></label>
                    <select id="title" name="title" required
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                        <option value="Dr." {{ old('title', $lecturer->title) === 'Dr.' ? 'selected' : '' }}>Dr.</option>
                        <option value="Prof." {{ old('title', $lecturer->title) === 'Prof.' ? 'selected' : '' }}>Prof.</option>
                        <option value="Assoc. Prof." {{ old('title', $lecturer->title) === 'Assoc. Prof.' ? 'selected' : '' }}>Assoc. Prof.</option>
                        <option value="Mr." {{ old('title', $lecturer->title) === 'Mr.' ? 'selected' : '' }}>Mr.</option>
                        <option value="Ms." {{ old('title', $lecturer->title) === 'Ms.' ? 'selected' : '' }}>Ms.</option>
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Full Name <span class="text-rose-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $lecturer->user->name ?? '') }}" required
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Email Address <span class="text-rose-500">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email', $lecturer->user->email ?? '') }}" required
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label for="staff_id" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Staff ID Number <span class="text-rose-500">*</span></label>
                    <input type="text" id="staff_id" name="staff_id" value="{{ old('staff_id', $lecturer->staff_id) }}" required
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm font-mono focus:bg-white focus:outline-none focus:border-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="department_id" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Department <span class="text-rose-500">*</span></label>
                    <select id="department_id" name="department_id" required
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('department_id', $lecturer->department_id) == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="qualification" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Qualification</label>
                    <input type="text" id="qualification" name="qualification" value="{{ old('qualification', $lecturer->qualification) }}"
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="office_location" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Office Location</label>
                    <input type="text" id="office_location" name="office_location" value="{{ old('office_location', $lecturer->office_location) }}"
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label for="phone" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Phone Number</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $lecturer->user->phone ?? '') }}"
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Change Password</label>
                    <input type="password" id="password" name="password" placeholder="Leave blank to keep"
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('admin.lecturers.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">
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

