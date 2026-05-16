@extends('layouts.app')
@section('title', 'Manajemen Kategori')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-12">
    <div class="flex justify-between items-center mb-10">
        <h1 class="text-3xl font-bold">Manajemen <span class="text-indigo-600">Kategori</span></h1>
        <button class="px-5 py-2 bg-indigo-600 text-white text-xs font-bold rounded-lg hover:bg-indigo-700 transition"> + TAMBAH KATEGORI</button>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="p-5 text-xs font-bold text-slate-400 uppercase tracking-widest text-center w-16">ID</th>
                    <th class="p-5 text-xs font-bold text-slate-400 uppercase tracking-widest">Nama Kategori</th>
                    <th class="p-5 text-xs font-bold text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <tr>
                    <td class="p-5 text-sm text-center text-slate-500">1</td>
                    <td class="p-5 font-semibold">Seminar</td>
                    <td class="p-5 text-center flex justify-center gap-2">
                        <button class="px-3 py-1 bg-amber-50 text-amber-600 text-[10px] font-bold rounded uppercase">Edit</button>
                        <button class="px-3 py-1 bg-red-50 text-red-600 text-[10px] font-bold rounded uppercase">Hapus</button>
                    </td>
                </tr>
                <tr>
                    <td class="p-5 text-sm text-center text-slate-500">2</td>
                    <td class="p-5 font-semibold">Workshop</td>
                    <td class="p-5 text-center flex justify-center gap-2">
                        <button class="px-3 py-1 bg-amber-50 text-amber-600 text-[10px] font-bold rounded uppercase">Edit</button>
                        <button class="px-3 py-1 bg-red-50 text-red-600 text-[10px] font-bold rounded uppercase">Hapus</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
