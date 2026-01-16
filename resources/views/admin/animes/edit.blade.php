@extends('layouts.admin')

@section('title', 'Edit Anime')
@section('header_title', 'Edit Data Anime')

@section('content')
<div class="max-w-3xl mx-auto bg-neutral-900 border border-white/5 rounded-2xl p-8 shadow-xl">
    <form action="{{ route('admin.animes.update', $anime->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-bold text-neutral-300 mb-2">Judul Anime</label>
            <input type="text" name="title" value="{{ old('title', $anime->title) }}" required 
                   class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500">
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-neutral-300 mb-2">Studio</label>
                <input type="text" name="studio" value="{{ old('studio', $anime->studio) }}" required 
                       class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500">
            </div>
            <div>
                <label class="block text-sm font-bold text-neutral-300 mb-2">Tahun Rilis</label>
                <input type="number" name="release_year" value="{{ old('release_year', $anime->release_year) }}" required 
                       class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500">
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-neutral-300 mb-2">Status</label>
            <select name="status" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500">
                <option value="Ongoing" {{ $anime->status == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                <option value="Completed" {{ $anime->status == 'Completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-neutral-300 mb-2">Sinopsis</label>
            <textarea name="description" rows="4" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500">{{ old('description', $anime->description) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-bold text-neutral-300 mb-2">Cover Anime</label>
            <div class="flex items-center gap-4">
                <img src="{{ asset('storage/'.$anime->cover) }}" class="w-20 h-28 object-cover rounded-lg border border-white/10">
                <div class="flex-1">
                    <input type="file" name="cover" accept="image/*" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500">
                    <p class="text-xs text-neutral-500 mt-1">Biarkan kosong jika tidak ingin mengubah cover.</p>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 border-t border-white/5 pt-5">
            <a href="{{ route('admin.animes.index') }}" class="px-6 py-2 rounded-xl text-neutral-400 hover:text-white transition-colors">Batal</a>
            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-xl font-bold shadow-lg shadow-purple-900/20">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection