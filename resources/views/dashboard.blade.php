@extends('layouts.dashboard')

@section('title', 'Academic Dashboard')
@section('page_title', 'University Academic Dashboard')
@section('page_subtitle', 'Welcome to your university academic portal')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-xs text-center max-w-xl mx-auto">
        <div class="w-16 h-16 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-4">
            <i data-lucide="graduation-cap" class="w-8 h-8"></i>
        </div>
        <h2 class="text-xl font-bold text-slate-900 mb-2">Welcome, {{ Auth::user()->name }}!</h2>
        <p class="text-xs text-slate-500 mb-6">You are signed in with the <strong class="text-slate-800">{{ ucfirst(Auth::user()->role) }}</strong> portal role.</p>

        @if(Auth::user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 text-white font-semibold text-xs hover:bg-blue-700 shadow-xs">
                <span>Go to Admin Dashboard</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        @elseif(Auth::user()->isLecturer())
            <a href="{{ route('lecturer.dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 text-white font-semibold text-xs hover:bg-emerald-700 shadow-xs">
                <span>Go to Lecturer Dashboard</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        @else
            <a href="{{ route('student.dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 text-white font-semibold text-xs hover:bg-blue-700 shadow-xs">
                <span>Go to Student Dashboard</span>
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        @endif
    </div>
</div>
@endsection
