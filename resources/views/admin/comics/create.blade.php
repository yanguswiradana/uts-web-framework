@extends('layouts.admin')

@section('title', 'Tambah Komik')
@section('header_title', 'Tambah Komik Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-neutral-900 border border-white/5 rounded-2xl p-8 shadow-xl">
        
        <form action="{{ route('admin.comics.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

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
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Tipe Komik <span class="text-red-500">*</span></label>
                    <select name="type" required class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none">
                        <option value="" disabled selected>-- Pilih Tipe --</option>
                        <option value="Manga" {{ old('type') == 'Manga' ? 'selected' : '' }}>Manga (Jepang)</option>
                        <option value="Manhwa" {{ old('type') == 'Manhwa' ? 'selected' : '' }}>Manhwa (Korea)</option>
                        <option value="Manhua" {{ old('type') == 'Manhua' ? 'selected' : '' }}>Manhua (China)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Status <span class="text-red-500">*</span></label>
                    <select name="status" required class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none">
                        <option value="Ongoing" {{ old('status') == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Genre (Pilih Minimal 1) <span class="text-red-500">*</span></label>
                    <select name="genres[]" multiple required class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none h-32">
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id }}" {{ (collect(old('genres'))->contains($genre->id)) ? 'selected' : '' }}>
                                {{ $genre->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-neutral-500 mt-1">Tekan <strong>Ctrl + Klik</strong> (Windows) atau <strong>Command + Klik</strong> (Mac) untuk memilih lebih dari satu.</p>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-neutral-300 mb-2">Sinopsis <span class="text-red-500">*</span></label>
                <textarea name="description" rows="4" required class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-bold text-neutral-300 mb-2">Cover Komik <span class="text-red-500">*</span></label>
                <input type="file" name="cover" required accept="image/*" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none">
                <p class="text-xs text-neutral-500 mt-1">Format: JPG, PNG, WEBP. Maks 2MB.</p>
            </div>

            <div class="flex justify-end gap-4 pt-4 border-t border-white/5">
                <a href="{{ route('admin.comics.index') }}" class="px-6 py-2.5 rounded-xl text-neutral-400 hover:text-white font-bold transition-colors">Batal</a>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-2.5 rounded-xl font-bold shadow-lg shadow-purple-900/20 transition-all">Simpan Komik</button>
            </div>
        </form>
    </div>
</div>
@endsection