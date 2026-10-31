@extends('layouts.main')

@section('title', 'Academic Contact Inquiries — University Management System')

@section('content')
    <section class="relative pt-28 pb-16 bg-white min-h-[70vh]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full py-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
                <div>
                    <span class="text-xs font-bold text-[#2563eb] uppercase tracking-wider mb-1 block">Records</span>
                    <h1 class="text-3xl font-extrabold text-slate-900 leading-tight">Submitted Inquiries</h1>
                    <p class="text-sm text-slate-500 mt-1 max-w-xl">Public inquiries sent to the academic helpdesk and registry offices.</p>
                </div>
                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-[#2563eb] text-white rounded-xl font-semibold text-xs hover:bg-[#1d4ed8] shadow-xs transition">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span>Submit New Inquiry</span>
                </a>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 uppercase tracking-wider font-semibold">
                            <tr>
                                <th class="py-3.5 px-4">Name</th>
                                <th class="py-3.5 px-4">Email</th>
                                <th class="py-3.5 px-4">Department / Unit</th>
                                <th class="py-3.5 px-4">Message</th>
                                <th class="py-3.5 px-4 text-right">Received Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse ($contacts as $contact)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="py-3.5 px-4 font-bold text-slate-900">{{ $contact->full_name }}</td>
                                    <td class="py-3.5 px-4 text-slate-600 font-mono text-[11px]">{{ $contact->campus_email }}</td>
                                    <td class="py-3.5 px-4">
                                        <span class="text-[11px] px-2.5 py-0.5 rounded-full font-semibold bg-blue-50 text-[#2563eb] border border-blue-100">
                                            {{ $contact->department }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-slate-600 max-w-md">
                                        <p class="line-clamp-2 text-xs leading-relaxed">{{ $contact->message }}</p>
                                    </td>
                                    <td class="py-3.5 px-4 text-right text-slate-400 text-[11px]">
                                        {{ $contact->created_at ? $contact->created_at->diffForHumans() : 'Recently' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-slate-500">
                                        <i data-lucide="inbox" class="w-8 h-8 text-slate-300 mx-auto mb-2"></i>
                                        <p class="font-semibold text-sm">No contact inquiries found</p>
                                        <p class="text-xs text-slate-400 mt-1">Submitted questions from students or staff will appear here.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($contacts->hasPages())
                    <div class="p-4 border-t border-slate-100">
                        {{ $contacts->links() }}
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
