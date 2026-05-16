@extends('layouts.app')
@section('title', 'Katalog Event')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-20">
    <div class="text-center mb-16">
        <h1 class="text-4xl font-bold tracking-tight">Event <span class="text-indigo-600">Terbaru</span></h1>
        <p class="text-slate-500 mt-3">Daftar kegiatan mahasiswa Amikom bulan ini</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:shadow-xl transition duration-300">
            <div class="h-40 bg-indigo-50 rounded-2xl mb-6 flex items-center justify-center text-4xl">🎤</div>
            <h3 class="font-bold text-lg">Seminar Technopreneur</h3>
            <p class="text-slate-500 text-sm mb-6 leading-relaxed">Gedung Cinema Amikom, 15 Juli 2026. Belajar bisnis dari nol.</p>
            <button class="w-full py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">Detail Event</button>
        </div>
        
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:shadow-xl transition duration-300">
            <div class="h-40 bg-indigo-50 rounded-2xl mb-6 flex items-center justify-center text-4xl">🎨</div>
            <h3 class="font-bold text-lg">Workshop Desain Grafis</h3>
            <p class="text-slate-500 text-sm mb-6 leading-relaxed">Lab Desain Amikom, 22 Juli 2026. Kuasai tools desain terkini.</p>
            <button class="w-full py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">Detail Event</button>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:shadow-xl transition duration-300">
            <div class="h-40 bg-indigo-50 rounded-2xl mb-6 flex items-center justify-center text-4xl">🤖</div>
            <h3 class="font-bold text-lg">Lomba Robotika</h3>
            <p class="text-slate-500 text-sm mb-6 leading-relaxed">Lapangan Amikom, 30 Juli 2026. Tantang kreativitasmu dalam robotika.</p>
            <button class="w-full py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">Detail Event</button>
        </div>
    </div>
</div>
@endsection