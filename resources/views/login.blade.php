@extends('layouts.main')

@section('title', 'Sign In — University Management System')

@section('content')
    <div class="flex-1 flex items-center justify-center p-4 py-28 bg-slate-50">
        <div class="w-full max-w-md">
            <!-- Brand -->
            <div class="flex justify-center mb-6">
                <a href="{{ route('home') }}" class="inline-flex flex-col items-center gap-2">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="University Logo" class="h-14 w-14 object-contain">
                    <span class="text-base font-bold text-slate-900">University Portal</span>
                    <span class="text-xs text-slate-500">Sign in to manage courses and registrations</span>
                </a>
            </div>

            <!-- Sign in Card -->
            <div class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 shadow-sm">
                <div class="mb-6">
                    <h1 class="text-xl font-bold text-slate-900">Sign In</h1>
                    <p class="mt-1 text-sm text-slate-500">Enter your university credentials to access your account.</p>
                </div>

                @if ($errors->any())
                    <div class="mb-5 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-700">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">University Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i data-lucide="mail" class="h-4 w-4"></i>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="you@university.ac.ug"
                                class="block w-full pl-10 pr-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm placeholder-slate-400 focus:bg-white focus:outline-none focus:border-[#2563eb] focus:ring-1 focus:ring-[#2563eb]">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <i data-lucide="lock" class="h-4 w-4"></i>
                            </div>
                            <input type="password" id="password" name="password" required placeholder="••••••••"
                                class="block w-full pl-10 pr-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm placeholder-slate-400 focus:bg-white focus:outline-none focus:border-[#2563eb] focus:ring-1 focus:ring-[#2563eb]">
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs pt-1">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-[#2563eb] focus:ring-[#2563eb]">
                            <span class="text-slate-600">Keep me signed in</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-[#2563eb] text-white font-semibold text-sm hover:bg-[#1d4ed8] shadow-sm transition">
                        <span>Sign In</span>
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </button>
                </form>

                <div class="mt-6 pt-5 border-t border-slate-100 text-center text-xs text-slate-500">
                    Need a new student account?
                    <a href="{{ route('register') }}" class="font-semibold text-[#2563eb] hover:underline">Enroll now</a>
                </div>
            </div>
        </div>
    </div>
@endsection
