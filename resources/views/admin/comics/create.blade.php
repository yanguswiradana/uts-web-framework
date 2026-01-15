@extends('layouts.admin')

@section('title', 'Tambah Komik')
@section('header_title', 'Tambah Komik Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-neutral-900 border border-white/5 rounded-2xl p-8 shadow-xl">
        
        <form action="{{ route('admin.comics.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-bold text-neutral-300 mb-2">Judul Komik</label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: Solo Leveling" 
                       class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none placeholder:text-neutral-600 transition-colors">
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Tipe</label>
                    <select name="type" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none appearance-none cursor-pointer">
                        <option value="Manga">🇯🇵 Manga (Jepang)</option>
                        <option value="Manhwa">🇰🇷 Manhwa (Korea)</option>
                        <option value="Manhua">🇨🇳 Manhua (China)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Status</label>
                    <select name="status" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none appearance-none cursor-pointer">
                        <option value="Ongoing">🟢 Ongoing (Berlanjut)</option>
                        <option value="Finished">🔵 Finished (Tamat)</option>
                        <option value="Hiatus">🟡 Hiatus (Istirahat)</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-neutral-300 mb-3">Genre (Pilih Minimal Satu)</label>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 bg-neutral-950 p-4 rounded-xl border border-white/5 max-h-60 overflow-y-auto custom-scrollbar">
                    @foreach($genres as $genre)
                    <label class="flex items-center gap-3 p-2 rounded-lg hover:bg-white/5 cursor-pointer transition-colors">
                        <div class="relative flex items-center">
                            <input type="checkbox" name="genres[]" value="{{ $genre->id }}" class="peer appearance-none w-5 h-5 border border-white/20 rounded bg-neutral-900 checked:bg-purple-600 checked:border-purple-600 transition-all">
                            <i data-lucide="check" class="absolute inset-0 m-auto w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100 pointer-events-none"></i>
                        </div>
                        <span class="text-sm text-neutral-400 peer-checked:text-white">{{ $genre->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-neutral-300 mb-2">Sinopsis / Deskripsi</label>
                <textarea name="description" rows="4" placeholder="Ceritakan ringkasan komik ini..."
                          class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none custom-scrollbar placeholder:text-neutral-600"></textarea>
            </div>

            <div>
                <label class="block text-sm font-bold text-neutral-300 mb-2">Cover Komik</label>
                <div class="relative border-2 border-dashed border-white/10 rounded-xl p-8 text-center hover:border-purple-500/50 hover:bg-purple-500/5 transition-all group cursor-pointer">
                    <input type="file" name="cover" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                    <div class="flex flex-col items-center justify-center">
                        <div class="p-3 bg-neutral-800 rounded-full mb-3 group-hover:bg-purple-600 transition-colors">
                            <i data-lucide="image-plus" class="w-6 h-6 text-neutral-400 group-hover:text-white"></i>
                        </div>
                        <p class="text-sm font-medium text-neutral-300">Klik untuk upload cover</p>
                        <p class="text-xs text-neutral-500 mt-1">Format: JPG, PNG, WEBP (Max 2MB)</p>
                    </div>
                </div>
                @error('cover') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-end gap-4 pt-4 border-t border-white/5">
                <a href="{{ route('admin.comics.index') }}" class="px-6 py-2.5 rounded-xl text-sm font-bold text-neutral-400 hover:text-white hover:bg-white/5 transition-colors">Batal</a>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-2.5 rounded-xl font-bold shadow-lg shadow-purple-900/20 transition-all flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan Komik
                </button>
            </div>

        </form>
    </div>
</div>
@endsection