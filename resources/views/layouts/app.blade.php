<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - EventHub.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-[#FBFBFD] text-[#1D1D1F] antialiased flex flex-col min-h-screen">
    <!-- Navigasi Seragam -->
    <nav class="sticky top-0 z-50 bg-[#FBFBFD]/80 backdrop-blur-xl border-b border-slate-200">
        <div class="max-w-5xl mx-auto px-6 h-14 flex items-center justify-between">
            <a href="/" class="font-semibold text-lg tracking-tight">Event<span class="text-indigo-600">Hub.</span></a>
            <div class="flex gap-8 text-[12px] font-medium tracking-wide">
                <a href="/" class="text-slate-500 hover:text-black transition-colors">HOME</a>
                <a href="/profil" class="text-slate-500 hover:text-black transition-colors">PROFIL</a>
                <a href="/katalog" class="text-slate-500 hover:text-black transition-colors">KATALOG</a>
                <a href="/bantuan" class="text-slate-500 hover:text-black transition-colors">BANTUAN</a>
                <a href="/kontak" class="text-slate-500 hover:text-black transition-colors">KONTAK</a>
            </div>
        </div>
    </nav>

    <!-- Konten Dinamis -->
    <main class="grow">
        @yield('content')
    </main>

    <!-- Footer Seragam -->
    <footer class="py-10 border-t border-slate-100 bg-white">
        <p class="text-center text-[10px] text-slate-400 tracking-[0.3em] uppercase">
            &copy; 2026 Crafted with Love by Eca &bull; Amikom Yogyakarta
        </p>
    </footer>
</body>
</html>
