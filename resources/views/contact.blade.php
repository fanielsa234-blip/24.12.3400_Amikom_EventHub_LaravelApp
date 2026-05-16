@extends('layouts.app')
@section('title', 'Hubungi Kami')
@section('content')
<div class="max-w-2xl mx-auto px-6 py-20 flex flex-col items-center">
    <div class="bg-white p-10 rounded-3xl w-full shadow-sm border border-slate-100 text-center">
        <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl mx-auto mb-6 flex items-center justify-center text-2xl">✉️</div>
        <h1 class="text-3xl font-bold mb-4">Hubungi Kami</h1>
        <p class="text-slate-500 mb-8 font-light">Kami siap membantu Anda mengenai informasi event di Amikom.</p>
        <a href="mailto:contact@amikom.ac.id" class="text-xl font-semibold text-indigo-600 hover:underline transition-all">
            contact@amikom.ac.id
        </a>
        <div class="mt-12 text-xs text-slate-400 tracking-widest uppercase">Gedung Unit IV Amikom Yogyakarta</div>
    </div>
</div>
@endsection
</body>
</html>
