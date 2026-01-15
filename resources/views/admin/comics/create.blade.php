@extends('layouts.admin')

@section('title', 'Tambah Komik')
@section('header_title', 'Tambah Komik Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    
    <a href="{{ route('admin.comics.index') }}" class="inline-flex items-center text-neutral-400 hover:text-white mb-6 transition-colors text-sm">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i> Kembali ke List
    </a>

    <div class="bg-neutral-900 border border-white/5 rounded-2xl p-6 md:p-8 shadow-xl">
        <form action="{{ route('admin.comics.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                
                <div class="col-span-2">
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Cover Komik (Sampul)</label>
                    <div class="flex items-center gap-4">
                        <input type="file" name="cover" 
                               class="block w-full text-sm text-neutral-400
                                      file:mr-4 file:py-2.5 file:px-4
                                      file:rounded-xl file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-purple-600 file:text-white
                                      hover:file:bg-purple-500
                                      cursor-pointer bg-neutral-950 border border-white/10 rounded-xl">
                    </div>
                    <p class="text-xs text-neutral-500 mt-2">*Format: JPG, PNG, WEBP. Maks: 2MB.</p>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Judul Komik</label>
                    <input type="text" name="title" value="{{ old('title') }}" 
                           class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-all placeholder:text-neutral-700" 
                           placeholder="Contoh: Solo Leveling" required>
                    @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Slug (URL)</label>
                    <input type="text" name="slug" value="{{ old('slug') }}" 
                           class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500 transition-all placeholder:text-neutral-700" 
                           placeholder="solo-leveling" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Penulis / Author</label>
                    <input type="text" name="author" value="{{ old('author') }}" 
                           class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500 transition-all placeholder:text-neutral-700" 
                           placeholder="Nama Pengarang" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Tipe Komik</label>
                    <div class="relative">
                        <select name="type" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500 appearance-none cursor-pointer">
                            <option value="Manga">Manga (Jepang)</option>
                            <option value="Manhwa">Manhwa (Korea)</option>
                            <option value="Manhua">Manhua (China)</option>
                        </select>
                        <i data-lucide="chevron-down" class="absolute right-4 top-3.5 w-5 h-5 text-neutral-500 pointer-events-none"></i>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Status</label>
                    <div class="relative">
                        <select name="status" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500 appearance-none cursor-pointer">
                            <option value="Ongoing">Ongoing (Masih Berlanjut)</option>
                            <option value="Finished">Finished (Tamat)</option>
                            <option value="Hiatus">Hiatus (Istirahat)</option>
                        </select>
                        <i data-lucide="chevron-down" class="absolute right-4 top-3.5 w-5 h-5 text-neutral-500 pointer-events-none"></i>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-bold text-neutral-300 mb-3">Pilih Genre</label>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 bg-neutral-950 p-4 rounded-xl border border-white/5">
                    @foreach($genres as $genre)
                    <label class="relative flex items-center group cursor-pointer">
                        <input type="checkbox" name="genres[]" value="{{ $genre->id }}" class="peer sr-only">
                        <div class="w-full px-4 py-2 rounded-lg border border-white/10 bg-neutral-900 text-neutral-400 text-sm font-medium transition-all
                                    peer-checked:bg-purple-600 peer-checked:text-white peer-checked:border-purple-500 peer-checked:shadow-lg peer-checked:shadow-purple-900/50
                                    group-hover:border-purple-500/50">
                            {{ $genre->name }}
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center justify-end pt-6 border-t border-white/5">
                <button type="submit" class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-purple-900/30 transition-all transform hover:-translate-y-0.5">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection