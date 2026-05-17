@extends('layouts.app')
@section('title', 'Tentang Kami - AmikomEventHub')

@section('content')
<main class="max-w-7xl mx-auto px-6 py-20 animate-fade-in">
    <!-- Header Section -->
    <div class="text-center max-w-3xl mx-auto mb-20">
        <span class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider mb-6">Tentang Kami</span>
        <h1 class="text-4xl md:text-6xl font-extrabold leading-tight mb-6 text-slate-800">
            Mendukung Ekosistem Digital <span class="text-indigo-600">Universitas AMIKOM</span>
        </h1>
        <p class="text-lg text-slate-500 leading-relaxed font-medium">
            AmikomEventHub adalah platform modern untuk menghubungkan mahasiswa, dosen, dan praktisi industri melalui berbagai kegiatan edukatif, teknologi, dan hiburan.
        </p>
    </div>

    <!-- Konten Universitas Amikom -->
    <div class="flex flex-col lg:flex-row gap-12 items-center mb-24">
        <!-- Gambar Amikom (Kiri) -->
        <div class="w-full lg:w-1/2 relative group">
            <!-- Dekorasi Latar -->
            <div class="absolute inset-0 bg-indigo-400 rounded-4xl mix-blend-multiply filter blur-2xl opacity-20 transform translate-x-4 translate-y-4 transition group-hover:opacity-30"></div>
            
            <!-- GAMBAR GEDUNG AMIKOM DARI FILE LOKAL -->
            <!-- Jika gambar tidak muncul, pastikan nama file dan letaknya di public/assets/ sudah benar -->
            <img src="{{ asset('assets/amikom.png') }}" alt="Gedung Amikom Yogyakarta" class="rounded-4xl shadow-xl relative z-10 w-full object-cover aspect-4/3 max-h-100">
        </div>

        <!-- Box Visi Misi (Kanan, Dikecilkan) -->
        <div class="w-full lg:w-1/2 flex flex-col gap-6">
            <!-- Box Visi Kami -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition">
                <div class="flex items-center gap-4 mb-3">
                    <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center text-xl shadow-inner shrink-0">🎯</div>
                    <h3 class="text-xl font-bold text-slate-800">Visi Kami</h3>
                </div>
                <p class="text-slate-500 leading-relaxed text-sm font-medium">Menjadi pusat informasi dan manajemen event kampus yang terintegrasi, memudahkan setiap mahasiswa untuk terus berkembang dan berjejaring di era digital.</p>
            </div>

            <!-- Box Kolaborasi Industri -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition">
                <div class="flex items-center gap-4 mb-3">
                    <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center text-xl shadow-inner shrink-0">🚀</div>
                    <h3 class="text-xl font-bold text-slate-800">Kolaborasi Industri</h3>
                </div>
                <p class="text-slate-500 leading-relaxed text-sm font-medium">Bekerja sama dengan berbagai partner industri dan organisasi kemahasiswaan untuk menghadirkan event bertaraf nasional maupun internasional.</p>
            </div>
        </div>
    </div>

    <!-- Penyelenggara Event Utama -->
    <div class="bg-indigo-900 rounded-[3rem] p-10 md:p-16 text-white shadow-2xl relative overflow-hidden">
        <!-- Dekorasi -->
        <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl"></div>
        <div class="absolute -left-10 -top-10 w-32 h-32 bg-indigo-400 opacity-20 rounded-full blur-2xl"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-12">
            <div class="shrink-0">
                <div class="w-40 h-40 rounded-3xl bg-white p-4 shadow-2xl flex items-center justify-center transform rotate-3 hover:rotate-0 transition duration-300">
                    <div class="text-center">
                        <span class="text-4xl font-black text-indigo-900 tracking-tighter">AMIKOM</span>
                        <span class="text-xs font-bold text-indigo-600 block uppercase tracking-widest mt-1">Yogyakarta</span>
                    </div>
                </div>
            </div>
            <div class="flex-1 text-center md:text-left space-y-4">
                <span class="text-indigo-300 font-bold uppercase tracking-widest text-sm">Tentang Penyelenggara Utama</span>
                <h2 class="text-3xl md:text-4xl font-black leading-tight">Universitas AMIKOM Yogyakarta</h2>
                <p class="text-indigo-100 leading-relaxed max-w-3xl mt-4 text-lg font-light">
                    Sebagai perguruan tinggi IT terkemuka di Indonesia yang berfokus pada ekonomi kreatif, Universitas AMIKOM Yogyakarta secara aktif mendukung pertumbuhan ekosistem digital. Melalui platform <strong>AmikomEventHub</strong>, kami hadir untuk memudahkan mahasiswa, dosen, dan masyarakat luas dalam mengakses berbagai kegiatan inovatif seperti seminar teknologi, workshop keahlian, dan kompetisi bergengsi.
                </p>
            </div>
        </div>
    </div>
</main>

<style>
    /* Animasi sederhana agar web terlihat smooth saat dibuka */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.8s ease-out forwards;
    }
</style>
@endsection
