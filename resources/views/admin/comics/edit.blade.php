@extends('layouts.admin')

@section('title', 'Edit Komik')
@section('header_title', 'Edit Data Komik')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-neutral-900 border border-white/5 rounded-2xl p-8 shadow-xl">
        
        <form action="{{ route('admin.comics.update', $comic->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-bold text-neutral-300 mb-2">Judul Komik</label>
                <input type="text" name="title" value="{{ old('title', $comic->title) }}" 
                       class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Tipe</label>
                    <select name="type" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none appearance-none cursor-pointer">
                        <option value="Manga" {{ $comic->type == 'Manga' ? 'selected' : '' }}>🇯🇵 Manga</option>
                        <option value="Manhwa" {{ $comic->type == 'Manhwa' ? 'selected' : '' }}>🇰🇷 Manhwa</option>
                        <option value="Manhua" {{ $comic->type == 'Manhua' ? 'selected' : '' }}>🇨🇳 Manhua</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Status</label>
                    <select name="status" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none appearance-none cursor-pointer">
                        <option value="Ongoing" {{ $comic->status == 'Ongoing' ? 'selected' : '' }}>🟢 Ongoing</option>
                        <option value="Finished" {{ $comic->status == 'Finished' ? 'selected' : '' }}>🔵 Finished</option>
                        <option value="Hiatus" {{ $comic->status == 'Hiatus' ? 'selected' : '' }}>🟡 Hiatus</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-neutral-300 mb-3">Genre</label>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 bg-neutral-950 p-4 rounded-xl border border-white/5 max-h-60 overflow-y-auto custom-scrollbar">
                    @foreach($genres as $genre)
                    <label class="flex items-center gap-3 p-2 rounded-lg hover:bg-white/5 cursor-pointer transition-colors">
                        <div class="relative flex items-center">
                            <input type="checkbox" name="genres[]" value="{{ $genre->id }}" 
                                   {{ $comic->genres->contains($genre->id) ? 'checked' : '' }}
                                   class="peer appearance-none w-5 h-5 border border-white/20 rounded bg-neutral-900 checked:bg-purple-600 checked:border-purple-600 transition-all">
                            <i data-lucide="check" class="absolute inset-0 m-auto w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100 pointer-events-none"></i>
                        </div>
                        <span class="text-sm text-neutral-400 peer-checked:text-white">{{ $genre->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-neutral-300 mb-2">Sinopsis</label>
                <textarea name="description" rows="4" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none custom-scrollbar">{{ old('description', $comic->description) }}</textarea>
            </div>

            <div class="flex gap-6 items-start bg-neutral-950 p-4 rounded-xl border border-white/5">
                <div class="shrink-0">
                    <p class="text-xs font-bold text-neutral-500 mb-2 uppercase">Cover Saat Ini</p>
                    @if($comic->cover)
                        <img src="{{ Str::startsWith($comic->cover, 'http') ? $comic->cover : asset('storage/' . $comic->cover) }}" class="w-24 h-32 object-cover rounded-lg border border-white/10">
                    @else
                        <div class="w-24 h-32 bg-neutral-800 rounded-lg flex items-center justify-center text-xs text-neutral-500 border border-white/10">No Cover</div>
                    @endif
                </div>
                
                <div class="flex-1">
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Ganti Cover (Opsional)</label>
                    <input type="file" name="cover" class="block w-full text-sm text-neutral-400
                        file:mr-4 file:py-2.5 file:px-4
                        file:rounded-full file:border-0
                        file:text-sm file:font-bold
                        file:bg-purple-600 file:text-white
                        hover:file:bg-purple-700
                        cursor-pointer bg-neutral-900 rounded-xl border border-white/10" accept="image/*">
                    <p class="text-xs text-neutral-500 mt-2">Biarkan kosong jika tidak ingin mengubah cover.</p>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-4 border-t border-white/5">
                <a href="{{ route('admin.comics.index') }}" class="px-6 py-2.5 rounded-xl text-sm font-bold text-neutral-400 hover:text-white hover:bg-white/5 transition-colors">Batal</a>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-2.5 rounded-xl font-bold shadow-lg shadow-purple-900/20 transition-all flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i> Update Komik
                </button>
            </div>
        </form>
    </div>
</div>
@endsection