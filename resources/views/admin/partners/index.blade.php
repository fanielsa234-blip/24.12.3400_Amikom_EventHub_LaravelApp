@extends('layouts.admin')
@section('title', 'Kelola Partner - Admin')

@section('content')
<header class="flex justify-between items-center mb-10">
    <div>
        <h1 class="text-3xl font-black">Kelola Partner</h1>
        <p class="text-slate-500 font-medium">Data partner pendukung AmikomEventHub.</p>
    </div>
    <a href="{{ route('admin.partners.create') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg hover:bg-indigo-700 transition">
        + Tambah Partner Baru
    </a>
</header>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-xl border border-green-200 mb-6 font-bold">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4 w-16">No</th>
                    <th class="px-8 py-4">Logo Partner</th>
                    <th class="px-8 py-4">Nama Perusahaan</th>
                    <th class="px-8 py-4">Tgl Bergabung</th>
                    <th class="px-8 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @foreach($partners as $index => $partner)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-6 font-bold text-slate-400">{{ $index + 1 }}</td>
                    <td class="px-8 py-6">
                        <img src="{{ $partner->logo_url }}" class="w-16 h-16 rounded-xl object-cover shadow-sm bg-slate-100">
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-black text-slate-800 text-lg">{{ $partner->name }}</p>
                    </td>
                    <td class="px-8 py-6 text-slate-500 font-medium">
                        {{ $partner->created_at->format('d M Y') }}
                    </td>
                    <td class="px-8 py-6 flex gap-2">
                        <!-- Tombol Edit -->
                        <a href="{{ route('admin.partners.edit', $partner->id) }}" class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-lg text-sm font-bold hover:bg-indigo-600 hover:text-white transition">
                            Edit
                        </a>
                        <!-- Tombol Hapus -->
                        <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus partner ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-rose-50 text-rose-600 rounded-lg text-sm font-bold hover:bg-rose-600 hover:text-white transition">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection