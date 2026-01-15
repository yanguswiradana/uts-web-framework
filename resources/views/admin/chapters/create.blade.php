@extends('layouts.admin')

@section('title', 'Upload Chapter')
@section('header_title', 'Upload Chapter Baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-neutral-900 border border-white/5 rounded-2xl p-8 shadow-xl">
        
        <form action="{{ route('admin.chapters.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-bold text-neutral-300 mb-2">Pilih Komik</label>
                <select name="comic_id" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none appearance-none cursor-pointer">
                    <option value="" disabled selected>-- Cari Komik --</option>
                    @foreach($comics as $comic)
                        <option value="{{ $comic->id }}" {{ (old('comic_id') == $comic->id || (isset($selectedComicId) && $selectedComicId == $comic->id)) ? 'selected' : '' }}>
                            {{ $comic->title }}
                        </option>
                    @endforeach
                </select>
                @error('comic_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Nomor Chapter</label>
                    <input type="number" name="number" value="{{ old('number') }}" placeholder="Contoh: 1, 2, 10.5" step="0.1"
                           class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none placeholder:text-neutral-600">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Judul (Opsional)</label>
                    <input type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: The Beginning" 
                           class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none placeholder:text-neutral-600">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-neutral-300 mb-2">Gambar Konten Chapter</label>
                
                <div class="relative border-2 border-dashed border-white/10 rounded-xl p-10 text-center hover:border-blue-500/50 hover:bg-blue-500/5 transition-all group cursor-pointer">
                    <input type="file" name="content_images[]" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                    
                    <div class="flex flex-col items-center justify-center pointer-events-none">
                        <div class="p-4 bg-neutral-800 rounded-full mb-3 group-hover:bg-blue-600 transition-colors">
                            <i data-lucide="files" class="w-8 h-8 text-neutral-400 group-hover:text-white"></i>
                        </div>
                        <p class="text-base font-medium text-white group-hover:text-blue-400 transition-colors">
                            Drop gambar di sini atau klik untuk memilih
                        </p>
                        <p class="text-sm text-neutral-500 mt-2">
                            Bisa pilih <strong>BANYAK GAMBAR</strong> sekaligus.<br>
                            (Tahan tombol <code>CTRL</code> saat memilih file)
                        </p>
                    </div>
                </div>
                @error('content_images') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-end gap-4 pt-6 border-t border-white/5">
                <a href="{{ route('admin.chapters.index') }}" class="px-6 py-2.5 rounded-xl text-sm font-bold text-neutral-400 hover:text-white hover:bg-white/5 transition-colors">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-xl font-bold shadow-lg shadow-blue-900/20 transition-all flex items-center gap-2">
                    <i data-lucide="upload-cloud" class="w-4 h-4"></i> Upload Chapter
                </button>
            </div>

        </form>
    </div>
</div>
@endsection