<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AmikomEventHub - Platform Tiket Event Kampus')</title>
    
    <!-- Script Auto Theme Init (Gelap / Terang) -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-nav { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(12px); }
        .dark .glass-nav { background: rgba(15, 23, 42, 0.9); backdrop-filter: blur(12px); }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 min-h-screen flex flex-col antialiased selection:bg-indigo-500 selection:text-white transition-colors duration-200">

    <!-- Responsive Sticky Navigation Header (Clean & Minimal) -->
    <header class="sticky top-0 z-50 px-4 sm:px-6 py-3 transition-all duration-300">
        <nav class="max-w-7xl mx-auto glass-nav rounded-2xl border border-white/60 dark:border-slate-800 shadow-lg shadow-slate-200/50 dark:shadow-slate-950/50 px-5 py-2.5 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group shrink-0">
                <div class="w-9 h-9 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-black text-lg shadow-sm shadow-indigo-200 dark:shadow-indigo-900 group-hover:scale-105 transition-transform">
                    AH
                </div>
                <span class="text-lg font-black text-slate-900 dark:text-white tracking-tight group-hover:text-indigo-600 transition-colors">
                    AmikomEventHub
                </span>
            </a>
            
            <!-- Middle Navigation Menu (Desktop md:flex) -->
            <div class="hidden md:flex items-center gap-6 font-bold text-xs sm:text-sm text-slate-600 dark:text-slate-300">
                <a href="/#events" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Jelajahi</a>
                <a href="/#kategori" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Kategori</a>
                <a href="{{ route('organizer.register') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors {{ Request::is('organizer/register') ? 'text-indigo-600 font-extrabold' : '' }}">Mitra Organizer</a>
                <a href="{{ route('tentang') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors {{ Request::is('tentang') ? 'text-indigo-600 font-extrabold' : '' }}">Tentang Kami</a>
                <a href="{{ route('bantuan') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors {{ Request::is('bantuan') ? 'text-indigo-600 font-extrabold' : '' }}">Bantuan</a>
            </div>
            
            <!-- Right Action Bar (Compact & Sleek) -->
            <div class="hidden md:flex items-center gap-2">
                <!-- Toggle Mode Gelap / Terang -->
                <button onclick="toggleGlobalTheme()" type="button" class="p-2 text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-amber-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition focus:outline-none" title="Ubah Mode Gelap / Terang">
                    <svg class="w-5 h-5 hidden dark:block text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <svg class="w-5 h-5 block dark:hidden text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                </button>

                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-extrabold shadow-sm transition flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                            <span>Admin</span>
                        </a>
                    @elseif(Auth::user()->isOrganizer())
                        <a href="{{ route('organizer.dashboard') }}" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-extrabold shadow-sm transition flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0H9"></path></svg>
                            <span>Tenant Hub</span>
                        </a>
                    @endif

                    <!-- Sleek User Profile Pill -->
                    <div class="flex items-center gap-2 px-3 py-1.5 bg-slate-100/90 dark:bg-slate-800/90 rounded-xl border border-slate-200/60 dark:border-slate-700">
                        @if(Auth::user()->avatar)
                            <img src="{{ Auth::user()->avatar }}" alt="Avatar" class="w-6 h-6 rounded-full object-cover">
                        @else
                            <div class="w-6 h-6 bg-indigo-600 text-white font-bold rounded-full flex items-center justify-center text-[10px]">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                        @endif
                        <span class="text-xs font-extrabold text-slate-800 dark:text-slate-100 max-w-[110px] truncate">{{ explode(' ', Auth::user()->name)[0] }}</span>
                    </div>

                    <!-- Validasi Konfirmasi Logout -->
                    <form action="{{ route('user.logout') }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin keluar dari akun?');">
                        @csrf
                        <button type="submit" title="Keluar Akun" class="p-1.5 text-slate-400 hover:text-rose-600 dark:hover:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-900/30 rounded-xl transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-extrabold text-xs shadow-md shadow-indigo-200 dark:shadow-none hover:-translate-y-0.5 transition-all flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        <span>Masuk</span>
                    </a>
                @endauth
            </div>

            <!-- Hamburger Button for Mobile (< md) -->
            <div class="flex items-center gap-2 md:hidden">
                <!-- Mobile Theme Toggle -->
                <button onclick="toggleGlobalTheme()" type="button" class="p-2 text-slate-500 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-amber-300 rounded-xl transition focus:outline-none">
                    <svg class="w-5 h-5 hidden dark:block text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <svg class="w-5 h-5 block dark:hidden text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                </button>

                <button id="mobileMenuBtn" type="button" class="p-2 text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition focus:outline-none" aria-label="Toggle Menu">
                    <svg id="hamburgerIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg id="closeIcon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </nav>

        <!-- Collapsible Mobile Menu Drawer -->
        <div id="mobileMenuDrawer" class="hidden md:hidden mt-2 glass-nav rounded-2xl p-5 shadow-2xl border border-white/40 dark:border-slate-800 space-y-4 animate-in slide-in-from-top-2 duration-200">
            <nav class="flex flex-col space-y-3 font-bold text-slate-700 dark:text-slate-200 text-sm">
                <a href="/#events" class="px-3 py-2 hover:bg-indigo-50 dark:hover:bg-slate-800 hover:text-indigo-600 rounded-xl transition">Jelajahi Event</a>
                <a href="/#kategori" class="px-3 py-2 hover:bg-indigo-50 dark:hover:bg-slate-800 hover:text-indigo-600 rounded-xl transition">Kategori Acara</a>
                <a href="{{ route('organizer.register') }}" class="px-3 py-2 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-slate-800 rounded-xl transition">Mitra Organizer</a>
                <a href="{{ route('tentang') }}" class="px-3 py-2 hover:bg-indigo-50 dark:hover:bg-slate-800 hover:text-indigo-600 rounded-xl transition {{ Request::is('tentang') ? 'text-indigo-600 bg-indigo-50 dark:bg-slate-800' : '' }}">Tentang Kami</a>
                <a href="{{ route('bantuan') }}" class="px-3 py-2 hover:bg-indigo-50 dark:hover:bg-slate-800 hover:text-indigo-600 rounded-xl transition {{ Request::is('bantuan') ? 'text-indigo-600 bg-indigo-50 dark:bg-slate-800' : '' }}">Bantuan & Cara Pesan</a>
            </nav>

            <div class="pt-4 border-t border-slate-200/80 dark:border-slate-800">
                @auth
                    <div class="space-y-3">
                        <div class="flex items-center gap-3 px-3 py-2 bg-slate-100/80 dark:bg-slate-800 rounded-xl">
                            @if(Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}" alt="Avatar" class="w-8 h-8 rounded-full object-cover">
                            @else
                                <div class="w-8 h-8 bg-indigo-600 text-white font-bold rounded-full flex items-center justify-center text-xs">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                </div>
                            @endif
                            <div>
                                <p class="text-xs font-extrabold text-slate-800 dark:text-slate-100">{{ Auth::user()->name }}</p>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">{{ Auth::user()->email }}</p>
                            </div>
                        </div>

                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="block w-full text-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-xs shadow-md transition">
                                Dashboard Admin
                            </a>
                        @elseif(Auth::user()->isOrganizer())
                            <a href="{{ route('organizer.dashboard') }}" class="block w-full text-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-xs shadow-md transition">
                                Tenant Hub
                            </a>
                        @endif

                        <form action="{{ route('user.logout') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin keluar dari akun?');">
                            @csrf
                            <button type="submit" class="w-full text-center px-4 py-2 bg-rose-50 dark:bg-rose-950/50 text-rose-600 dark:text-rose-400 hover:bg-rose-100 dark:hover:bg-rose-900/40 rounded-xl font-bold text-xs transition">
                                Keluar dari Akun
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="block w-full text-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-xs shadow-lg shadow-indigo-200 dark:shadow-none transition">
                        Masuk / Daftar Akun
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer Redesign (Clean, Premium, Consistent) -->
    <footer class="bg-slate-950 text-slate-400 pt-16 pb-12 px-4 sm:px-6 mt-20 border-t border-slate-800/80">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-12 gap-8 sm:gap-12 pb-12 border-b border-slate-800/60">
            <!-- Col 1: Brand Info (5 cols) -->
            <div class="md:col-span-5 space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-black text-xl shadow-md shadow-indigo-500/20">
                        AH
                    </div>
                    <span class="text-xl font-black text-white tracking-tight">AmikomEventHub</span>
                </div>
                <p class="text-slate-400 text-xs sm:text-sm leading-relaxed max-w-md font-normal">
                    Platform reservasi tiket event online terpadu Universitas AMIKOM Yogyakarta untuk mahasiswa, HIMA/UKM, dan penyelenggara event.
                </p>
                <div class="flex items-center gap-3 pt-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-900 border border-slate-800 rounded-full text-[11px] font-bold text-slate-300">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>System Operational</span>
                    </span>
                </div>
            </div>

            <!-- Col 2: Navigation (3 cols) -->
            <div class="md:col-span-3 space-y-3">
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-200">Navigasi Utama</h4>
                <ul class="space-y-2.5 text-xs sm:text-sm font-medium">
                    <li><a href="{{ route('home') }}" class="hover:text-indigo-400 transition-colors">Halaman Utama</a></li>
                    <li><a href="/#events" class="hover:text-indigo-400 transition-colors">Jelajahi Event</a></li>
                    <li><a href="/#kategori" class="hover:text-indigo-400 transition-colors">Kategori Acara</a></li>
                    <li><a href="{{ route('tentang') }}" class="hover:text-indigo-400 transition-colors">Tentang Kami</a></li>
                </ul>
            </div>

            <!-- Col 3: Penyelenggara / Organizer (2 cols) -->
            <div class="md:col-span-2 space-y-3">
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-200">Organisasi</h4>
                <ul class="space-y-2.5 text-xs sm:text-sm font-medium">
                    <li><a href="{{ route('organizer.register') }}" class="hover:text-indigo-400 transition-colors">Daftar Organizer</a></li>
                    <li><a href="{{ route('organizer.login') }}" class="hover:text-indigo-400 transition-colors">Portal Organizer</a></li>
                    <li><a href="{{ route('bantuan') }}" class="hover:text-indigo-400 transition-colors">Panduan Panitia</a></li>
                </ul>
            </div>

            <!-- Col 4: Bantuan & Support (2 cols) -->
            <div class="md:col-span-2 space-y-3">
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-200">Bantuan</h4>
                <ul class="space-y-2.5 text-xs sm:text-sm font-medium">
                    <li><a href="{{ route('bantuan') }}" class="hover:text-indigo-400 transition-colors">Cara Pesan Tiket</a></li>
                    <li><a href="mailto:support@amikom.ac.id" class="hover:text-indigo-400 transition-colors">Kontak Support</a></li>
                    <li class="text-slate-500 text-xs">Gedung Unit IV AMIKOM</li>
                </ul>
            </div>
        </div>

        <!-- Bottom Copyright -->
        <div class="max-w-7xl mx-auto pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500 font-medium">
            <p>&copy; 2026 Universitas AMIKOM Yogyakarta. All rights reserved.</p>
            <p class="text-slate-600">Built with Laravel Multi-Tenant Architecture.</p>
        </div>
    </footer>

    <!-- Global Theme Switcher & Mobile Menu JS -->
    <script>
        function toggleGlobalTheme() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('mobileMenuBtn');
            const drawer = document.getElementById('mobileMenuDrawer');
            const burger = document.getElementById('hamburgerIcon');
            const close = document.getElementById('closeIcon');

            if (btn && drawer) {
                btn.addEventListener('click', function () {
                    drawer.classList.toggle('hidden');
                    burger.classList.toggle('hidden');
                    close.classList.toggle('hidden');
                });
            }
        });
    </script>
</body>
</html>