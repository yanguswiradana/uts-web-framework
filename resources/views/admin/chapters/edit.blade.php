@extends('layouts.admin')

@section('title', 'Edit Chapter')
@section('header_title', 'Edit Data Chapter')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-neutral-900 border border-white/5 rounded-2xl p-8 shadow-xl">
        
        <form action="{{ route('admin.chapters.update', $chapter->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-bold text-neutral-300 mb-2">Pilih Komik</label>
                <select name="comic_id" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none appearance-none cursor-pointer">
                    @foreach($comics as $comic)
                        <option value="{{ $comic->id }}" {{ $chapter->comic_id == $comic->id ? 'selected' : '' }}>
                            {{ $comic->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Nomor Chapter</label>
                    <input type="number" name="number" value="{{ old('number', $chapter->number) }}" step="0.1"
                           class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Judul (Opsional)</label>
                    <input type="text" name="title" value="{{ old('title', $chapter->title) }}" 
                           class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-neutral-300 mb-2">Slug URL</label>
                <input type="text" name="slug" value="{{ old('slug', $chapter->slug) }}" 
                       class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none">
                <p class="text-xs text-neutral-500 mt-1">Ubah jika ingin mengganti link URL. Kosongkan untuk tetap pakai yang lama.</p>
            </div>

            <div class="bg-yellow-500/10 border border-yellow-500/20 rounded-xl p-4 flex gap-3 items-start">
                <i data-lucide="alert-triangle" class="w-5 h-5 text-yellow-500 shrink-0 mt-0.5"></i>
                <div class="text-sm text-yellow-200">
                    <strong>Info Gambar:</strong><br>
                    Jika Anda mengupload file baru di bawah ini, <u>seluruh gambar lama akan dihapus</u> dan diganti.
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-neutral-300 mb-2">Ganti Gambar Konten</label>
                <div class="relative border-2 border-dashed border-white/10 rounded-xl p-8 text-center hover:border-blue-500/50 hover:bg-blue-500/5 transition-all group cursor-pointer">
                    <input type="file" name="content_images[]" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                    <div class="flex flex-col items-center justify-center">
                        <i data-lucide="refresh-cw" class="w-6 h-6 text-neutral-400 mb-2 group-hover:text-white"></i>
                        <p class="text-sm font-medium text-neutral-300">Klik untuk mengganti gambar</p>
                        <p class="text-xs text-neutral-500 mt-1">Kosongkan jika tidak ingin mengubah isi chapter.</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-6 border-t border-white/5">
                <a href="{{ route('admin.chapters.index') }}" class="px-6 py-2.5 rounded-xl text-sm font-bold text-neutral-400 hover:text-white hover:bg-white/5 transition-colors">Batal</a>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-2.5 rounded-xl font-bold shadow-lg shadow-purple-900/20 transition-all flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>
@endsection