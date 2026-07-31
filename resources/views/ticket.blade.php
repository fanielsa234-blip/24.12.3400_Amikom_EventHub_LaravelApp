@extends('layouts.app')
@section('title', 'Cara Pesan & Bantuan - AmikomEventHub')

@section('content')
<main class="max-w-4xl mx-auto px-6 py-12 sm:py-20 animate-fade-in">
    <!-- Header -->
    <div class="text-center mb-12 sm:mb-16">
        <span class="inline-block px-4 py-1.5 bg-indigo-100 dark:bg-indigo-950/80 text-indigo-700 dark:text-indigo-300 rounded-full text-xs sm:text-sm font-bold uppercase tracking-wider mb-4 border border-indigo-200 dark:border-indigo-800/60">Pusat Bantuan</span>
        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight">Cara Pesan & FAQ</h1>
        <p class="text-base sm:text-lg text-slate-500 dark:text-slate-400 mt-4 font-medium">Temukan jawaban untuk pertanyaan yang sering diajukan di sini.</p>
    </div>

    <!-- Kotak FAQ -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-10 shadow-sm border border-slate-200/80 dark:border-slate-800 space-y-6 transition-colors">
        
        <!-- Pertanyaan 1 -->
        <details class="group border-b border-slate-100 dark:border-slate-800 pb-6" open>
            <summary class="flex justify-between items-center font-extrabold cursor-pointer list-none text-lg sm:text-xl text-slate-900 dark:text-white">
                Bagaimana cara memesan tiket event?
                <span class="transition group-open:rotate-180 text-indigo-600 dark:text-indigo-400 text-2xl">▾</span>
            </summary>
            <div class="text-slate-600 dark:text-slate-300 mt-4 leading-relaxed font-medium space-y-2 text-xs sm:text-sm">
                <p>Proses pemesanan tiket sangat mudah:</p>
                <ol class="list-decimal list-inside ml-2 space-y-1">
                    <li>Pilih event yang Anda inginkan di halaman utama (Katalog).</li>
                    <li>Klik tombol <strong>"Lihat Detail"</strong> untuk membaca informasi acara.</li>
                    <li>Klik tombol <strong>"Pesan Sekarang"</strong> dan isi data diri Anda.</li>
                    <li>Lakukan pembayaran melalui simulasi sistem (GoPay / QRIS).</li>
                    <li>E-Ticket akan langsung terbit dan siap digunakan!</li>
                </ol>
            </div>
        </details>
        
        <!-- Pertanyaan 2 -->
        <details class="group border-b border-slate-100 dark:border-slate-800 pb-6">
            <summary class="flex justify-between items-center font-extrabold cursor-pointer list-none text-lg sm:text-xl text-slate-900 dark:text-white">
                Apakah tiket yang sudah dibeli bisa dibatalkan (Refund)?
                <span class="transition group-open:rotate-180 text-indigo-600 dark:text-indigo-400 text-2xl">▾</span>
            </summary>
            <p class="text-slate-600 dark:text-slate-300 mt-4 leading-relaxed font-medium text-xs sm:text-sm">
                Sesuai dengan kebijakan AmikomEventHub, tiket yang sudah dibeli dan terverifikasi pembayarannya <strong>tidak dapat dibatalkan atau diuangkan kembali (non-refundable)</strong>, kecuali acara dibatalkan oleh pihak penyelenggara secara sepihak.
            </p>
        </details>

        <!-- Pertanyaan 3 -->
        <details class="group border-b border-slate-100 dark:border-slate-800 pb-6">
            <summary class="flex justify-between items-center font-extrabold cursor-pointer list-none text-lg sm:text-xl text-slate-900 dark:text-white">
                Bagaimana cara menggunakan E-Ticket saat acara?
                <span class="transition group-open:rotate-180 text-indigo-600 dark:text-indigo-400 text-2xl">▾</span>
            </summary>
            <p class="text-slate-600 dark:text-slate-300 mt-4 leading-relaxed font-medium text-xs sm:text-sm">
                E-Ticket yang Anda dapatkan setelah pembayaran akan memuat <strong>QR Code</strong> unik. Cukup tunjukkan E-Ticket tersebut (bisa dari layar HP atau dicetak) kepada panitia di pintu masuk (Check-in) pada hari H acara.
            </p>
        </details>

    </div>

    <!-- Kotak Hubungi Kami Bawah -->
    <div class="mt-12 text-center">
        <p class="text-slate-500 dark:text-slate-400 font-medium mb-4 text-xs sm:text-sm">Masih punya pertanyaan lain?</p>
        <a href="mailto:support@amikom.ac.id" class="inline-flex items-center gap-2 px-8 py-4 bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-800 rounded-2xl font-extrabold hover:bg-indigo-600 dark:hover:bg-indigo-600 hover:text-white dark:hover:text-white transition-all text-xs sm:text-sm">
            ✉️ Hubungi CS Kami
        </a>
    </div>
</main>
@endsection
