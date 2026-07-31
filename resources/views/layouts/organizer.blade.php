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
<body class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 min-h-full flex flex-col transition-colors">
    <nav class="bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-6">
                <a href="{{ route('organizer.dashboard') }}" class="flex items-center gap-2.5">
                    <div class="w-9 h-9 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-black text-sm shadow-md">
                        OH
                    </div>
                    <span class="font-extrabold text-base tracking-tight text-slate-900 dark:text-white">Portal Organizer</span>
                </a>
                <div class="hidden md:flex items-center gap-1 font-semibold text-xs text-slate-600 dark:text-slate-300">
                    <a href="{{ route('organizer.dashboard') }}" class="px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition">Dashboard</a>
                    <a href="{{ route('organizer.events.index') }}" class="px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition">Event Saya</a>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="text-xs font-bold text-slate-500 hover:text-indigo-600 transition">Ke Portal Publik &rarr;</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-3 py-1.5 bg-rose-50 dark:bg-rose-950/60 text-rose-700 dark:text-rose-300 rounded-xl font-bold text-xs hover:bg-rose-100 transition">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>
</body>
</html>
