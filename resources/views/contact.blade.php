@extends('layouts.main')

@section('title', 'Academic Inquiries & Contact — University Management System')

@section('content')
    <!-- Contact Section -->
    <section class="relative pt-28 pb-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="grid lg:grid-cols-2 gap-10 lg:gap-16 items-start py-8">
                <div>
                    <span class="text-xs font-bold text-[#2563eb] uppercase tracking-wider mb-2 block">Registrar &amp; Helpdesk</span>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-4 leading-tight">
                        Need Academic Assistance?<br>
                        <span class="text-[#2563eb]">We're here on campus.</span>
                    </h1>
                    <p class="text-sm text-slate-500 mb-8 leading-relaxed">
                        Have inquiries regarding course allocations, registration clearance, syllabus prerequisites, or department transfers? Send us a message or visit our campus registry offices.
                    </p>

                    <div class="space-y-4">
                        <div class="flex items-start gap-4 p-4 rounded-2xl border border-slate-200 bg-slate-50/50">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center shrink-0">
                                <i data-lucide="mail" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Email Inquiry</p>
                                <a href="mailto:academic.registrar@university.ac.ug" class="text-sm font-bold text-slate-900 hover:text-blue-600 transition">academic.registrar@university.ac.ug</a>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 p-4 rounded-2xl border border-slate-200 bg-slate-50/50">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                <i data-lucide="phone" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Telephone Inquiries</p>
                                <p class="text-sm font-bold text-slate-900">Admissions &amp; Records: +256 (0) 414 123 456</p>
                                <p class="text-xs text-slate-500">Student Services: +256 (0) 414 123 457</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 p-4 rounded-2xl border border-slate-200 bg-slate-50/50">
                            <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center shrink-0">
                                <i data-lucide="clock" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Office Hours</p>
                                <p class="text-sm font-bold text-slate-900">Monday – Friday: 8:00 AM – 5:00 PM</p>
                                <p class="text-xs text-slate-500">Closed on public holidays and university recesses</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-900 mb-1">Submit an Academic Inquiry</h2>
                    <p class="text-xs text-slate-500 mb-6">Our academic advising desk will respond within 24 hours.</p>

                    @if(session('success'))
                        <div class="mb-5 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-800">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="full_name" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Your Full Name <span class="text-rose-500">*</span></label>
                            <input type="text" id="full_name" name="full_name" required value="{{ old('full_name') }}" placeholder="e.g. John Doe"
                                class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                        </div>

                        <div>
                            <label for="campus_email" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Your Email Address <span class="text-rose-500">*</span></label>
                            <input type="email" id="campus_email" name="campus_email" required value="{{ old('campus_email') }}" placeholder="you@university.ac.ug"
                                class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                        </div>

                        <div>
                            <label for="department" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Department / Inquiring Unit <span class="text-rose-500">*</span></label>
                            <select id="department" name="department" required
                                class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">
                                <option value="Academic Registrar">Academic Registrar</option>
                                <option value="Computer Science">Computer Science Department</option>
                                <option value="Engineering">Engineering Department</option>
                                <option value="Business Administration">Business Administration</option>
                                <option value="Examinations Office">Examinations Office</option>
                                <option value="ICT Support">ICT Directorate</option>
                            </select>
                        </div>

                        <div>
                            <label for="message" class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">Your Message <span class="text-rose-500">*</span></label>
                            <textarea id="message" name="message" rows="4" required placeholder="Describe your question in detail..."
                                class="block w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-sm focus:bg-white focus:outline-none focus:border-blue-500">{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-[#2563eb] text-white font-semibold text-xs hover:bg-[#1d4ed8] shadow-sm transition">
                            <i data-lucide="send" class="w-4 h-4"></i>
                            <span>Send Message</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Academic Offices Locations -->
    <section class="py-16 bg-slate-50 border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="text-xs font-bold text-[#2563eb] uppercase tracking-wider">Campus Locations</span>
                <h3 class="text-2xl font-bold text-slate-900 mt-1">Registry &amp; Academic Advising Desks</h3>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-5 rounded-2xl bg-white border border-slate-200 text-center shadow-xs">
                    <div class="w-10 h-10 mx-auto rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-3">
                        <i data-lucide="building" class="w-5 h-5"></i>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm mb-0.5">Senate Registry</h4>
                    <p class="text-xs text-slate-500">Academic Senate House, Floor 1</p>
                </div>

                <div class="p-5 rounded-2xl bg-white border border-slate-200 text-center shadow-xs">
                    <div class="w-10 h-10 mx-auto rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3">
                        <i data-lucide="laptop" class="w-5 h-5"></i>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm mb-0.5">ICT Directorate</h4>
                    <p class="text-xs text-slate-500">Main University Library, Wing B</p>
                </div>

                <div class="p-5 rounded-2xl bg-white border border-slate-200 text-center shadow-xs">
                    <div class="w-10 h-10 mx-auto rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center mb-3">
                        <i data-lucide="graduation-cap" class="w-5 h-5"></i>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm mb-0.5">Examinations Bureau</h4>
                    <p class="text-xs text-slate-500">Central Records Office, Room 102</p>
                </div>

                <div class="p-5 rounded-2xl bg-white border border-slate-200 text-center shadow-xs">
                    <div class="w-10 h-10 mx-auto rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-3">
                        <i data-lucide="users" class="w-5 h-5"></i>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm mb-0.5">Dean of Students</h4>
                    <p class="text-xs text-slate-500">Student Center Complex, Gate 1</p>
                </div>
            </div>
        </div>
    </section>
@endsection
