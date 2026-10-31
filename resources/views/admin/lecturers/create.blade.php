@extends('layouts.dashboard')

@section('title', 'Add New Lecturer')
@section('page_title', 'Appoint Lecturer')
@section('page_subtitle', 'Create faculty profile, departmental assignment, and system login')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs">
        <div class="flex items-center justify-between pb-6 mb-6 border-b border-slate-100">
            <div>
                <h2 class="text-base font-bold text-slate-900">Faculty Member Details</h2>
                <p class="text-xs text-slate-500">Provide personal and departmental credentials</p>
            </div>
            <a href="{{ route('admin.lecturers.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Back to list
            </a>
        </div>

        <form action="{{ route('admin.lecturers.store') }}" method="POST" class="space-y-5">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="title" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Academic Title <span class="text-rose-500">*</span></label>
                    <select id="title" name="title" required
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                        <option value="Dr." {{ old('title') === 'Dr.' ? 'selected' : '' }}>Dr.</option>
                        <option value="Prof." {{ old('title') === 'Prof.' ? 'selected' : '' }}>Prof.</option>
                        <option value="Assoc. Prof." {{ old('title') === 'Assoc. Prof.' ? 'selected' : '' }}>Assoc. Prof.</option>
                        <option value="Mr." {{ old('title') === 'Mr.' ? 'selected' : '' }}>Mr.</option>
                        <option value="Ms." {{ old('title') === 'Ms.' ? 'selected' : '' }}>Ms.</option>
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Full Name <span class="text-rose-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="e.g. David Mukasa"
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Official University Email <span class="text-rose-500">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="d.mukasa@university.ac.ug"
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label for="staff_id" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Staff ID Number <span class="text-rose-500">*</span></label>
                    <input type="text" id="staff_id" name="staff_id" value="{{ old('staff_id', 'LEC-'.rand(1000, 9999)) }}" required
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm font-mono focus:bg-white focus:outline-none focus:border-blue-500">
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
                    <label for="qualification" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Highest Qualification</label>
                    <input type="text" id="qualification" name="qualification" value="{{ old('qualification') }}" placeholder="e.g. PhD in Information Systems (Cambridge)"
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="office_location" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Office Location</label>
                    <input type="text" id="office_location" name="office_location" value="{{ old('office_location') }}" placeholder="e.g. Science Block, Room 204"
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                </div>
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
                <a href="{{ route('admin.lecturers.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#2563eb] text-white text-xs font-semibold hover:bg-[#1d4ed8] shadow-sm transition inline-flex items-center gap-2">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>Appoint Lecturer</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

