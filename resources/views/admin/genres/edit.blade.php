@extends('layouts.admin')

@section('title', 'Edit Genre')
@section('header_title', 'Edit Data Genre')

@section('content')
<div class="max-w-xl mx-auto">
    <a href="{{ route('admin.genres.index') }}" class="text-neutral-400 hover:text-white mb-6 inline-flex items-center gap-2 text-sm">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
    </a>
    
    <div class="bg-neutral-900 border border-white/5 rounded-2xl p-8 shadow-xl">
        <form action="{{ route('admin.genres.update', $genre->id) }}" method="POST">
            @csrf
            @method('PUT') <div class="mb-6">
                <label class="block text-sm font-bold text-neutral-300 mb-2">Nama Genre</label>
                <input type="text" 
                       name="name" 
                       value="{{ old('name', $genre->name) }}" 
                       class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-emerald-500 focus:outline-none transition-colors" 
                       placeholder="Contoh: Action" 
                       required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-emerald-500/10 border border-emerald-500/20 rounded-lg p-4 mb-6">
                <p class="text-xs text-emerald-400 flex items-start gap-2">
                    <i data-lucide="info" class="w-4 h-4 shrink-0 mt-0.5"></i>
                    Slug URL akan otomatis diperbarui mengikuti perubahan nama genre.
                </p>
            </div>

            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-emerald-900/20">
                Update Genre
            </button>
        </form>
    </div>
</div>
@endsection