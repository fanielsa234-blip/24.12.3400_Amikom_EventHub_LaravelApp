<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Portal Organizer - AmikomEventHub')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 flex flex-col md:flex-row min-h-screen transition-colors duration-200">

    <!-- Mobile Top Header Bar (Show on small screens) -->
    <header class="md:hidden bg-slate-900 text-white p-4 flex items-center justify-between border-b border-slate-800 sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-black text-sm">OH</div>
            <span class="font-extrabold text-sm tracking-tight">Portal Organizer</span>
        </div>
        <button id="organizerMobileToggle" type="button" class="p-2 text-slate-300 hover:text-white rounded-lg bg-slate-800">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
    </header>

    <!-- Left Sidebar Portal Organizer -->
    <aside id="organizerSidebar" class="hidden md:flex w-64 bg-slate-900 dark:bg-slate-900 border-r border-slate-800 text-slate-200 flex-col p-6 space-y-8 sticky top-0 h-screen shrink-0 z-40">
        <!-- Brand Header -->
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-black text-xl shadow-md shadow-indigo-500/20">OH</div>
            <div>
                <span class="text-lg font-extrabold text-white tracking-tight leading-none block">Portal Organizer</span>
                <span class="text-[10px] font-bold text-indigo-400 uppercase tracking-wider">AmikomEventHub</span>
            </div>
        </div>

        <!-- User/Organizer Pill -->
        <div class="p-3 bg-slate-800/80 rounded-2xl border border-slate-700/60 flex items-center gap-3">
            <div class="w-8 h-8 bg-indigo-600/30 text-indigo-300 rounded-xl flex items-center justify-center font-extrabold text-xs shrink-0 border border-indigo-500/30">
                {{ strtoupper(substr(auth()->user()->name ?? 'P', 0, 2)) }}
            </div>
            <div class="overflow-hidden">
                <p class="text-xs font-bold text-white truncate">{{ auth()->user()->name ?? 'Panitia' }}</p>
                <p class="text-[10px] text-slate-400 truncate">{{ auth()->user()->email ?? '-' }}</p>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 space-y-1.5 overflow-y-auto">
            <p class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400 mb-3 px-3">Menu Organizer</p>

            <!-- Dashboard -->
            <a href="{{ route('organizer.dashboard') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition {{ Request::is('organizer/dashboard') || Request::is('organizer') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span>Dashboard</span>
            </a>

            <!-- Event Saya -->
            <a href="{{ route('organizer.events.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition {{ Request::is('organizer/events*') && !Request::is('organizer/events/create') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span>Event Saya</span>
            </a>


        </nav>

        <!-- Footer Actions Sidebar -->
        <div class="pt-4 border-t border-slate-800 space-y-2 text-xs font-semibold">
            <!-- Toggle Mode Gelap -->
            <button onclick="toggleDarkMode()" 
                    class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl bg-slate-800/60 hover:bg-slate-800 text-slate-300 transition">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Mode Gelap
                </span>
                <span class="text-[10px] uppercase font-extrabold px-2 py-0.5 bg-indigo-600 text-white rounded-md">SWITCH</span>
            </button>

            <!-- Ke Portal Publik -->
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 px-3.5 py-2 text-slate-400 hover:text-white transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span>Ke Portal Publik</span>
            </a>

            <!-- Logout -->
            <form action="{{ route('user.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2.5 px-3.5 py-2 text-rose-400 hover:text-rose-300 hover:bg-rose-950/40 rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span>Keluar Akun</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Body -->
    <main class="flex-1 p-4 sm:p-8 md:p-10 overflow-y-auto">
        @yield('content')
    </main>

    <script>
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
            const isDark = document.documentElement.classList.contains('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        }
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }

        // Mobile Sidebar Drawer Toggle
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.getElementById('organizerMobileToggle');
            const sidebar = document.getElementById('organizerSidebar');
            if (toggle && sidebar) {
                toggle.addEventListener('click', function () {
                    sidebar.classList.toggle('hidden');
                    sidebar.classList.toggle('flex');
                    sidebar.classList.toggle('fixed');
                    sidebar.classList.toggle('inset-0');
                    sidebar.classList.toggle('w-full');
                });
            }
        });
    </script>
</body>
</html>
