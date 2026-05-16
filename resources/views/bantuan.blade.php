@extends('layouts.app')
@section('title', 'Pusat Bantuan')
@section('content')
<div class="max-w-3xl mx-auto px-6 py-20">
    <h1 class="text-4xl font-bold text-center mb-12">FAQ</h1>
    <div class="space-y-4">
        <details class="group bg-white p-6 rounded-2xl border border-slate-100 shadow-sm" open>
            <summary class="flex justify-between items-center font-bold cursor-pointer list-none text-lg">
                Apa itu Laravel?
                <span class="text-indigo-600 transition group-open:rotate-180">▾</span>
            </summary>
            <p class="text-slate-500 mt-4 leading-relaxed font-light">
                Laravel adalah framework PHP yang sangat populer dan elegan, digunakan untuk membangun aplikasi web modern.
            </p>
        </details>
        
        <details class="group bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
            <summary class="flex justify-between items-center font-bold cursor-pointer list-none text-lg">
                Bagaimana cara daftar event?
                <span class="text-indigo-600 transition group-open:rotate-180">▾</span>
            </summary>
            <p class="text-slate-500 mt-4 leading-relaxed font-light">
                Pilih event di katalog, klik tombol detail, dan ikuti instruksi pendaftaran yang tertera.
            </p>
        </details>
    </div>
</div>
@endsection
