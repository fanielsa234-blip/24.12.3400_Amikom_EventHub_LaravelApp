@extends('layouts.admin')
@section('title', 'Tambah Partner Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <header class="mb-10 flex items-center gap-4">
        <a href="{{ route('admin.partners.index') }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm border hover:bg-slate-50">
            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <div>
            <h1 class="text-3xl font-black">Tambah Partner</h1>
            <p class="text-slate-500 font-medium">Masukkan identitas partner baru.</p>
        </div>
    </header>

    <form action="{{ route('admin.partners.store') }}" method="POST" class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 space-y-6">
        @csrf
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Nama Partner / Perusahaan</label>
            <input type="text" name="name" placeholder="Misal: PT Teknologi Cemerlang" class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium" required>
        </div>
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">URL Logo (Link Gambar Eksternal)</label>
            <input type="url" name="logo_url" placeholder="https://placehold.co/200x200" class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium" required>
        </div>
        
        <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-black text-xl shadow-xl shadow-indigo-200 hover:bg-indigo-700 active:scale-95 transition-all">
            Simpan Partner
        </button>
    </form>
</div>
@endsection