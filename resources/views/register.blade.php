@extends('layouts.main')

@section('title', 'Enroll & Register — University Management System')

@section('content')
    <div class="flex-1 flex items-center justify-center p-4 py-28 bg-slate-50">
        <div class="w-full max-w-lg">
            <!-- Brand -->
            <div class="flex justify-center mb-6">
                <a href="{{ route('home') }}" class="inline-flex flex-col items-center gap-2">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="University Logo" class="h-14 w-14 object-contain">
                    <span class="text-base font-bold text-slate-900">University Academic Portal</span>
                    <span class="text-xs text-slate-500">Create your student or faculty academic profile</span>
                </a>
            </div>

            <!-- Card -->
            <div class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 shadow-sm">
                <div class="mb-6">
                    <h1 class="text-xl font-bold text-slate-900">Academic Registration</h1>
                    <p class="mt-1 text-sm text-slate-500">Fill in your information to register on the academic portal.</p>
                </div>

                @if ($errors->any())
                    <div class="mb-5 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-700">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Full Name <span class="text-rose-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="e.g. Sarah Kembabazi"
                            class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-[#2563eb] focus:ring-1 focus:ring-[#2563eb]">
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">University Email <span class="text-rose-500">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="s.kembabazi@student.ac.ug"
                            class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-[#2563eb] focus:ring-1 focus:ring-[#2563eb]">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="role" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Portal Role <span class="text-rose-500">*</span></label>
                            <select id="role" name="role" required
                                class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-[#2563eb] focus:ring-1 focus:ring-[#2563eb]">
                                <option value="student" {{ old('role') === 'student' ? 'selected' : '' }}>Student</option>
                                <option value="lecturer" {{ old('role') === 'lecturer' ? 'selected' : '' }}>Lecturer</option>
                            </select>
                        </div>
                        <div>
                            <label for="department_id" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Department</label>
                            <select id="department_id" name="department_id"
                                class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-[#2563eb] focus:ring-1 focus:ring-[#2563eb]">
                                <option value="">Select Department...</option>
                                @foreach($departments ?? [] as $dept)
                                    <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="id_number" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Student / Staff ID</label>
                            <input type="text" id="id_number" name="id_number" value="{{ old('id_number') }}" placeholder="e.g. STU-2025-099"
                                class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-[#2563eb] focus:ring-1 focus:ring-[#2563eb]">
                        </div>
                        <div>
                            <label for="phone" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Phone Number</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+256 700 000 000"
                                class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-[#2563eb] focus:ring-1 focus:ring-[#2563eb]">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Password <span class="text-rose-500">*</span></label>
                            <input type="password" id="password" name="password" required minlength="8" placeholder="••••••••"
                                class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-[#2563eb] focus:ring-1 focus:ring-[#2563eb]">
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Confirm Password <span class="text-rose-500">*</span></label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required minlength="8" placeholder="••••••••"
                                class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-[#2563eb] focus:ring-1 focus:ring-[#2563eb]">
                        </div>
                    </div>

                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-[#2563eb] text-white font-semibold text-sm hover:bg-[#1d4ed8] shadow-sm transition mt-2">
                        <span>Complete Registration</span>
                        <i data-lucide="check" class="w-4 h-4"></i>
                    </button>
                </form>

                <div class="mt-6 pt-5 border-t border-slate-100 text-center text-xs text-slate-500">
                    Already registered?
                    <a href="{{ route('login') }}" class="font-semibold text-[#2563eb] hover:underline">Sign in here</a>
                </div>
            </div>
        </div>
    </div>
@endsection
