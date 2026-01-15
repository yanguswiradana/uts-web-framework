@extends('layouts.admin')

@section('title', 'Edit Komik')
@section('header_title', 'Edit Data Komik')

@section('content')
<div class="max-w-4xl mx-auto">
    
    <a href="{{ route('admin.comics.index') }}" class="inline-flex items-center text-neutral-400 hover:text-white mb-6 transition-colors text-sm">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i> Batal & Kembali
    </a>

    <div class="bg-neutral-900 border border-white/5 rounded-2xl p-6 md:p-8 shadow-xl">
        <form action="{{ route('admin.comics.update', $comic->id) }}" method="POST">
            @csrf
            @method('PUT') <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="col-span-2">
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Judul Komik</label>
                    <input type="text" name="title" value="{{ old('title', $comic->title) }}" 
                           class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-yellow-500 transition-all" 
                           required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $comic->slug) }}" 
                           class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-yellow-500 transition-all" 
                           required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Penulis</label>
                    <input type="text" name="author" value="{{ old('author', $comic->author) }}" 
                           class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-yellow-500 transition-all" 
                           required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Tipe</label>
                    <div class="relative">
                        <select name="type" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-yellow-500 appearance-none cursor-pointer">
                            <option value="Manga" {{ $comic->type == 'Manga' ? 'selected' : '' }}>Manga</option>
                            <option value="Manhwa" {{ $comic->type == 'Manhwa' ? 'selected' : '' }}>Manhwa</option>
                            <option value="Manhua" {{ $comic->type == 'Manhua' ? 'selected' : '' }}>Manhua</option>
                        </select>
                        <i data-lucide="chevron-down" class="absolute right-4 top-3.5 w-5 h-5 text-neutral-500 pointer-events-none"></i>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Status</label>
                    <div class="relative">
                        <select name="status" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-yellow-500 appearance-none cursor-pointer">
                            <option value="Ongoing" {{ $comic->status == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                            <option value="Finished" {{ $comic->status == 'Finished' ? 'selected' : '' }}>Finished</option>
                            <option value="Hiatus" {{ $comic->status == 'Hiatus' ? 'selected' : '' }}>Hiatus</option>
                        </select>
                        <i data-lucide="chevron-down" class="absolute right-4 top-3.5 w-5 h-5 text-neutral-500 pointer-events-none"></i>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-bold text-neutral-300 mb-3">Update Genre</label>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 bg-neutral-950 p-4 rounded-xl border border-white/5">
                    @foreach($genres as $genre)
                    <label class="relative flex items-center group cursor-pointer">
                        <input type="checkbox" name="genres[]" value="{{ $genre->id }}" class="peer sr-only"
                            {{-- LOGIKA CHECKED: Cek apakah ID genre ada di list genre komik ini --}}
                            {{ $comic->genres->contains($genre->id) ? 'checked' : '' }}>
                        
                        <div class="w-full px-4 py-2 rounded-lg border border-white/10 bg-neutral-900 text-neutral-400 text-sm font-medium transition-all
                                    peer-checked:bg-yellow-600 peer-checked:text-white peer-checked:border-yellow-500 peer-checked:shadow-lg peer-checked:shadow-yellow-900/50
                                    group-hover:border-yellow-500/50">
                            {{ $genre->name }}
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center justify-end pt-6 border-t border-white/5">
                <button type="submit" class="bg-yellow-600 hover:bg-yellow-500 text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-yellow-900/30 transition-all transform hover:-translate-y-0.5">
                    Update Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection