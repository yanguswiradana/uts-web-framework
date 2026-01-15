@extends('layouts.admin')

@section('title', 'Upload Chapter')
@section('header_title', 'Upload Chapter Baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-neutral-900 border border-white/5 rounded-2xl p-8 shadow-xl">
        
        <form action="{{ route('admin.chapters.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-bold text-neutral-300 mb-2">Pilih Komik <span class="text-red-500">*</span></label>
                <select name="comic_id" required class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none appearance-none cursor-pointer">
                    <option value="" disabled selected>-- Cari Komik --</option>
                    @foreach($comics as $comic)
                        <option value="{{ $comic->id }}" {{ (old('comic_id') == $comic->id || (isset($selectedComicId) && $selectedComicId == $comic->id)) ? 'selected' : '' }}>
                            {{ $comic->title }}
                        </option>
                    @endforeach
                </select>
                @error('comic_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Nomor Chapter <span class="text-red-500">*</span></label>
                    <input type="number" name="number" value="{{ old('number') }}" required placeholder="Contoh: 1" step="0.1"
                           class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none">
                    @error('number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Judul (Opsional)</label>
                    <input type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: The Beginning" 
                           class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-neutral-300 mb-2">Slug URL (Opsional)</label>
                <input type="text" name="slug" value="{{ old('slug') }}" placeholder="Custom URL, misal: chapter-1-spesial" 
                       class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none">
                <p class="text-xs text-neutral-500 mt-1">Kosongkan untuk generate otomatis.</p>
            </div>

            <div>
                <label class="block text-sm font-bold text-neutral-300 mb-2">Gambar Konten Chapter <span class="text-red-500">*</span></label>
                
                <div class="relative border-2 border-dashed border-white/10 rounded-xl p-8 text-center hover:border-blue-500/50 hover:bg-blue-500/5 transition-all group cursor-pointer">
                    <input type="file" name="content_images[]" multiple required accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    
                    <div class="flex flex-col items-center justify-center pointer-events-none">
                        <div class="p-3 bg-neutral-800 rounded-full mb-3 group-hover:bg-blue-600 transition-colors">
                            <i data-lucide="files" class="w-6 h-6 text-neutral-400 group-hover:text-white"></i>
                        </div>
                        <p class="text-sm font-medium text-white group-hover:text-blue-400 transition-colors">
                            Klik atau Drag gambar ke sini
                        </p>
                        <p class="text-xs text-neutral-500 mt-1">
                            Format: JPG, PNG, WEBP. Bisa pilih <strong>Banyak Gambar</strong> sekaligus.
                        </p>
                    </div>
                </div>
                @error('content_images') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                @error('content_images.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-end gap-4 pt-6 border-t border-white/5">
                <a href="{{ route('admin.chapters.index') }}" class="px-6 py-2.5 rounded-xl text-neutral-400 hover:text-white font-bold transition-colors">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-xl font-bold shadow-lg shadow-blue-900/20 transition-all flex items-center gap-2">
                    <i data-lucide="upload-cloud" class="w-4 h-4"></i> Upload Chapter
                </button>
            </div>

        </form>
    </div>
</div>
@endsection