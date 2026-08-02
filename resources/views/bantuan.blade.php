@extends('layouts.app')
@section('title', 'Cara Pesan & Bantuan - AmikomEventHub')

@section('content')
<main class="max-w-4xl mx-auto px-6 py-20 animate-fade-in">
    <!-- Header -->
    <div class="text-center mb-16">
        <span class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider mb-4">Pusat Bantuan</span>
        <h1 class="text-4xl md:text-5xl font-extrabold text-slate-800">Cara Pesan & FAQ</h1>
        <p class="text-lg text-slate-500 mt-4 font-medium">Temukan jawaban untuk pertanyaan yang sering diajukan di sini.</p>
    </div>

    <!-- Kotak FAQ -->
    <div class="bg-white rounded-3xl p-8 md:p-10 shadow-sm border border-slate-100 space-y-6">
        
        <!-- Pertanyaan 1 -->
        <details class="group border-b border-slate-100 pb-6" open>
            <summary class="flex justify-between items-center font-bold cursor-pointer list-none text-xl text-slate-800">
                Bagaimana cara memesan tiket event?
                <span class="transition group-open:rotate-180 text-indigo-600 text-2xl">▾</span>
            </summary>
            <div class="text-slate-500 mt-4 leading-relaxed font-medium space-y-2">
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
        <details class="group border-b border-slate-100 pb-6">
            <summary class="flex justify-between items-center font-bold cursor-pointer list-none text-xl text-slate-800">
                Apakah tiket yang sudah dibeli bisa dibatalkan (Refund)?
                <span class="transition group-open:rotate-180 text-indigo-600 text-2xl">▾</span>
            </summary>
            <p class="text-slate-500 mt-4 leading-relaxed font-medium">
                Sesuai dengan kebijakan AmikomEventHub, tiket yang sudah dibeli dan terverifikasi pembayarannya <strong>tidak dapat dibatalkan atau diuangkan kembali (non-refundable)</strong>, kecuali acara dibatalkan oleh pihak penyelenggara secara sepihak.
            </p>
        </details>

        <!-- Pertanyaan 3 -->
        <details class="group border-b border-slate-100 pb-6">
            <summary class="flex justify-between items-center font-bold cursor-pointer list-none text-xl text-slate-800">
                Bagaimana cara menggunakan E-Ticket saat acara?
                <span class="transition group-open:rotate-180 text-indigo-600 text-2xl">▾</span>
            </summary>
            <p class="text-slate-500 mt-4 leading-relaxed font-medium">
                E-Ticket yang Anda dapatkan setelah pembayaran akan memuat <strong>QR Code</strong> unik. Cukup tunjukkan E-Ticket tersebut (bisa dari layar HP atau dicetak) kepada panitia di pintu masuk (Check-in) pada hari H acara.
            </p>
        </details>

    </div>

    <!-- Kotak Hubungi Kami Bawah -->
    <div class="mt-12 text-center">
        <p class="text-slate-500 font-medium mb-4">Masih punya pertanyaan lain?</p>
        <a href="mailto:support@amikom.ac.id" class="inline-flex items-center gap-2 px-8 py-4 bg-indigo-50 text-indigo-600 rounded-2xl font-bold hover:bg-indigo-600 hover:text-white transition-all">
            ✉️ Hubungi CS Kami
        </a>
    </div>
</main>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.8s ease-out forwards;
    }
</style>
@endsection
