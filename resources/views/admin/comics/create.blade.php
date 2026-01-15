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
                        <option value="Manga">Manga (Jepang)</option>
                        <option value="Manhwa">Manhwa (Korea)</option>
                        <option value="Manhua">Manhua (China)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Status <span class="text-red-500">*</span></label>
                    <select name="status" required class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none">
                        <option value="Ongoing">Ongoing</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Cover Komik <span class="text-red-500">*</span></label>
                    <input type="file" name="cover" required accept="image/*" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-neutral-300 mb-2">Pilih Genre (Klik untuk memilih) <span class="text-red-500">*</span></label>
                
                <div class="flex flex-wrap gap-2 p-4 bg-neutral-950 border border-white/10 rounded-xl" id="genreContainer">
                    @foreach($genres as $genre)
                        <div onclick="toggleGenre('{{ $genre->id }}')" 
                             id="genre-btn-{{ $genre->id }}"
                             class="cursor-pointer px-4 py-2 rounded-lg text-sm font-bold border border-white/10 bg-neutral-800 text-neutral-400 hover:bg-neutral-700 transition-all select-none">
                            {{ $genre->name }}
                        </div>
                    @endforeach
                </div>

                <select name="genres[]" id="realGenreInput" multiple class="hidden" required>
                    @foreach($genres as $genre)
                        <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                    @endforeach
                </select>
                
                <p class="text-xs text-neutral-500 mt-2">Genre yang dipilih akan berwarna <strong>Ungu</strong>.</p>
            </div>

            <div>
                <label class="block text-sm font-bold text-neutral-300 mb-2">Sinopsis <span class="text-red-500">*</span></label>
                <textarea name="description" rows="4" required class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none"></textarea>
            </div>

            <div class="flex justify-end gap-4 pt-4 border-t border-white/5">
                <a href="{{ route('admin.comics.index') }}" class="px-6 py-2.5 rounded-xl text-neutral-400 hover:text-white font-bold transition-colors">Batal</a>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-2.5 rounded-xl font-bold shadow-lg shadow-purple-900/20 transition-all">Simpan Komik</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleGenre(id) {
        // 1. Ambil elemen option di select asli
        const option = document.querySelector(`#realGenreInput option[value='${id}']`);
        // 2. Ambil tombol visual
        const btn = document.getElementById(`genre-btn-${id}`);

        // 3. Toggle status selected
        option.selected = !option.selected;

        // 4. Ubah Tampilan Tombol (Ungu = Aktif, Abu = Mati)
        if (option.selected) {
            btn.classList.remove('bg-neutral-800', 'text-neutral-400');
            btn.classList.add('bg-purple-600', 'text-white', 'border-purple-500');
        } else {
            btn.classList.remove('bg-purple-600', 'text-white', 'border-purple-500');
            btn.classList.add('bg-neutral-800', 'text-neutral-400');
        }
    }
</script>
@endsection