<footer class="bg-[#0f172a] text-slate-300 mt-auto border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
            <!-- Col 1: About -->
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="University Logo" class="h-10 w-10 object-contain">
                    <div>
                        <span class="font-bold text-white text-base">University Portal</span>
                        <p class="text-xs text-slate-400">Academic Management System</p>
                    </div>
                </div>
                <p class="text-sm text-slate-400 leading-relaxed">
                    A comprehensive web-based platform empowering students to enroll in courses, lecturers to track class rosters, and administrators to orchestrate campus academics.
                </p>
                <div class="pt-2 flex items-center gap-3 text-xs text-slate-400">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-950/80 text-emerald-400 border border-emerald-800/60 font-mono">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        Academic Term Active
                    </span>
                </div>
            </div>

            <!-- Col 2: Quick Links & Role Portals -->
            <div>
                <h4 class="font-semibold text-white text-sm uppercase tracking-wider mb-4">Portal Access</h4>
                <ul class="space-y-2.5 text-sm text-slate-400">
                    <li><a href="{{ route('demo.login', 'admin') }}" class="hover:text-blue-400 transition-colors flex items-center gap-2"><i data-lucide="shield-check" class="w-4 h-4 text-blue-400"></i> Admin Management Portal</a></li>
                    <li><a href="{{ route('demo.login', 'lecturer') }}" class="hover:text-blue-400 transition-colors flex items-center gap-2"><i data-lucide="graduation-cap" class="w-4 h-4 text-emerald-400"></i> Lecturer Portal & Rosters</a></li>
                    <li><a href="{{ route('demo.login', 'student') }}" class="hover:text-blue-400 transition-colors flex items-center gap-2"><i data-lucide="book-open" class="w-4 h-4 text-amber-400"></i> Student Course Registration</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-white transition-colors">Staff & Student Login</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-white transition-colors">New Student Registration</a></li>
                </ul>
            </div>

            <!-- Col 3: Faculties & Departments -->
            <div>
                <h4 class="font-semibold text-white text-sm uppercase tracking-wider mb-4">Academic Units</h4>
                <ul class="space-y-2.5 text-sm text-slate-400">
                    <li class="flex items-start gap-2">
                        <i data-lucide="building-2" class="w-4 h-4 text-slate-500 shrink-0 mt-0.5"></i>
                        <span>Computer Science & Software Eng.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i data-lucide="building-2" class="w-4 h-4 text-slate-500 shrink-0 mt-0.5"></i>
                        <span>Electrical & Electronic Engineering</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i data-lucide="building-2" class="w-4 h-4 text-slate-500 shrink-0 mt-0.5"></i>
                        <span>Business Administration & Management</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i data-lucide="building-2" class="w-4 h-4 text-slate-500 shrink-0 mt-0.5"></i>
                        <span>Office of Academic Registrar</span>
                    </li>
                </ul>
            </div>

            <!-- Col 4: Contact info -->
            <div>
                <h4 class="font-semibold text-white text-sm uppercase tracking-wider mb-4">Academic Helpdesk</h4>
                <ul class="space-y-3 text-sm text-slate-400">
                    <li class="flex items-center gap-2.5">
                        <i data-lucide="mail" class="w-4 h-4 text-blue-400 shrink-0"></i>
                        <span>academic.registrar@university.ac.ug</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <i data-lucide="phone" class="w-4 h-4 text-blue-400 shrink-0"></i>
                        <span>+256 (0) 414 123 456</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <i data-lucide="map-pin" class="w-4 h-4 text-blue-400 shrink-0"></i>
                        <span>Main Campus, Academic Senate Block</span>
                    </li>
                    <li class="pt-2">
                        <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 text-xs font-semibold px-3 py-2 rounded-lg bg-blue-600/20 text-blue-400 hover:bg-blue-600/30 border border-blue-500/30 transition">
                            <i data-lucide="help-circle" class="w-3.5 h-3.5"></i>
                            Contact Helpdesk
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="pt-8 border-t border-slate-800/80 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
            <p>© {{ date('Y') }} University Management System. Developed with Laravel. All rights reserved.</p>
            <div class="flex items-center gap-4">
                <span>Academic Session: 2025/2026</span>
                <span>•</span>
                <span>Term: Semester 1</span>
            </div>
        </div>
    </div>
</footer>
