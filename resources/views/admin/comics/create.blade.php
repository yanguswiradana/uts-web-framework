@extends('layouts.admin')

@section('title', 'Tambah Komik')
@section('header_title', 'Tambah Komik Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-neutral-900 border border-white/5 rounded-2xl p-8 shadow-xl">
        
        <form action="{{ route('admin.comics.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Judul Komik <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required placeholder="Contoh: Solo Leveling" 
                           class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-neutral-300 mb-2">Penulis <span class="text-red-500">*</span></label>
                        <input type="text" name="author" value="{{ old('author') }}" required placeholder="Nama Pengarang" 
                               class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-neutral-300 mb-2">Tahun Rilis <span class="text-red-500">*</span></label>
                        <input type="number" name="release_year" value="{{ old('release_year', date('Y')) }}" required placeholder="Contoh: 2024" min="1900" max="{{ date('Y')+1 }}"
                               class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-neutral-300 mb-2">Tipe Komik <span class="text-red-500">*</span></label>
                        <select name="type" required class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none">
                            <option value="" disabled selected>-- Pilih Tipe --</option>
                            <option value="Manga">Manga (Jepang)</option>
                            <option value="Manhwa">Manhwa (Korea)</option>
                            <option value="Manhua">Manhua (China)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-neutral-300 mb-2">Status <span class="text-red-500">*</span></label>
                        <select name="status" required class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none">
                            <option value="Ongoing">Ongoing</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Cover Komik <span class="text-red-500">*</span></label>
                    <input type="file" name="cover" required accept="image/*" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-purple-600 file:text-white hover:file:bg-purple-700">
                </div>
            </div>

            <hr class="border-white/5">

            <div>
                <label class="block text-sm font-bold text-neutral-300 mb-4">Pilih Genre (Minimal 1) <span class="text-red-500">*</span></label>
                
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                    @foreach($genres as $genre)
                        <label class="cursor-pointer group relative">
                            <input type="checkbox" name="genres[]" value="{{ $genre->id }}" class="peer sr-only">
                            
                            <div class="px-4 py-3 rounded-xl border border-white/10 bg-neutral-950 text-neutral-400 text-sm font-bold text-center transition-all duration-200 
                                      group-hover:border-purple-500/50
                                      peer-checked:bg-purple-600 peer-checked:text-white peer-checked:border-purple-500 peer-checked:shadow-lg peer-checked:shadow-purple-900/40">
                                
                                <div class="flex items-center justify-center gap-2">
                                    <i data-lucide="check" class="w-4 h-4 hidden peer-checked:block"></i>
                                    <span>{{ $genre->name }}</span>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('genres') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
            </div>

            <hr class="border-white/5">

            <div>
                <label class="block text-sm font-bold text-neutral-300 mb-2">Sinopsis <span class="text-red-500">*</span></label>
                <textarea name="description" rows="5" required placeholder="Ceritakan alur cerita komik ini..." 
                          class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none"></textarea>
            </div>

            <div class="flex justify-end gap-4 pt-4">
                <a href="{{ route('admin.comics.index') }}" class="px-6 py-2.5 rounded-xl text-neutral-400 hover:text-white font-bold transition-colors">Batal</a>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-2.5 rounded-xl font-bold shadow-lg shadow-purple-900/20 transition-all flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan Komik
                </button>
            </div>

        </form>
    </div>
</div>
@endsection