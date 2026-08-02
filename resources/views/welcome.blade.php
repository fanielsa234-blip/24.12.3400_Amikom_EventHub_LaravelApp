@extends('layouts.app')
@section('title', 'AmikomEventHub - Temukan Event Seru!')

@section('content')
    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-6 py-16 md:py-24 flex flex-col md:flex-row items-center gap-12 animate-fade-in">
        <div class="flex-1 space-y-8">
            <span class="inline-block px-4 py-1.5 bg-indigo-100 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800 rounded-full text-xs font-extrabold uppercase tracking-wider">#1 Event Platform</span>
            <h1 class="text-4xl sm:text-6xl md:text-7xl font-black tracking-tight text-slate-900 dark:text-white leading-tight">
                Temukan & Pesan <span class="text-indigo-600 dark:text-indigo-400">Tiket Event</span> Impianmu.
            </h1>
            <p class="text-base sm:text-lg text-slate-600 dark:text-slate-300 max-w-lg leading-relaxed font-medium">
                Dari konser musik hingga workshop teknologi, semua ada di genggamanmu. Pesan aman & cepat dengan Midtrans.
            </p>
            <div class="flex flex-wrap gap-4 pt-2">
                <a href="#events" class="px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-base shadow-xl shadow-indigo-200 dark:shadow-none hover:scale-105 active:scale-95 transition-all">
                    Mulai Jelajah &rarr;
                </a>
                <a href="{{ route('bantuan') }}" class="px-8 py-4 border-2 border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 rounded-2xl font-bold text-base hover:border-indigo-600 dark:hover:border-indigo-500 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all">
                    Cara Pesan
                </a>
            </div>
        </div>

        <div class="flex-1 relative">
            <div class="absolute -top-10 -left-10 w-64 h-64 bg-indigo-400 dark:bg-indigo-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
            <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-purple-400 dark:bg-purple-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
            
            <img src="{{ asset('assets/concert.png') }}" class="rounded-[2.5rem] shadow-2xl relative z-10 w-full object-cover aspect-4/5 object-center border-4 border-white dark:border-slate-800">
            
            <div class="absolute -bottom-6 -left-6 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md p-6 rounded-2xl shadow-xl z-20 border border-white/60 dark:border-slate-800">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400 rounded-full flex items-center justify-center font-black">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 font-extrabold uppercase tracking-wider">Terverifikasi</p>
                        <p class="font-extrabold text-sm text-slate-900 dark:text-white">Pembayaran Aman via Midtrans</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Events Grid & Filter -->
    <section id="events" class="max-w-7xl mx-auto px-6 py-16">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6 border-b border-slate-200/80 dark:border-slate-800 pb-6">
            <div>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white tracking-tight mb-2">Event Terdekat</h2>
                <p class="text-slate-500 dark:text-slate-400 font-medium text-sm sm:text-base">Jangan sampai ketinggalan acara seru minggu ini!</p>
            </div>
            
            <!-- Filter Kategori Dinamis -->
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('home') }}#events" 
                   class="px-5 py-2.5 rounded-xl font-extrabold text-xs sm:text-sm transition-all shadow-sm {{ request('category') == '' ? 'bg-indigo-600 text-white' : 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                   Semua Kategori
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('home', ['category' => $cat->slug]) }}#events" 
                       class="px-5 py-2.5 rounded-xl font-extrabold text-xs sm:text-sm transition-all shadow-sm {{ request('category') == $cat->slug ? 'bg-indigo-600 text-white' : 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                       {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($events as $event)
                @php
                    $catName = strtolower($event->category->name ?? '');
                    if (str_contains($catName, 'teknologi') || str_contains($catName, 'coding')) {
                        $defaultImg = asset('assets/hackathon.png'); 
                    } elseif (str_contains($catName, 'workshop') || str_contains($catName, 'seminar')) {
                        $defaultImg = asset('assets/workshop.png'); 
                    } else {
                        $defaultImg = asset('assets/concert.png'); 
                    }
                    $imgSrc = $event->poster_path ? asset($event->poster_path) : $defaultImg;
                @endphp
                
                <div class="group bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden flex flex-col h-full">
                    <div class="relative overflow-hidden aspect-3/4 bg-slate-100 dark:bg-slate-800">
                        <img src="{{ $imgSrc }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute top-4 left-4 px-3 py-1 bg-white/90 dark:bg-slate-900/90 backdrop-blur rounded-xl text-[10px] font-black uppercase text-indigo-600 dark:text-indigo-400 shadow-sm border border-white/40 dark:border-slate-800">
                            {{ $event->category->name ?? 'Event' }}
                        </div>
                    </div>

                    <div class="p-6 flex flex-col grow justify-between space-y-4">
                        <div>
                            <h3 class="text-xl font-black text-slate-900 dark:text-white mb-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition leading-snug line-clamp-2">
                                {{ $event->title }}
                            </h3>
                            <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400 text-xs font-semibold">
                                <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>{{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }} WIB</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center pt-4 border-t border-slate-100 dark:border-slate-800">
                            <div>
                                <span class="text-[10px] uppercase font-bold text-slate-400 block">Harga</span>
                                <span class="text-2xl font-black text-indigo-600 dark:text-indigo-400">
                                    {{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                                </span>
                            </div>

                            <a href="{{ route('events.show', $event->id) }}" 
                               class="px-5 py-2.5 bg-indigo-50 dark:bg-indigo-950/80 text-indigo-600 dark:text-indigo-400 rounded-xl font-extrabold text-xs hover:bg-indigo-600 dark:hover:bg-indigo-600 hover:text-white dark:hover:text-white border border-indigo-100 dark:border-indigo-900 transition">
                                Detail Event &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800">
                    <h3 class="text-lg font-black text-slate-800 dark:text-slate-200">Oops, event di kategori ini belum tersedia.</h3>
                    <a href="{{ route('home') }}" class="inline-block mt-3 text-xs font-extrabold text-indigo-600 dark:text-indigo-400 hover:underline">Tampilkan Semua Event</a>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Partner Section -->
    <section class="max-w-7xl mx-auto px-6 py-16 mb-20 border-t border-slate-200/80 dark:border-slate-800">
        <div class="text-center mb-10">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">Didukung Oleh Partner Resmi</h2>
            <p class="text-slate-500 dark:text-slate-400 font-medium text-xs sm:text-sm mt-2">Berkolaborasi dengan instansi dan perusahaan terkemuka.</p>
        </div>
        
        <div class="flex flex-wrap justify-center items-center gap-8 md:gap-16">
            @forelse($partners as $partner)
                <div class="flex flex-col items-center gap-3 group">
                    <div class="w-24 h-24 md:w-32 md:h-32 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-sm flex items-center justify-center p-4 group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300">
                        <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}" class="max-w-full max-h-full object-contain filter grayscale group-hover:grayscale-0 transition-all duration-300">
                    </div>
                    <span class="text-xs font-extrabold text-slate-600 dark:text-slate-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ $partner->name }}</span>
                </div>
            @empty
                <p class="text-slate-400 dark:text-slate-500 font-medium italic text-xs">Belum ada partner yang ditambahkan.</p>
            @endforelse
        </div>
    </section>
@endsection