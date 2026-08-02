@extends('layouts.app')
@section('title', 'Profil Pengguna - AmikomEventHub')

@section('content')
<main class="max-w-4xl mx-auto px-4 sm:px-6 py-12 sm:py-16 space-y-8">
    
    <!-- User Profile Header Card -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 p-6 sm:p-10 shadow-sm transition-colors">
        <div class="flex flex-col md:flex-row gap-8 items-center md:items-start text-center md:text-left">
            <div class="shrink-0 relative">
                @auth
                    @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="w-32 h-32 rounded-full object-cover border-4 border-indigo-100 dark:border-indigo-950 shadow-lg">
                    @else
                        <div class="w-32 h-32 rounded-full bg-indigo-600 text-white font-black flex items-center justify-center text-4xl shadow-lg shadow-indigo-200 dark:shadow-none">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                    @endif
                @else
                    <div class="w-32 h-32 rounded-full bg-linear-to-br from-indigo-500 to-purple-600 text-white font-black flex items-center justify-center text-5xl shadow-lg">
                        👩‍💻
                    </div>
                @endauth
            </div>

            <div class="flex-1 space-y-4">
                <div>
                    <div class="flex items-center justify-center md:justify-start gap-2">
                        <h1 class="text-2xl sm:text-4xl font-black text-slate-900 dark:text-white tracking-tight">
                            {{ auth()->user()->name ?? 'Alfiya Trisna Elsutani' }}
                        </h1>
                        <span class="px-3 py-1 bg-indigo-100 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300 rounded-full text-xs font-black uppercase">
                            {{ auth()->check() ? ucfirst(auth()->user()->role) : 'Mahasiswa' }}
                        </span>
                    </div>
                    <p class="text-indigo-600 dark:text-indigo-400 font-extrabold text-sm sm:text-base mt-1">
                        {{ auth()->user()->email ?? 'elsafani@students.amikom.ac.id' }} &bull; NIM: 24.12.3400
                    </p>
                    <p class="text-slate-400 font-mono text-xs uppercase mt-0.5">S1 Sistem Informasi &bull; Universitas AMIKOM Yogyakarta</p>
                </div>

                <div class="pt-2 border-t border-slate-100 dark:border-slate-800">
                    <h2 class="text-[11px] font-extrabold uppercase tracking-widest text-slate-400 mb-1">Bio & Motto</h2>
                    <p class="text-sm sm:text-base leading-relaxed text-slate-600 dark:text-slate-300 font-medium italic">
                        "Berdedikasi untuk membangun solusi digital yang bermakna melalui kode yang bersih dan desain yang intuitif."
                    </p>
                </div>

                @auth
                    <div class="pt-4 flex flex-wrap justify-center md:justify-start gap-3">
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-extrabold text-xs shadow-md transition">
                                Dashboard Admin &rarr;
                            </a>
                        @elseif(auth()->user()->isOrganizer())
                            <a href="{{ route('organizer.dashboard') }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-extrabold text-xs shadow-md transition">
                                Dashboard Tenant &rarr;
                            </a>
                        @endif

                        <form action="{{ route('user.logout') }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin keluar?');">
                            @csrf
                            <button type="submit" class="px-5 py-2.5 bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 hover:bg-rose-100 rounded-xl font-extrabold text-xs transition">
                                Keluar dari Akun
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </div>

</main>
@endsection