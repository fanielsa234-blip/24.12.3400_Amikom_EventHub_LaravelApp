<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AmikomEventHub')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">

    <!-- Navigation yang Diperbarui -->
    <nav class="glass sticky top-8 z-40 mx-4 mt-4 px-6 py-4 rounded-2xl border border-white/20 shadow-lg flex justify-between items-center transition-all">
        <!-- Logo -->
        <a href="/" class="flex items-center gap-3 hover:opacity-80 transition">
            <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-md">AH</div>
            <span class="text-xl font-bold tracking-tight hidden sm:block text-slate-800">AmikomEventHub</span>
        </a>
        
        <!-- Menu Tengah -->
        <div class="hidden md:flex gap-8 font-bold text-sm tracking-wide items-center ml-auto mr-8">
            <a href="/#events" class="text-slate-600 hover:text-indigo-600 transition">Jelajahi</a>
            <a href="/#events" class="text-slate-600 hover:text-indigo-600 transition">Kategori</a>
            <a href="{{ route('tentang') }}" class="text-slate-600 hover:text-indigo-600 transition {{ Request::is('tentang') ? 'text-indigo-600 border-b-2 border-indigo-600' : '' }}">Tentang Kami</a>
        </div>
        
        <!-- Tombol Login (Dulu Error, Sekarang Fix!) -->
        <div class="flex items-center">
            <a href="/admin" class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl font-bold text-sm shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:-translate-y-0.5 transition-all">
                Login Admin
            </a>
        </div>
    </nav>

    <!-- Tempat Konten Dinamis -->
    <div class="min-h-screen">
        @yield('content')
    </div>

    <!-- Footer Template Asli -->
    <footer class="bg-indigo-900 text-indigo-100 py-20 px-6 mt-20">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12">
            <div class="space-y-4 col-span-2">
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-indigo-900 font-bold text-xl">AH</div>
                    <span class="text-2xl font-bold text-white">AmikomEventHub</span>
                </div>
                <p class="max-w-xs text-indigo-300 leading-relaxed">Platform reservasi tiket event online terbaik untuk mahasiswa dan penyelenggara profesional di lingkungan kampus.</p>
            </div>
            <div>
                <h4 class="text-white font-bold mb-6 tracking-wide">Navigasi</h4>
                <ul class="space-y-4 font-medium">
                    <li><a href="/" class="hover:text-white transition">Home</a></li>
                    <li><a href="/#events" class="hover:text-white transition">Semua Event</a></li>
                    <li><a href="{{ route('tentang') }}" class="hover:text-white transition">Tentang Kami</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold mb-6 tracking-wide">Hubungi Kami</h4>
                <ul class="space-y-4 font-medium">
                    <li>support@amikom.ac.id</li>
                    <li>+62 812 3456 7890</li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto pt-12 mt-12 border-t border-indigo-800 text-center text-indigo-400 text-sm font-medium">
            &copy; 2026 AmikomEventHub. Resmi dikelola oleh Admin Universitas AMIKOM Yogyakarta.
        </div>
    </footer>
</body>
</html>