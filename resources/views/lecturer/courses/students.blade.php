@extends('layouts.dashboard')

@section('title', 'Registered Students — ' . $course->code)
@section('page_title', 'Class Roster: ' . $course->code)
@section('page_subtitle', $course->title . ' · Enrolled Students')

@section('content')
<div class="space-y-6">
    <!-- Course Info Card -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <a href="{{ route('lecturer.courses') }}" class="text-xs font-semibold text-emerald-700 hover:underline flex items-center gap-1">
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Back to Courses
                </a>
                <span class="text-slate-300">/</span>
                <span class="text-xs font-mono font-bold text-slate-700">{{ $course->code }}</span>
            </div>
            <h2 class="text-xl font-extrabold text-slate-900">{{ $course->title }}</h2>
            <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500 mt-2">
                <span><strong>Credits:</strong> {{ $course->credits }} CUs</span>
                <span>•</span>
                <span><strong>Venue:</strong> {{ $course->room ?? 'TBA' }}</span>
                <span>•</span>
                <span><strong>Schedule:</strong> {{ $course->schedule ?? 'TBA' }}</span>
                <span>•</span>
                <span><strong>Term:</strong> {{ $course->semester }} ({{ $course->academic_year }})</span>
            </div>
        </div>

        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-right shrink-0">
            <span class="text-2xl font-black text-emerald-800">{{ $registrations->total() }}</span>
            <span class="text-xs text-emerald-700 block font-medium">Registered Students</span>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
        <form method="GET" action="{{ route('lecturer.courses.students', $course) }}" class="flex-1 flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[220px]">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search roster by student name, ID..."
                    class="w-full pl-9 pr-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-300 text-slate-800 focus:bg-white focus:outline-none focus:border-emerald-500">
            </div>

            <select name="status" class="text-xs py-2 px-3 rounded-xl bg-slate-50 border border-slate-300 text-slate-700 focus:bg-white focus:outline-none">
                <option value="">All Statuses</option>
                <option value="registered" {{ request('status') === 'registered' ? 'selected' : '' }}>Enrolled</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="dropped" {{ request('status') === 'dropped' ? 'selected' : '' }}>Dropped</option>
            </select>

            <button type="submit" class="px-4 py-2 rounded-xl bg-slate-800 text-white text-xs font-semibold hover:bg-slate-900 transition">
                Filter Roster
            </button>
            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('lecturer.courses.students', $course) }}" class="px-3 py-2 rounded-xl border border-slate-300 text-slate-600 text-xs hover:bg-slate-50">
                    Reset
                </a>
            @endif
        </form>

        <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold shadow-xs">
            <i data-lucide="printer" class="w-4 h-4"></i>
            <span>Print Roster</span>
        </button>
    </div>

    <!-- Students Roster Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-4">#</th>
                        <th class="py-3.5 px-4">Student ID Number</th>
                        <th class="py-3.5 px-4">Full Student Name</th>
                        <th class="py-3.5 px-4">Campus Email</th>
                        <th class="py-3.5 px-4">Program &amp; Department</th>
                        <th class="py-3.5 px-4">Year</th>
                        <th class="py-3.5 px-4">Enrollment Date</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4 text-right">Grade</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($registrations as $index => $reg)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3 px-4 text-slate-400 font-mono">
                                {{ $registrations->firstItem() + $index }}
                            </td>
                            <td class="py-3 px-4 font-mono font-bold text-emerald-800 text-xs">
                                {{ $reg->student->student_id_number ?? 'N/A' }}
                            </td>
                            <td class="py-3 px-4 font-bold text-slate-900 text-sm">
                                {{ $reg->student->user->name ?? 'Student' }}
                            </td>
                            <td class="py-3 px-4 text-slate-600">
                                {{ $reg->student->user->email ?? 'No email' }}
                            </td>
                            <td class="py-3 px-4">
                                <div class="font-medium text-slate-800">{{ $reg->student->program ?? 'Degree' }}</div>
                                <div class="text-slate-400 text-[10px]">{{ $reg->student->department->name ?? '' }}</div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-semibold text-[10px]">
                                    Year {{ $reg->student->year_of_study ?? 1 }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-slate-500 text-[11px]">
                                {{ $reg->created_at->format('M d, Y') }}
                            </td>
                            <td class="py-3 px-4">
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
                            <td class="py-3 px-4 text-right">
                                <form method="POST" action="{{ route('lecturer.courses.students.grade', [$course, $reg]) }}" class="inline-flex items-center gap-1">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="grade" value="{{ $reg->grade }}" placeholder="—" maxlength="4"
                                        class="w-12 px-1.5 py-1 text-center font-bold text-xs rounded border border-slate-300 bg-slate-50 focus:bg-white focus:outline-none focus:border-emerald-500 uppercase">
                                    <input type="hidden" name="status" value="{{ $reg->status }}">
                                    <button type="submit" class="p-1 rounded text-slate-400 hover:text-emerald-600 hover:bg-emerald-50" title="Save Grade">
                                        <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-12 text-center text-slate-500">
                                <i data-lucide="users" class="w-8 h-8 text-slate-300 mx-auto mb-2"></i>
                                <p class="text-sm font-semibold">No students registered in this course yet</p>
                                <p class="text-xs text-slate-400 mt-1">Students will appear here as they register for this course.</p>
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
</div>
@endsection

