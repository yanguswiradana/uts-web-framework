@extends('layouts.admin')
@section('title', 'Tambah Genre')
@section('header_title', 'Tambah Genre Baru')

@section('content')
<div class="max-w-xl mx-auto">
    <a href="{{ route('admin.genres.index') }}" class="text-neutral-400 hover:text-white mb-6 inline-flex items-center gap-2 text-sm"><i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali</a>
    
    <div class="bg-neutral-900 border border-white/5 rounded-2xl p-8 shadow-xl">
        <form action="{{ route('admin.genres.store') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-bold text-neutral-300 mb-2">Nama Genre</label>
                <input type="text" name="name" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-emerald-500 focus:outline-none" placeholder="Contoh: Action" required>
            </div>
            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-3 rounded-xl transition-all">Simpan Genre</button>
        </form>
    </div>
</div>
@endsection