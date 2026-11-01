<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — University Management System</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
                        gold: {
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                        },
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                    },
                }
            }
        };
    </script>
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="min-h-full flex flex-col font-sans antialiased text-slate-800 bg-slate-100">

    <!-- Mobile Drawer Overlay Toggle -->
    <input type="checkbox" id="sidebar-toggle" class="peer hidden">
    <label for="sidebar-toggle" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-40 hidden peer-checked:block lg:!hidden"></label>

    <div class="flex flex-1 min-h-screen">
        <!-- Sidebar Navigation -->
        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-slate-300 flex flex-col transition-transform duration-200 ease-in-out -translate-x-full peer-checked:translate-x-0 lg:translate-x-0 lg:static lg:inset-0">
            <!-- Sidebar Header -->
            <div class="h-20 flex items-center justify-between px-5 border-b border-slate-800 bg-slate-950/40">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="h-9 w-9 object-contain">
                    <div>
                        <span class="font-bold text-white text-sm tracking-tight block">University Portal</span>
                        <span class="text-[11px] text-blue-400 font-medium block">Academic Management</span>
                    </div>
                </a>
                <label for="sidebar-toggle" class="lg:hidden p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 cursor-pointer">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </label>
            </div>

            <!-- User Status Card -->
            <div class="p-4 mx-3 my-3 rounded-xl bg-slate-800/60 border border-slate-700/60 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-600/30 text-blue-400 flex items-center justify-center font-bold text-sm shrink-0 border border-blue-500/30">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-semibold text-white truncate">{{ Auth::user()->name ?? 'Guest User' }}</p>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        @if(Auth::user()?->isAdmin())
                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-semibold bg-purple-900/60 text-purple-300 border border-purple-700/40">Admin</span>
                        @elseif(Auth::user()?->isLecturer())
                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-900/60 text-emerald-300 border border-emerald-700/40">Lecturer</span>
                        @else
                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-semibold bg-blue-900/60 text-blue-300 border border-blue-700/40">Student</span>
                        @endif
                        <span class="text-[11px] text-slate-400 truncate">{{ Auth::user()->email ?? '' }}</span>
                    </div>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-3 space-y-1 overflow-y-auto py-2">
                <!-- Role: Administrator Links -->
                @if(Auth::user()?->isAdmin())
                    <div class="px-3 pt-2 pb-1 text-[11px] font-semibold uppercase tracking-wider text-slate-400">Administration</div>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                        <span>Admin Overview</span>
                    </a>
                    <a href="{{ route('admin.students.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.students.*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="users" class="w-4 h-4"></i>
                        <span>Manage Students</span>
                    </a>
                    <a href="{{ route('admin.lecturers.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.lecturers.*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="graduation-cap" class="w-4 h-4"></i>
                        <span>Manage Lecturers</span>
                    </a>
                    <a href="{{ route('admin.courses.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.courses.*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="book-open" class="w-4 h-4"></i>
                        <span>Manage Courses</span>
                    </a>
                    <a href="{{ route('admin.registrations.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.registrations.*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="clipboard-list" class="w-4 h-4"></i>
                        <span>Course Registrations</span>
                    </a>
                    <a href="{{ route('admin.departments.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.departments.*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="building-2" class="w-4 h-4"></i>
                        <span>Departments</span>
                    </a>

                    <!-- Admin can also preview Lecturer and Student perspectives -->
                    <div class="px-3 pt-5 pb-1 text-[11px] font-semibold uppercase tracking-wider text-slate-400">View as Other Portals</div>
                    <a href="{{ route('lecturer.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-medium text-slate-400 hover:bg-slate-800 hover:text-slate-200">
                        <i data-lucide="presentation" class="w-4 h-4 text-emerald-400"></i>
                        <span>Lecturer Portal</span>
                    </a>
                    <a href="{{ route('student.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs font-medium text-slate-400 hover:bg-slate-800 hover:text-slate-200">
                        <i data-lucide="user-check" class="w-4 h-4 text-amber-400"></i>
                        <span>Student Portal</span>
                    </a>
                @endif

                <!-- Role: Lecturer Links -->
                @if(Auth::user()?->isLecturer())
                    <div class="px-3 pt-2 pb-1 text-[11px] font-semibold uppercase tracking-wider text-slate-400">Lecturer Workspace</div>
                    <a href="{{ route('lecturer.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('lecturer.dashboard') ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                        <span>Lecturer Dashboard</span>
                    </a>
                    <a href="{{ route('lecturer.courses') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('lecturer.courses*') ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="book-open-check" class="w-4 h-4"></i>
                        <span>Assigned Courses & Rosters</span>
                    </a>
                @endif

                <!-- Role: Student Links -->
                @if(Auth::user()?->isStudent())
                    <div class="px-3 pt-2 pb-1 text-[11px] font-semibold uppercase tracking-wider text-slate-400">Student Workspace</div>
                    <a href="{{ route('student.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('student.dashboard') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                        <span>My Academic Dashboard</span>
                    </a>
                    <a href="{{ route('student.courses') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('student.courses*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="search" class="w-4 h-4"></i>
                        <span>Available Courses Catalog</span>
                    </a>
                    <a href="{{ route('student.registrations') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('student.registrations*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i data-lucide="check-square" class="w-4 h-4"></i>
                        <span>My Registrations</span>
                    </a>
                @endif
            </nav>

            <!-- Sidebar Footer & Logout -->
            <div class="p-3 border-t border-slate-800 flex items-center justify-between">
                <a href="{{ route('home') }}" class="text-xs text-slate-400 hover:text-white flex items-center gap-1.5">
                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                    <span>Public Site</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-xs text-rose-400 hover:text-rose-300 flex items-center gap-1.5 font-medium px-2 py-1 rounded hover:bg-rose-950/40">
                        <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
                        <span>Sign out</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Wrapper -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Top Navbar -->
            <header class="h-20 bg-white border-b border-slate-200 sticky top-0 z-30 flex items-center justify-between px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-4">
                    <label for="sidebar-toggle" class="lg:hidden p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg cursor-pointer">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </label>
                    <div>
                        <h1 class="text-lg sm:text-xl font-bold text-slate-900 leading-snug">@yield('page_title', 'Dashboard')</h1>
                        <p class="text-xs text-slate-500 hidden sm:block">@yield('page_subtitle', 'University Academic Management System')</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <!-- Term badge -->
                    <span class="hidden md:inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-[#2563eb] border border-blue-100">
                        <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                        Semester 1 · 2025/2026
                    </span>

                    <!-- Quick role badge -->
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold
                        @if(Auth::user()?->isAdmin()) bg-purple-50 text-purple-700 border border-purple-200
                        @elseif(Auth::user()?->isLecturer()) bg-emerald-50 text-emerald-700 border border-emerald-200
                        @else bg-blue-50 text-blue-700 border border-blue-200 @endif">
                        <span class="w-2 h-2 rounded-full @if(Auth::user()?->isAdmin()) bg-purple-500 @elseif(Auth::user()?->isLecturer()) bg-emerald-500 @else bg-blue-500 @endif"></span>
                        {{ ucfirst(Auth::user()->role ?? 'Student') }}
                    </span>

                    <!-- Home link -->
                    <a href="{{ route('home') }}" title="Go to home" class="p-2 text-slate-500 hover:text-slate-900 hover:bg-slate-100 rounded-lg">
                        <i data-lucide="globe" class="w-5 h-5"></i>
                    </a>
                </div>
            </header>

            <!-- Alerts Banner -->
            <div class="px-4 sm:px-6 lg:px-8 pt-4">
                @if (session('success'))
                    <div class="mb-4 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600 shrink-0"></i>
                            <span class="text-sm font-medium">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <i data-lucide="alert-circle" class="w-5 h-5 text-rose-600 shrink-0"></i>
                            <span class="text-sm font-medium">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800">
                        <div class="flex items-center gap-2 mb-2 font-semibold text-sm">
                            <i data-lucide="alert-triangle" class="w-4 h-4 text-rose-600"></i>
                            <span>Please correct the errors below:</span>
                        </div>
                        <ul class="list-disc list-inside text-xs space-y-1 text-rose-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <!-- Page Content -->
            <main class="flex-1 px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
                @yield('content')
            </main>

            <!-- Dashboard Footer -->
            <footer class="py-4 px-6 border-t border-slate-200 bg-white text-xs text-slate-500 flex flex-col sm:flex-row items-center justify-between gap-2">
                <span>© {{ date('Y') }} University Academic Management System</span>
                <span>Role Active: <strong class="text-slate-700">{{ ucfirst(Auth::user()->role ?? 'Student') }}</strong> ({{ Auth::user()->name ?? 'User' }})</span>
            </footer>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
    @stack('scripts')
</body>
</html>

