<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - AmikomEventHub')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 flex flex-col md:flex-row min-h-screen transition-colors duration-200">

    <!-- Mobile Top Header Bar (Show on small screens) -->
    <header class="md:hidden bg-slate-900 text-white p-4 flex items-center justify-between border-b border-slate-800 sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-black text-sm">AH</div>
            <span class="font-extrabold text-sm tracking-tight">AmikomEventHub Admin</span>
        </div>
        <button id="adminMobileToggle" type="button" class="p-2 text-slate-300 hover:text-white rounded-lg bg-slate-800">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
    </header>

    <!-- Sidebar Admin -->
    <aside id="adminSidebar" class="hidden md:flex w-64 bg-slate-900 dark:bg-slate-900 border-r border-slate-800 text-slate-200 flex-col p-6 space-y-8 sticky top-0 h-screen shrink-0 z-40">
        <!-- Brand Header -->
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-black text-xl shadow-md shadow-indigo-500/20">AH</div>
            <span class="text-lg font-extrabold text-white tracking-tight">AmikomEventHub</span>
        </div>

        <!-- Main Navigation -->
        <nav class="flex-1 space-y-1.5 overflow-y-auto">
            <p class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400 mb-3 px-3">Main Menu</p>
    
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition {{ Request::is('admin/dashboard') || Request::is('admin') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span>Dashboard</span>
            </a>

            <!-- Kelola Transaksi -->
            <a href="{{ route('admin.transactions.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition {{ Request::is('admin/transactions*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <span>Kelola Transaksi</span>
            </a>

            <!-- Kelola Event -->
            <a href="{{ route('admin.events.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition {{ Request::is('admin/events*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span>Kelola Event</span>
            </a>

            <!-- Kelola Kategori -->
            <a href="{{ route('admin.categories.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition {{ Request::is('admin/categories*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <span>Kelola Kategori</span>
            </a>

            <!-- Kelola Partner -->
            <a href="{{ route('admin.partners.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition {{ Request::is('admin/partners*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <span>Kelola Partner</span>
            </a>

            <!-- Kelola Organizer -->
            <a href="{{ route('admin.organizers.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition {{ Request::is('admin/organizers*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0H7"></path></svg>
                <span>Kelola Organizer</span>
            </a>
        </nav>

        <!-- Footer Actions Sidebar -->
        <div class="pt-4 border-t border-slate-800 space-y-2 text-xs font-semibold">
            <button onclick="toggleDarkMode()" 
                    class="w-full flex items-center justify-between px-3.5 py-2 rounded-xl bg-slate-800/60 hover:bg-slate-800 text-slate-300 transition">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Mode Gelap
                </span>
                <span class="text-[10px] uppercase font-extrabold px-2 py-0.5 bg-indigo-600 text-white rounded-md">SWITCH</span>
            </button>

            <a href="/" class="flex items-center gap-2.5 px-3.5 py-2 text-slate-400 hover:text-white transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span>Ke Halaman Utama</span>
            </a>

            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2.5 px-3.5 py-2 text-rose-400 hover:text-rose-300 hover:bg-rose-950/40 rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span>Keluar Akun Admin</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
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
            const toggle = document.getElementById('adminMobileToggle');
            const sidebar = document.getElementById('adminSidebar');
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
