@extends('layouts.app')
@section('title', $event->title . ' - Detail Event')
@section('content')
    <main class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Poster Kiri -->
        <div class="lg:col-span-1">
            <div class="sticky top-24">
                <img src="{{ $event->poster_path ? asset($event->poster_path) : asset('assets/concert.png') }}" class="w-full rounded-[2.5rem] shadow-2xl border-8 border-white dark:border-slate-800 object-cover aspect-3/4" onerror="this.src='{{ asset('assets/concert.png') }}'">
                <div class="mt-8 p-6 bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm">
                    <h4 class="font-bold mb-4 text-slate-900 dark:text-white">Penyelenggara</h4>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-950 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center font-extrabold">
                            {{ strtoupper(substr($event->organizer->name ?? ($event->user->name ?? 'Admin Amikom'), 0, 2)) }}
                        </div>
                        <div>
                            <p class="font-bold text-slate-800 dark:text-slate-200 text-sm">{{ $event->organizer->name ?? ($event->user->name ?? 'Admin Amikom') }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Verified Organizer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Kanan -->
        <div class="lg:col-span-2 space-y-12">
            <!-- Flash Notification -->
            @if(session('success'))
                <div class="p-4 bg-emerald-50 dark:bg-emerald-950/80 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 rounded-2xl text-xs sm:text-sm font-extrabold flex items-center gap-3">
                    <span>✅</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="p-4 bg-rose-50 dark:bg-rose-950/80 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 rounded-2xl text-xs sm:text-sm font-extrabold flex items-center gap-3">
                    <span>⚠️</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <div class="space-y-4">
                <span class="px-4 py-1.5 bg-indigo-100 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300 rounded-full text-xs font-extrabold uppercase tracking-wider">{{ $event->category->name ?? 'Umum' }}</span>
                <h1 class="text-3xl md:text-5xl font-black text-slate-900 dark:text-white leading-tight tracking-tight">{{ $event->title }}</h1>
                <div class="flex flex-wrap gap-6 text-slate-500 dark:text-slate-400 text-sm font-medium">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>{{ \Carbon\Carbon::parse($event->date)->format('l, d M Y - H:i') }} WIB</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span>{{ $event->location }}</span>
                    </div>
                </div>
            </div>

            <div class="prose prose-slate dark:prose-invert max-w-none">
                <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-4">Deskripsi Event</h3>
                <p class="text-base sm:text-lg text-slate-600 dark:text-slate-300 leading-relaxed">{{ $event->description }}</p>
            </div>

            <!-- Box Beli Tiket / Checkout -->
            <div class="bg-indigo-600 rounded-[2.5rem] p-8 md:p-12 text-white shadow-2xl shadow-indigo-200 dark:shadow-none relative overflow-hidden">
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
                    <div>
                        <p class="text-indigo-200 font-extrabold uppercase tracking-widest text-xs mb-2">Harga Tiket</p>
                        <h2 class="text-4xl md:text-5xl font-black">{{ $event->price == 0 ? 'Gratis' : 'Rp ' . number_format($event->price, 0, ',', '.') }}</h2>
                        <p class="mt-4 text-indigo-100 flex items-center gap-2 text-sm font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Sisa stok: <span class="font-bold underline">{{ $event->stock }} Tiket lagi!</span>
                        </p>
                    </div>
                    <div>
                        @if($event->stock > 0)
                            <a href="{{ route('checkout.create', $event->id) }}" class="inline-block px-10 py-4 sm:py-5 bg-white text-indigo-600 hover:bg-slate-50 rounded-2xl font-black text-lg sm:text-xl hover:scale-105 active:scale-95 transition-transform shadow-xl">
                                Pesan Sekarang &rarr;
                            </a>
                        @else
                            <button disabled class="inline-block px-10 py-4 sm:py-5 bg-slate-300 text-slate-500 rounded-2xl font-black text-lg sm:text-xl cursor-not-allowed">
                                Stok Habis
                            </button>
                        @endif
                    </div>
                </div>
                <!-- Decoration -->
                <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-white opacity-10 rounded-full"></div>
                <div class="absolute -left-10 -top-10 w-32 h-32 bg-indigo-400 opacity-20 rounded-full"></div>
            </div>

            <!-- SECTION RATING & ULASAN PENGUNJUNG (BAGIAN 1) -->
            <div id="reviews-section" class="pt-8 border-t border-slate-200 dark:border-slate-800 space-y-8">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">Ulasan & Rating Pengunjung</h3>
                        <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">Pendapat dan pengalaman nyata dari peserta yang menghadiri event ini.</p>
                    </div>

                    <!-- Summary Badge -->
                    @php
                        $avgRating = $event->reviews->avg('rating') ? number_format($event->reviews->avg('rating'), 1) : null;
                        $totalReviews = $event->reviews->count();
                    @endphp
                    @if($avgRating)
                        <div class="flex items-center gap-3 px-5 py-3 bg-amber-50 dark:bg-amber-950/60 border border-amber-200 dark:border-amber-800/60 rounded-2xl shrink-0">
                            <span class="text-3xl">⭐</span>
                            <div>
                                <div class="text-xl font-black text-amber-900 dark:text-amber-200 leading-none">{{ $avgRating }} <span class="text-xs font-bold text-amber-700 dark:text-amber-400">/ 5.0</span></div>
                                <div class="text-[11px] font-bold text-amber-700 dark:text-amber-400 mt-0.5">{{ $totalReviews }} Ulasan Ditulis</div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Form Berikan Ulasan -->
                @auth
                    @if(isset($userReview) && $userReview)
                        <!-- Card Ulasan Pengguna yang Sudah Ada -->
                        <div class="p-6 bg-slate-50 dark:bg-slate-900 rounded-3xl border border-indigo-200 dark:border-indigo-800/60 space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="px-3 py-1 bg-indigo-100 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300 rounded-full text-xs font-extrabold uppercase">Ulasan Anda</span>
                                <span class="text-xs text-slate-400 font-medium">{{ $userReview->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            <div class="flex items-center gap-1 text-amber-400 text-lg">
                                @for($i = 1; $i <= 5; $i++)
                                    <span>{{ $i <= $userReview->rating ? '★' : '☆' }}</span>
                                @endfor
                                <span class="text-xs font-bold text-slate-600 dark:text-slate-300 ml-2">({{ $userReview->rating }}/5)</span>
                            </div>
                            <p class="text-slate-700 dark:text-slate-200 text-sm italic font-medium">"{{ $userReview->comment }}"</p>
                        </div>
                    @else
                        <!-- Form Input Ulasan Baru -->
                        <div class="p-6 sm:p-8 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-6">
                            <h4 class="text-lg font-bold text-slate-900 dark:text-white">Tulis Ulasan Anda</h4>
                            <form action="{{ route('events.reviews.store', $event->id) }}" method="POST" class="space-y-5" onsubmit="this.querySelector('button[type=submit]').disabled=true; this.querySelector('button[type=submit]').innerText='Mengirim...';">
                                @csrf
                                <div>
                                    <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-2">Beri Rating (1 - 5 Bintang)</label>
                                    <div class="flex items-center gap-3">
                                        <select name="rating" required class="px-4 py-3 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-sm font-bold text-slate-800 dark:text-white focus:ring-2 focus:ring-indigo-600 focus:outline-none">
                                            <option value="5">⭐⭐⭐⭐⭐ (5 - Sangat Bagus)</option>
                                            <option value="4">⭐⭐⭐⭐ (4 - Bagus)</option>
                                            <option value="3">⭐⭐⭐ (3 - Cukup)</option>
                                            <option value="2">⭐⭐ (2 - Kurang)</option>
                                            <option value="1">⭐ (1 - Buruk)</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-2">Komentar / Pengalaman Anda</label>
                                    <textarea name="comment" rows="3" required placeholder="Bagaimana kesan dan pesan Anda mengikuti event ini?" class="w-full p-4 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-indigo-600 focus:outline-none transition"></textarea>
                                </div>

                                <button type="submit" class="px-8 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-extrabold text-xs sm:text-sm shadow-md shadow-indigo-200 dark:shadow-none transition-all">
                                    Kirim Ulasan Resmi &rarr;
                                </button>
                            </form>
                        </div>
                    @endif
                @else
                    <div class="p-6 bg-slate-50 dark:bg-slate-900 rounded-3xl border border-dashed border-slate-200 dark:border-slate-800 text-center space-y-3">
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 font-medium">Ingin memberikan ulasan dan rating untuk event ini?</p>
                        <a href="{{ route('login') }}" class="inline-block px-6 py-2.5 bg-indigo-600 text-white rounded-xl text-xs font-extrabold shadow-sm hover:bg-indigo-700 transition">
                            Masuk ke Akun Anda &rarr;
                        </a>
                    </div>
                @endauth

                <!-- Daftar Ulasan yang Sudah Diberikan -->
                <div class="space-y-4">
                    <h4 class="text-sm font-extrabold uppercase tracking-wider text-slate-400">Daftar Ulasan ({{ $event->reviews->count() }})</h4>
                    <div class="space-y-4">
                        @forelse($event->reviews as $review)
                            <div class="p-5 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 bg-indigo-100 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300 font-black rounded-full flex items-center justify-center text-xs">
                                            {{ strtoupper(substr($review->user->name ?? 'U', 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-xs sm:text-sm text-slate-900 dark:text-white">{{ $review->user->name ?? 'Pengunjung' }}</p>
                                            <p class="text-[11px] text-slate-400">{{ $review->created_at->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center text-amber-400 text-sm">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span>{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                        @endfor
                                    </div>
                                </div>
                                @if($review->comment)
                                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 font-medium leading-relaxed">
                                        "{{ $review->comment }}"
                                    </p>
                                @endif
                            </div>
                        @empty
                            <div class="p-8 text-center bg-slate-50/60 dark:bg-slate-900/50 rounded-2xl border border-slate-100 dark:border-slate-800">
                                <p class="text-xs sm:text-sm text-slate-400 font-medium">Belum ada ulasan untuk event ini. Jadilah yang pertama memberikan ulasan!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection
