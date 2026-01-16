@extends('layouts.admin')

@section('title', 'Tambah Anime')
@section('header_title', 'Tambah Anime Baru')

@section('content')
<div class="max-w-3xl mx-auto bg-neutral-900 border border-white/5 rounded-2xl p-8 shadow-xl">
    
    <form action="{{ route('admin.animes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-bold text-neutral-300 mb-2">Judul Anime <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title') }}" required placeholder="Contoh: Kimetsu no Yaiba" 
                   class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500 placeholder:text-neutral-600">
            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-neutral-300 mb-2">Studio Pembuat <span class="text-red-500">*</span></label>
                <input type="text" name="studio" value="{{ old('studio') }}" required placeholder="Contoh: Ufotable" 
                       class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500">
            </div>

            <div>
                <label class="block text-sm font-bold text-neutral-300 mb-2">Tahun Rilis <span class="text-red-500">*</span></label>
                <input type="number" name="release_year" value="{{ old('release_year', date('Y')) }}" required placeholder="2024" min="1900" max="{{ date('Y')+1 }}"
                       class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500">
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-neutral-300 mb-2">Status <span class="text-red-500">*</span></label>
            <select name="status" required class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500">
                <option value="Ongoing">Ongoing (Sedang Tayang)</option>
                <option value="Completed">Completed (Tamat)</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-neutral-300 mb-2">Sinopsis / Deskripsi</label>
            <textarea name="description" rows="4" placeholder="Ceritakan sedikit tentang anime ini..." 
                      class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-bold text-neutral-300 mb-2">Cover Anime <span class="text-red-500">*</span></label>
            <div class="relative border-2 border-dashed border-white/10 rounded-xl p-6 text-center hover:border-red-500/50 hover:bg-red-500/5 transition-all group cursor-pointer">
                <input type="file" name="cover" required accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                
                <div class="flex flex-col items-center justify-center pointer-events-none">
                    <div class="p-3 bg-neutral-800 rounded-full mb-3 group-hover:bg-red-600 transition-colors">
                        <i data-lucide="image" class="w-6 h-6 text-neutral-400 group-hover:text-white"></i>
                    </div>
                    <p class="text-sm font-medium text-white group-hover:text-red-400 transition-colors">
                        Klik untuk upload cover
                    </p>
                    <p class="text-xs text-neutral-500 mt-1">Format: JPG, PNG, WEBP. Max 2MB.</p>
                </div>
            </div>
            @error('cover') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-white/5">
            <a href="{{ route('admin.animes.index') }}" class="px-6 py-2.5 rounded-xl text-neutral-400 hover:text-white font-bold transition-colors">Batal</a>
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-8 py-2.5 rounded-xl font-bold shadow-lg shadow-red-900/20 transition-all flex items-center gap-2">
                <i data-lucide="save" class="w-4 h-4"></i> Simpan Anime
            </button>
        </div>

    </form>
</div>
@endsection