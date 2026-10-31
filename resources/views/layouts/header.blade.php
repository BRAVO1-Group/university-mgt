<header class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Brand -->
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('assets/img/logo.png') }}" alt="University Portal" class="h-11 w-11 object-contain">
                <div>
                    <p class="text-base font-bold text-slate-900 leading-tight">University Academic Portal</p>
                    <p class="text-[11px] text-slate-500 font-medium">Students, Lecturers & Course Management</p>
                </div>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center gap-6">
                <a href="{{ route('home') }}" class="text-sm font-medium {{ request()->routeIs('home') ? 'text-[#2563eb] font-semibold' : 'text-slate-600 hover:text-slate-900' }}">Home</a>
                <a href="{{ route('home') }}#departments" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">Departments</a>
                <a href="{{ route('home') }}#courses" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">Course Catalog</a>
                <a href="{{ route('contact') }}" class="text-sm font-medium {{ request()->routeIs('contact') ? 'text-[#2563eb] font-semibold' : 'text-slate-600 hover:text-slate-900' }}">Contact</a>

                <!-- Demo Login Fast Switcher -->
                <div class="hidden lg:flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-200 text-xs">
                    <span class="text-slate-500 font-medium mr-1">Demo:</span>
                    <a href="{{ route('demo.login', 'admin') }}" class="px-2 py-0.5 rounded bg-white hover:bg-slate-200 text-slate-700 font-semibold shadow-xs">Admin</a>
                    <a href="{{ route('demo.login', 'lecturer') }}" class="px-2 py-0.5 rounded bg-white hover:bg-slate-200 text-slate-700 font-semibold shadow-xs">Lecturer</a>
                    <a href="{{ route('demo.login', 'student') }}" class="px-2 py-0.5 rounded bg-white hover:bg-slate-200 text-slate-700 font-semibold shadow-xs">Student</a>
                </div>

                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-[#2563eb] text-white rounded-lg font-medium text-sm hover:bg-[#1d4ed8] shadow-sm">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                        Dashboard ({{ ucfirst(Auth::user()->role) }})
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-3 py-2 border border-slate-200 text-slate-600 hover:text-red-600 rounded-lg text-sm font-medium hover:bg-slate-50 transition">
                            Sign out
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 border border-slate-200 text-slate-700 rounded-lg font-medium text-sm hover:bg-slate-50 hover:border-slate-300 transition">
                        Sign in
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-[#2563eb] text-white rounded-lg font-medium text-sm hover:bg-[#1d4ed8] shadow-sm transition">
                        Enroll / Register
                    </a>
                @endauth
            </div>

            <!-- Mobile menu hamburger -->
            <label for="mobile-nav-toggle" class="md:hidden p-2 text-slate-700 hover:bg-slate-100 rounded-lg cursor-pointer">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </label>
        </div>

        <!-- Mobile Drawer -->
        <input type="checkbox" id="mobile-nav-toggle" class="peer hidden">
        <div class="hidden peer-checked:block md:!hidden py-4 border-t border-slate-200">
            <div class="flex flex-col gap-3">
                <a href="{{ route('home') }}" class="text-slate-800 text-sm font-medium py-1">Home</a>
                <a href="{{ route('home') }}#departments" class="text-slate-600 hover:text-slate-900 text-sm font-medium py-1">Departments</a>
                <a href="{{ route('home') }}#courses" class="text-slate-600 hover:text-slate-900 text-sm font-medium py-1">Courses</a>
                <a href="{{ route('contact') }}" class="text-slate-600 hover:text-slate-900 text-sm font-medium py-1">Contact</a>

                <div class="pt-2 pb-1 border-t border-slate-100">
                    <p class="text-xs text-slate-500 font-semibold mb-2">Fast Demo Portals:</p>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('demo.login', 'admin') }}" class="px-3 py-1 bg-slate-100 text-xs font-semibold rounded-md text-slate-700">Admin</a>
                        <a href="{{ route('demo.login', 'lecturer') }}" class="px-3 py-1 bg-slate-100 text-xs font-semibold rounded-md text-slate-700">Lecturer</a>
                        <a href="{{ route('demo.login', 'student') }}" class="px-3 py-1 bg-slate-100 text-xs font-semibold rounded-md text-slate-700">Student</a>
                    </div>
                </div>

                <div class="flex flex-col gap-2 pt-2 border-t border-slate-100">
                    @auth
                        <a href="{{ route('dashboard') }}" class="w-full text-center py-2.5 bg-[#2563eb] text-white rounded-lg font-medium text-sm">
                            Open Portal ({{ ucfirst(Auth::user()->role) }})
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-center py-2 border border-slate-200 text-slate-600 rounded-lg text-sm font-medium">
                                Sign out
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="w-full text-center py-2.5 border border-slate-200 text-slate-800 rounded-lg font-medium text-sm">Sign in</a>
                        <a href="{{ route('register') }}" class="w-full text-center py-2.5 bg-[#2563eb] text-white rounded-lg font-medium text-sm">Enroll / Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</header>
