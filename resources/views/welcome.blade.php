@extends('layouts.app')
@section('title', 'AmikomEventHub - Temukan Event Seru!')

@section('content')
    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-6 py-20 flex flex-col md:flex-row items-center gap-12 animate-fade-in">
        <div class="flex-1 space-y-8">
            <span class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">#1 Event Platform</span>
            <h1 class="text-5xl md:text-7xl font-extrabold leading-tight">
                Temukan & Pesan <span class="text-indigo-600">Tiket Event</span> Impianmu.
            </h1>
            <p class="text-lg text-slate-500 max-w-lg leading-relaxed font-medium">
                Dari konser musik hingga workshop teknologi, semua ada di genggamanmu. Pesan aman & cepat dengan Midtrans.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="#events" class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold text-lg shadow-xl shadow-indigo-200 hover:scale-105 transition-transform">
                    Mulai Jelajah
                </a>
                <a href="{{ route('bantuan') }}" class="px-8 py-4 border-2 border-slate-200 bg-white text-slate-700 rounded-2xl font-bold text-lg hover:border-indigo-600 hover:text-indigo-600 transition-all">
                    Cara Pesan
                </a>
            </div>
        </div>
        <div class="flex-1 relative">
            <div class="absolute -top-10 -left-10 w-64 h-64 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
            <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
            
            <img src="{{ asset('assets/concert.png') }}" class="rounded-[2.5rem] shadow-2xl relative z-10 w-full object-cover aspect-4/5 object-center border-4 border-white">
            
            <div class="absolute -bottom-6 -left-6 glass p-6 rounded-2xl shadow-xl z-20 border border-white">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 font-bold uppercase">Terverifikasi</p>
                        <p class="font-bold">Pembayaran Aman via Midtrans</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Events Grid & Filter -->
    <section id="events" class="max-w-7xl mx-auto px-6 py-20">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
            <div>
                <h2 class="text-3xl font-extrabold mb-2">Event Terdekat</h2>
                <p class="text-slate-500 font-medium">Jangan sampai ketinggalan acara seru minggu ini!</p>
            </div>
            
            <!-- Filter Kategori Dinamis -->
            <div class="flex flex-wrap gap-2">
                <a href="/" class="px-5 py-2.5 rounded-xl font-bold transition-all shadow-sm {{ request('category') == '' ? 'bg-indigo-600 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">Semua Kategori</a>
                @foreach($categories as $cat)
                    <a href="/?category={{ $cat->slug }}#events" class="px-5 py-2.5 rounded-xl font-bold transition-all shadow-sm {{ request('category') == $cat->slug ? 'bg-indigo-600 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">{{ $cat->name }}</a>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($events as $event)
                @php
                    // Logika Pintar: Memilih gambar otomatis berdasarkan kategori
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
                
                <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden flex flex-col h-full">
                    <div class="relative overflow-hidden aspect-3/4">
                        <!-- Menampilkan Gambar Hasil Logika Pintar -->
                        <img src="{{ $imgSrc }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-bold uppercase text-indigo-600">{{ $event->category->name ?? 'Event' }}</div>
                    </div>
                    <div class="p-6 flex flex-col grow">
                        <h3 class="text-xl font-bold mb-2 group-hover:text-indigo-600 transition">{{ $event->title }}</h3>
                        <div class="flex items-center gap-2 text-slate-500 text-sm mb-4">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>{{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-4 border-t mt-auto">
                            <span class="text-2xl font-black text-indigo-600">{{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}</span>
                            <a href="{{ route('events.show', $event->id) }}" class="px-5 py-2 bg-indigo-50 text-indigo-600 rounded-xl font-bold hover:bg-indigo-600 hover:text-white transition">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-10 text-center"><h3 class="text-xl font-bold text-slate-700">Oops, event di kategori ini belum tersedia.</h3></div>
            @endforelse
        </div>
    </section>
    <!-- SOAL 4 UTS: PARTNER SECTION -->
    <section class="max-w-7xl mx-auto px-6 py-12 mb-20 border-t border-slate-200">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-extrabold text-slate-800">Didukung Oleh Partner Resmi</h2>
            <p class="text-slate-500 font-medium mt-2">Berkolaborasi dengan instansi dan perusahaan terkemuka.</p>
        </div>
        
        <div class="flex flex-wrap justify-center items-center gap-8 md:gap-16 opacity-60 hover:opacity-100 transition-opacity duration-300">
            @forelse($partners as $partner)
                <div class="flex flex-col items-center gap-3 group">
                    <div class="w-24 h-24 md:w-32 md:h-32 rounded-3xl bg-white border border-slate-100 shadow-sm flex items-center justify-center p-4 group-hover:-translate-y-2 group-hover:shadow-xl transition-all duration-300">
                        <!-- Memanggil gambar logo dari database -->
                        <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}" class="max-w-full max-h-full object-contain filter grayscale group-hover:grayscale-0 transition-all duration-300">
                    </div>
                    <span class="text-sm font-bold text-slate-500 group-hover:text-indigo-600 transition-colors">{{ $partner->name }}</span>
                </div>
            @empty
                <p class="text-slate-400 font-medium italic">Belum ada partner yang ditambahkan.</p>
            @endforelse
        </div>
    </section>
@endsection