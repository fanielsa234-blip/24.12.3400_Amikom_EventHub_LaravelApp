<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket Resmi - {{ $transaction->event->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; }
            .print-card { box-shadow: none !important; border: 1px solid #cbd5e1 !important; margin: 0 auto !important; }
        }
    </style>
</head>
<body class="bg-indigo-600 dark:bg-slate-950 text-slate-900 antialiased min-h-screen flex flex-col justify-between p-4 sm:p-8">

    <!-- Top Action Navigation Bar (No-Print) -->
    <header class="max-w-xl mx-auto w-full flex items-center justify-between gap-4 mb-6 no-print">
        <a href="{{ route('home') }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/10 hover:bg-white/20 text-white font-extrabold rounded-2xl backdrop-blur-md transition border border-white/20 text-xs sm:text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Kembali ke Beranda</span>
        </a>

        <div class="flex items-center gap-2">
            <button onclick="window.print()" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-100 text-indigo-700 font-extrabold rounded-2xl shadow-lg transition text-xs sm:text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span>Cetak / PDF</span>
            </button>
        </div>
    </header>

    <!-- Main Container -->
    <main class="max-w-xl mx-auto w-full my-auto space-y-6">

        <!-- Banner Success (No-Print) -->
        <div class="text-center text-white space-y-2 no-print">
            <div class="w-16 h-16 bg-emerald-500 text-white rounded-full flex items-center justify-center mx-auto shadow-lg shadow-emerald-500/30 text-2xl font-black mb-3 border-4 border-white/20">
                ✓
            </div>
            <h1 class="text-2xl sm:text-3xl font-black tracking-tight">Pembayaran Berhasil!</h1>
            <p class="text-indigo-100 text-xs sm:text-sm max-w-md mx-auto font-medium">
                E-Ticket Anda telah diterbitkan dan bukti pembayaran telah dikirim ke email <strong class="underline decoration-indigo-300 font-bold">{{ $transaction->customer_email }}</strong>
            </p>
        </div>

        <!-- Ticket Card Component -->
        <div class="ticket-card print-card bg-white rounded-[2.5rem] overflow-hidden shadow-2xl shadow-indigo-950/40 border border-indigo-100 transition">
            
            <!-- Ticket Header -->
            <div class="bg-indigo-50 border-b-2 border-dashed border-indigo-200 p-6 sm:p-8 text-center relative">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full text-[10px] font-black tracking-widest uppercase mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>LUNAS &bull; VERIFIED</span>
                </div>
                <h2 class="text-xl sm:text-2xl font-black text-slate-900 leading-tight tracking-tight max-w-md mx-auto">{{ $transaction->event->title }}</h2>
                <p class="text-xs text-indigo-600 font-extrabold uppercase tracking-widest mt-2">E-TICKET RESMI AMIKOMEVENTHUB</p>

                <!-- Left-Right Notch Decoration -->
                <div class="absolute -left-4 -bottom-4 w-8 h-8 bg-indigo-600 dark:bg-slate-950 rounded-full no-print"></div>
                <div class="absolute -right-4 -bottom-4 w-8 h-8 bg-indigo-600 dark:bg-slate-950 rounded-full no-print"></div>
            </div>

            <!-- Ticket Content Grid -->
            <div class="p-6 sm:p-8 space-y-6">
                <div class="grid grid-cols-2 gap-4 text-xs sm:text-sm">
                    <div>
                        <p class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Nama Pembeli</p>
                        <p class="font-extrabold text-slate-900 mt-0.5 truncate">{{ $transaction->customer_name }}</p>
                    </div>

                    <div>
                        <p class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Tanggal & Waktu</p>
                        <p class="font-extrabold text-slate-900 mt-0.5">{{ \Carbon\Carbon::parse($transaction->event->date)->format('d M Y, H:i') }} WIB</p>
                    </div>

                    <div>
                        <p class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Order ID</p>
                        <p class="font-mono font-bold text-indigo-600 mt-0.5 uppercase">{{ $transaction->order_id }}</p>
                    </div>

                    <div>
                        <p class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Lokasi Acara</p>
                        <p class="font-extrabold text-slate-900 mt-0.5 truncate">{{ $transaction->event->location }}</p>
                    </div>
                </div>

                <!-- QR Code Box -->
                <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-5 text-center space-y-3">
                    <p class="text-[11px] font-black uppercase tracking-wider text-slate-500">Scan QR Code untuk Check-in di Lokasi</p>
                    <div class="bg-white p-3 rounded-xl inline-block shadow-sm border border-slate-100">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&data={{ urlencode($transaction->order_id) }}" 
                             alt="QR Code Ticket" class="w-36 h-36 mx-auto block">
                    </div>
                    <p class="font-mono font-bold text-xs text-slate-700 tracking-wider uppercase">{{ $transaction->order_id }}</p>
                </div>
            </div>

            <!-- Ticket Footer -->
            <div class="bg-slate-50 p-4 border-t border-slate-100 text-center text-[11px] text-slate-400 font-medium">
                <p>Tunjukkan E-Ticket ini (digital atau hasil cetak) kepada petugas di pintu masuk acara.</p>
            </div>
        </div>

        <!-- Bottom Actions (No-Print) -->
        <div class="space-y-3 pt-2 no-print">
            <a href="{{ route('home') }}" 
               class="block w-full py-4 bg-white hover:bg-slate-50 text-indigo-700 font-black text-center text-sm rounded-2xl shadow-xl hover:scale-[1.01] active:scale-[0.99] transition">
                🏠 Kembali ke Halaman Utama
            </a>

            <div class="grid grid-cols-2 gap-3">
                <button onclick="window.print()" 
                        class="py-3 bg-indigo-700 hover:bg-indigo-800 text-white font-extrabold text-center text-xs rounded-xl transition border border-indigo-500">
                    🖨️ Cetak / Simpan PDF
                </button>
                <a href="/katalog" 
                   class="py-3 bg-indigo-700 hover:bg-indigo-800 text-white font-extrabold text-center text-xs rounded-xl transition border border-indigo-500 flex items-center justify-center">
                    🎟️ Jelajahi Event Lain
                </a>
            </div>
        </div>

    </main>

    <!-- Footer Copyright (No-Print) -->
    <footer class="text-center text-indigo-200 text-xs py-4 no-print font-medium">
        &copy; {{ date('Y') }} AmikomEventHub &bull; All Rights Reserved
    </footer>

</body>
</html>