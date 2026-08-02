@extends('layouts.app')
@section('title', 'Katalog Event Kampus - AmikomEventHub')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">
    <!-- Header Page Banner -->
    <div class="text-center space-y-4 max-w-3xl mx-auto">
        <span class="px-4 py-1.5 bg-indigo-50 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300 rounded-full text-xs font-extrabold uppercase tracking-widest border border-indigo-100 dark:border-indigo-800">
            Katalog Acara Terlengkap
        </span>
        <h1 class="text-3xl sm:text-5xl font-black text-slate-900 dark:text-white tracking-tight">
            Jelajahi <span class="text-indigo-600">Event & Workshop</span> Kampus
        </h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm sm:text-base font-medium leading-relaxed">
            Temukan seminar, konser musik, workshop teknologi, dan perlombaan seru yang diselenggarakan oleh HIMA, UKM, dan Organisasi Amikom.
        </p>
    </div>

    <!-- Category Filter Bar -->
    <div class="flex flex-wrap items-center justify-center gap-2">
        <a href="{{ route('katalog') }}" 
           class="px-4 py-2 rounded-xl text-xs sm:text-sm font-extrabold transition {{ !request('category') ? 'bg-indigo-600 text-white shadow-md' : 'bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-800 hover:bg-slate-50' }}">
            🌟 Semua Kategori
        </a>
        @foreach($categories as $category)
            <a href="{{ route('katalog', ['category' => $category->slug]) }}" 
               class="px-4 py-2 rounded-xl text-xs sm:text-sm font-extrabold transition {{ request('category') == $category->slug ? 'bg-indigo-600 text-white shadow-md' : 'bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-800 hover:bg-slate-50' }}">
                {{ $category->name }}
            </a>
        @endforeach
    </div>

    <!-- Event Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @php
            $filteredEvents = request('category')
                ? $events->filter(fn($e) => optional($e->category)->slug === request('category'))
                : $events;
        @endphp

        @forelse($filteredEvents as $event)
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 flex flex-col justify-between">
                <div>
                    <!-- Event Poster Image -->
                    <div class="relative h-52 bg-slate-100 dark:bg-slate-800 overflow-hidden">
                        <img src="{{ $event->poster_path ? asset($event->poster_path) : asset('assets/concert.png') }}" 
                             alt="{{ $event->title }}" 
                             class="w-full h-full object-cover">
                        <div class="absolute top-3 left-3">
                            <span class="px-3 py-1 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md text-indigo-600 dark:text-indigo-400 rounded-full text-[10px] font-black uppercase tracking-wider shadow-sm">
                                {{ $event->category->name ?? 'Umum' }}
                            </span>
                        </div>
                    </div>

                    <!-- Event Details Content -->
                    <div class="p-6 space-y-3">
                        <h3 class="font-extrabold text-lg text-slate-900 dark:text-white leading-snug line-clamp-2">
                            {{ $event->title }}
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed">
                            {{ $event->description }}
                        </p>

                        <div class="pt-2 space-y-2 text-xs font-semibold text-slate-600 dark:text-slate-400">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span>{{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }} WIB</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                <span class="truncate">{{ $event->location }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Card Action -->
                <div class="p-6 pt-0 flex items-center justify-between border-t border-slate-100 dark:border-slate-800/80 mt-4">
                    <div>
                        <span class="text-[10px] uppercase font-bold text-slate-400 block">Harga Tiket</span>
                        <span class="font-black text-lg text-indigo-600 dark:text-indigo-400">
                            {{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}
                        </span>
                    </div>

                    <a href="{{ route('events.show', $event->id) }}" 
                       class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-extrabold text-xs shadow-md shadow-indigo-200 dark:shadow-none transition">
                        Detail Event &rarr;
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800">
                <p class="text-slate-500 font-bold text-base">Belum ada event untuk kategori ini.</p>
                <a href="{{ route('katalog') }}" class="inline-block mt-3 text-xs font-extrabold text-indigo-600 hover:underline">Tampilkan Semua Event</a>
            </div>
        @endforelse
    </div>
</main>
@endsection