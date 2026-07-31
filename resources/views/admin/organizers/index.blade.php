@extends('layouts.admin')

@section('title', 'Kelola Organizers - Admin Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-200 dark:border-slate-800 pb-5">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">Kelola Organizer (Multi-Tenant)</h1>
            <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm mt-1">Daftar penyelenggara event dan status verifikasi di platform AmikomEventHub.</p>
        </div>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="p-3.5 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 rounded-xl text-xs sm:text-sm font-medium flex items-center gap-2">
            <span>✅</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Table Card Container -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-2xl shadow-sm overflow-hidden transition-colors">
        @if($organizers->isEmpty())
            <div class="text-center py-12">
                <p class="text-slate-400 dark:text-slate-500 font-bold text-sm">Belum ada organizer terdaftar di platform.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[700px]">
                    <thead class="bg-slate-50 dark:bg-slate-950/80 text-slate-500 dark:text-slate-400 uppercase text-[10px] font-black tracking-widest border-b border-slate-200 dark:border-slate-800">
                        <tr>
                            <th class="py-3.5 px-4">Nama Organizer</th>
                            <th class="py-3.5 px-4">Slug URL</th>
                            <th class="py-3.5 px-4">Pemilik (User)</th>
                            <th class="py-3.5 px-4 text-center">Total Event</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-right">Aksi Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-xs sm:text-sm">
                        @foreach($organizers as $org)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition">
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 font-extrabold flex items-center justify-center text-xs shrink-0 border border-indigo-100 dark:border-indigo-800/60">
                                            {{ strtoupper(substr($org->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="font-extrabold text-slate-900 dark:text-white">{{ $org->name }}</div>
                                            <div class="text-[11px] text-slate-400 dark:text-slate-400 max-w-xs truncate mt-0.5">{{ $org->description ?? 'Penyelenggara Resmi' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="font-mono text-xs text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-950 px-2 py-0.5 rounded-md border border-slate-200/60 dark:border-slate-800 inline-block">
                                        {{ $org->slug }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="font-bold text-slate-800 dark:text-slate-200">{{ $org->user->name ?? 'N/A' }}</div>
                                    <div class="text-[11px] text-slate-400 dark:text-slate-400">{{ $org->user->email ?? '-' }}</div>
                                </td>
                                <td class="py-3.5 px-4 text-center font-black text-slate-900 dark:text-white">
                                    <span class="px-2.5 py-1 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-lg text-xs">
                                        {{ $org->events->count() }} Event
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    @if($org->status === 'approved')
                                        <span class="px-2.5 py-1 bg-emerald-100 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 text-xs font-bold rounded-lg ring-1 ring-emerald-200 dark:ring-emerald-800/60">Approved</span>
                                    @elseif($org->status === 'pending')
                                        <span class="px-2.5 py-1 bg-amber-100 dark:bg-amber-950/60 text-amber-800 dark:text-amber-300 text-xs font-bold rounded-lg ring-1 ring-amber-200 dark:ring-amber-800/60">Pending</span>
                                    @elseif($org->status === 'suspended' || $org->status === 'rejected')
                                        <span class="px-2.5 py-1 bg-rose-100 dark:bg-rose-950/60 text-rose-800 dark:text-rose-300 text-xs font-bold rounded-lg ring-1 ring-rose-200 dark:ring-rose-800/60">{{ ucfirst($org->status) }}</span>
                                    @else
                                        <span class="px-2.5 py-1 bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200 text-xs font-bold rounded-lg">{{ ucfirst($org->status) }}</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                    <form action="{{ route('admin.organizers.updateStatus', $org->id) }}" method="POST" class="inline-flex items-center">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="text-xs border border-slate-200 dark:border-slate-700 rounded-xl px-2.5 py-1.5 bg-slate-50 dark:bg-slate-800 hover:bg-white dark:hover:bg-slate-700 font-bold text-slate-700 dark:text-slate-200 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition cursor-pointer shadow-sm">
                                            <option value="pending" {{ $org->status === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                            <option value="approved" {{ $org->status === 'approved' ? 'selected' : '' }}>✅ Approve</option>
                                            <option value="rejected" {{ $org->status === 'rejected' ? 'selected' : '' }}>❌ Reject</option>
                                            <option value="suspended" {{ $org->status === 'suspended' ? 'selected' : '' }}>🚫 Suspend</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($organizers->hasPages())
                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-950 border-t border-slate-200 dark:border-slate-800">
                    {{ $organizers->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
