@extends('layouts.dashboard')

@section('title', 'Manage Course Registrations')
@section('page_title', 'Course Registrations & Enrollments')
@section('page_subtitle', 'Master student enrollment records, course add/drop statuses, and grading records')

@section('content')
<div class="space-y-6">
    <!-- Top Bar with Manual Enrollment Trigger and Filters -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
        <!-- Search and Filters -->
        <form method="GET" action="{{ route('admin.registrations.index') }}" class="flex-1 flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[200px]">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by student, ID, course..."
                    class="w-full pl-9 pr-3 py-2 text-xs rounded-xl bg-slate-50 border border-slate-300 text-slate-800 focus:bg-white focus:outline-none focus:border-blue-500">
            </div>

            <select name="course_id" class="text-xs py-2 px-3 rounded-xl bg-slate-50 border border-slate-300 text-slate-700 focus:bg-white focus:outline-none">
                <option value="">All Courses</option>
                @foreach($courses as $c)
                    <option value="{{ $c->id }}" {{ request('course_id') == $c->id ? 'selected' : '' }}>{{ $c->code }} - {{ $c->title }}</option>
                @endforeach
            </select>

            <select name="status" class="text-xs py-2 px-3 rounded-xl bg-slate-50 border border-slate-300 text-slate-700 focus:bg-white focus:outline-none">
                <option value="">All Statuses</option>
                <option value="registered" {{ request('status') === 'registered' ? 'selected' : '' }}>Enrolled</option>
                <option value="dropped" {{ request('status') === 'dropped' ? 'selected' : '' }}>Dropped</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
            </select>

            <button type="submit" class="px-4 py-2 rounded-xl bg-slate-800 text-white text-xs font-semibold hover:bg-slate-900 transition">
                Filter
            </button>
            @if(request()->hasAny(['search', 'course_id', 'status']))
                <a href="{{ route('admin.registrations.index') }}" class="px-3 py-2 rounded-xl border border-slate-300 text-slate-600 text-xs hover:bg-slate-50">
                    Reset
                </a>
            @endif
        </form>

        <!-- Quick Manual Enroll Toggle Button (Checkbox Modal) -->
        <label for="enroll-modal-toggle" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-[#2563eb] text-white text-xs font-semibold hover:bg-[#1d4ed8] shadow-xs shrink-0 cursor-pointer transition">
            <i data-lucide="user-plus" class="w-4 h-4"></i>
            <span>Enroll Student Manually</span>
        </label>
    </div>

    <!-- Registrations Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-4">Student</th>
                        <th class="py-3.5 px-4">Enrolled Course</th>
                        <th class="py-3.5 px-4">Department &amp; Lecturer</th>
                        <th class="py-3.5 px-4">Term</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Grade</th>
                        <th class="py-3.5 px-4">Registration Date</th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($registrations as $reg)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3 px-4">
                                <div class="font-bold text-slate-900 text-sm">{{ $reg->student->user->name ?? 'Student' }}</div>
                                <div class="text-blue-700 font-mono text-[11px] font-medium">{{ $reg->student->student_id_number ?? 'N/A' }}</div>
                                <div class="text-slate-400 text-[10px]">{{ $reg->student->user->email ?? '' }}</div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="inline-block px-1.5 py-0.5 rounded bg-blue-50 text-blue-700 font-mono font-bold text-[11px] mb-0.5">
                                    {{ $reg->course->code ?? 'N/A' }}
                                </span>
                                <div class="font-medium text-slate-900">{{ $reg->course->title ?? '' }}</div>
                                <div class="text-slate-500 text-[10px]">{{ $reg->course->credits ?? 0 }} Credit Units</div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="text-slate-800 font-medium">{{ $reg->course->department->name ?? 'General' }}</div>
                                <div class="text-slate-500 text-[11px]">{{ $reg->course->lecturer->user->name ?? 'Unassigned' }}</div>
                            </td>
                            <td class="py-3 px-4 text-[11px] text-slate-600">
                                <div>{{ $reg->semester }}</div>
                                <div class="text-slate-400">{{ $reg->academic_year }}</div>
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
                            <td class="py-3 px-4">
                                <form method="POST" action="{{ route('admin.registrations.update', $reg) }}" class="flex items-center gap-1">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="grade" value="{{ $reg->grade }}" placeholder="—" maxlength="5"
                                        class="w-12 px-1.5 py-1 text-center font-bold text-xs rounded border border-slate-300 bg-slate-50 focus:bg-white focus:outline-none focus:border-blue-500 uppercase">
                                    <input type="hidden" name="status" value="{{ $reg->status }}">
                                    <button type="submit" class="p-1 rounded text-slate-400 hover:text-blue-600 hover:bg-blue-50" title="Save Grade">
                                        <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                    </button>
                                </form>
                            </td>
                            <td class="py-3 px-4 text-slate-500 text-[11px]">
                                {{ $reg->created_at->format('M d, Y') }}<br>
                                <span class="text-slate-400 text-[10px]">{{ $reg->created_at->format('h:i A') }}</span>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="inline-flex items-center gap-1">
                                    @if($reg->status === 'registered')
                                        <form method="POST" action="{{ route('admin.registrations.update', $reg) }}" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="dropped">
                                            <button type="submit" class="px-2 py-1 rounded text-[11px] text-amber-700 bg-amber-50 hover:bg-amber-100 font-medium" title="Mark as Dropped">
                                                Drop
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.registrations.update', $reg) }}" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="registered">
                                            <button type="submit" class="px-2 py-1 rounded text-[11px] text-emerald-700 bg-emerald-50 hover:bg-emerald-100 font-medium" title="Re-enroll">
                                                Re-enroll
                                            </button>
                                        </form>
                                    @endif

                                    <form method="POST" action="{{ route('admin.registrations.destroy', $reg) }}" onsubmit="return confirm('Remove this registration record?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50" title="Delete record">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-500">
                                <i data-lucide="clipboard-list" class="w-8 h-8 text-slate-300 mx-auto mb-2"></i>
                                <p class="text-sm font-semibold">No course registrations found</p>
                                <p class="text-xs text-slate-400 mt-1">Enroll a student or adjust filters.</p>
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

    <!-- Manual Enrollment Modal (Controlled by CSS toggle) -->
    <input type="checkbox" id="enroll-modal-toggle" class="peer hidden">
    <div class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs hidden peer-checked:flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl border border-slate-200">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
                <h3 class="text-base font-bold text-slate-900">Manual Student Course Enrollment</h3>
                <label for="enroll-modal-toggle" class="p-1 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 cursor-pointer">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </label>
            </div>

            <form action="{{ route('admin.registrations.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="student_id" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Select Student <span class="text-rose-500">*</span></label>
                    <select id="student_id" name="student_id" required
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                        <option value="">Choose Student...</option>
                        @foreach($students as $stu)
                            <option value="{{ $stu->id }}">{{ $stu->user->name ?? 'Student' }} ({{ $stu->student_id_number }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="course_id" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Select Course <span class="text-rose-500">*</span></label>
                    <select id="course_id" name="course_id" required
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                        <option value="">Choose Course...</option>
                        @foreach($courses as $c)
                            <option value="{{ $c->id }}">{{ $c->code }} - {{ $c->title }} ({{ $c->credits }} CUs)</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="semester" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Semester <span class="text-rose-500">*</span></label>
                        <select id="semester" name="semester" required
                            class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                            <option value="Semester 1">Semester 1</option>
                            <option value="Semester 2">Semester 2</option>
                            <option value="Recess Term">Recess Term</option>
                        </select>
                    </div>
                    <div>
                        <label for="academic_year" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Academic Year <span class="text-rose-500">*</span></label>
                        <input type="text" id="academic_year" name="academic_year" value="2025/2026" required
                            class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                    </div>
                </div>

                <div>
                    <label for="status" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Enrollment Status <span class="text-rose-500">*</span></label>
                    <select id="status" name="status" required
                        class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                        <option value="registered">Registered / Enrolled</option>
                        <option value="dropped">Dropped</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                    <label for="enroll-modal-toggle" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 text-xs font-semibold hover:bg-slate-50 cursor-pointer">
                        Cancel
                    </label>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#2563eb] text-white text-xs font-semibold hover:bg-[#1d4ed8] shadow-sm transition">
                        Confirm Enrollment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
