@extends('layouts.dashboard')

@section('title', 'My Course Registrations')
@section('page_title', 'My Course Registrations')
@section('page_subtitle', 'View your enrolled modules, accumulated credit units, and academic timetable')

@section('content')
<div class="space-y-6">
    <!-- Credit Summary Banner -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-base font-bold text-slate-900">Current Semester Credit Load</h2>
            <p class="text-xs text-slate-500 mt-0.5">Semester 1 · Academic Year 2025/2026</p>
            <div class="flex items-center gap-3 mt-3 text-xs">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 font-semibold border border-emerald-200">
                    <i data-lucide="check-circle-2" class="w-3.5 h-3.5"></i>
                    {{ $registrations->where('status', 'registered')->count() }} Active Courses
                </span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 text-blue-700 font-semibold border border-blue-200">
                    <i data-lucide="layers" class="w-3.5 h-3.5"></i>
                    {{ $totalCredits }} Registered Credits
                </span>
            </div>
        </div>

        <a href="{{ route('student.courses') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#2563eb] text-white text-xs font-semibold hover:bg-[#1d4ed8] shadow-xs transition">
            <i data-lucide="plus-circle" class="w-4 h-4"></i>
            <span>Register More Courses</span>
        </a>
    </div>

    <!-- Registrations Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-base font-bold text-slate-900">Official Course Registration Record</h3>
            <button onclick="window.print()" class="inline-flex items-center gap-1.5 text-xs text-slate-600 hover:text-slate-900 border border-slate-200 rounded-lg px-2.5 py-1 hover:bg-slate-50">
                <i data-lucide="printer" class="w-3.5 h-3.5"></i>
                <span>Print Registration Slip</span>
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-4">Course Code</th>
                        <th class="py-3.5 px-4">Course Title &amp; Department</th>
                        <th class="py-3.5 px-4">Lecturer</th>
                        <th class="py-3.5 px-4">Credits</th>
                        <th class="py-3.5 px-4">Room &amp; Schedule</th>
                        <th class="py-3.5 px-4">Enrolled On</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Grade</th>
                        <th class="py-3.5 px-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($registrations as $reg)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3.5 px-4 font-mono font-bold text-blue-700 text-sm">
                                {{ $reg->course->code }}
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-900 text-sm">{{ $reg->course->title }}</div>
                                <div class="text-slate-500 text-[11px] mt-0.5">{{ $reg->course->department->name ?? 'General' }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-slate-600">
                                {{ $reg->course->lecturer->user->name ?? 'TBA' }}
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-slate-800">
                                {{ $reg->course->credits }} CUs
                            </td>
                            <td class="py-3.5 px-4 text-slate-600">
                                <div class="font-medium text-slate-800">{{ $reg->course->room ?? 'TBA' }}</div>
                                <div class="text-slate-400 text-[10px]">{{ $reg->course->schedule ?? 'TBA' }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-slate-500 text-[11px]">
                                {{ $reg->created_at->format('M d, Y') }}
                            </td>
                            <td class="py-3.5 px-4">
                                @if($reg->status === 'registered')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Enrolled
                                    </span>
                                @elseif($reg->status === 'dropped')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                        Dropped
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                        Completed
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 font-bold font-mono text-slate-800 text-xs">
                                {{ $reg->grade ?? '—' }}
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                @if($reg->status === 'registered')
                                    <form method="POST" action="{{ route('student.registrations.drop', $reg) }}" onsubmit="return confirm('Are you sure you want to drop {{ $reg->course->code }}?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 rounded text-xs font-semibold text-rose-600 hover:text-rose-800 hover:bg-rose-50 transition">
                                            Drop
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('student.courses.register') }}" class="inline">
                                        @csrf
                                        <input type="hidden" name="course_id" value="{{ $reg->course_id }}">
                                        <button type="submit" class="px-2.5 py-1 rounded text-xs font-semibold text-emerald-600 hover:text-emerald-800 hover:bg-emerald-50 transition">
                                            Re-register
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-12 text-center text-slate-500">
                                <i data-lucide="book-open" class="w-8 h-8 text-slate-300 mx-auto mb-2"></i>
                                <p class="text-sm font-semibold">You have no course registrations recorded.</p>
                                <p class="text-xs text-slate-400 mt-1 mb-4">Go to the course catalog to select your modules.</p>
                                <a href="{{ route('student.courses') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#2563eb] text-white text-xs font-semibold hover:bg-[#1d4ed8]">
                                    Browse Available Courses
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($registrations->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $registrations->links() }}
            </div>
        @endif
    </div>

    <!-- Registration Policies Notice -->
    <div class="p-4 rounded-xl bg-blue-50/80 border border-blue-200 text-xs text-blue-900 flex items-start gap-3">
        <i data-lucide="info" class="w-4 h-4 text-blue-600 shrink-0 mt-0.5"></i>
        <div class="space-y-1">
            <p class="font-bold">Course Registration &amp; Drop Policy:</p>
            <p class="text-blue-800">
                Course registration changes (add/drop) are permitted through week 3 of the academic semester. A minimum of 12 credit units and maximum of 24 credit units are required for full-time standing.
            </p>
        </div>
    </div>
</div>
@endsection

