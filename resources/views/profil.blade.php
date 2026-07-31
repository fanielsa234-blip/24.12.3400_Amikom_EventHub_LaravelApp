@extends('layouts.app')
@section('title', 'Profil Profesional')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-20">
    <div class="flex flex-col md:flex-row gap-16 items-center md:items-start text-center md:text-left">
        <div class="shrink-0">
            <div class="w-48 h-48 rounded-full bg-linear-to-br from-indigo-100 to-slate-200 p-1 shadow-inner flex items-center justify-center text-7xl bg-white">👩‍💻</div>
        </div>
        <div class="flex-1 space-y-8">
            <header>
                <h1 class="text-5xl font-bold tracking-tight mb-2">Alfiya Trisna E.</h1>
                <p class="text-xl text-indigo-600 font-medium">NIM: 24.12.3400</p>
                <p class="text-slate-400 font-mono text-sm uppercase">S1 Sistem Informasi</p>
            </header>
            <section class="space-y-4">
                <h2 class="text-[11px] font-bold uppercase tracking-[0.2em] text-slate-400">Bio Ringkas</h2>
                <p class="text-xl leading-relaxed text-slate-600 font-light italic">"Berdedikasi untuk membangun solusi digital yang bermakna melalui kode yang bersih dan desain yang intuitif."</p>
            </section>
        </div>
    </div>
</div>
@endsection