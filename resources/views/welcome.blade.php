@extends('layouts.app')
@section('title', 'Selamat Datang')

@section('content')
<div class="h-[80vh] flex flex-col items-center justify-center text-center px-6">
    <span class="px-4 py-1.5 bg-indigo-50 text-indigo-600 text-[10px] font-bold tracking-[0.2em] uppercase rounded-full mb-6">Universitas AMIKOM Yogyakarta</span>
    <h1 class="text-6xl md:text-7xl font-bold tracking-tight text-[#1D1D1F] mb-6">Amikom <span class="text-indigo-600">Event Hub.</span></h1>
    <p class="text-xl text-slate-500 max-w-2xl mb-12 font-light leading-relaxed">Platform pusat informasi event mahasiswa terbesar di Universitas AMIKOM Yogyakarta.</p>
    <div class="flex gap-4">
        <a href="/katalog" class="px-10 py-4 bg-indigo-600 text-white text-sm font-bold rounded-full hover:bg-indigo-700 transition shadow-xl shadow-indigo-100">Jelajahi Event</a>
        <a href="/profil" class="px-10 py-4 bg-white text-slate-800 border border-slate-200 text-sm font-bold rounded-full hover:bg-slate-50 transition shadow-sm">Tentang Saya</a>
    </div>
</div>
@endsection
