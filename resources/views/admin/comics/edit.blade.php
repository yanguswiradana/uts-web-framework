@extends('layouts.admin')

@section('title', 'Edit Komik')
@section('header_title', 'Edit Data Komik')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-neutral-900 border border-white/5 rounded-2xl p-8 shadow-xl">
        
        <form action="{{ route('admin.comics.update', $comic->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Judul Komik <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $comic->title) }}" required 
                           class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-neutral-300 mb-2">Penulis <span class="text-red-500">*</span></label>
                        <input type="text" name="author" value="{{ old('author', $comic->author) }}" required 
                               class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-neutral-300 mb-2">Tipe <span class="text-red-500">*</span></label>
                        <select name="type" required class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none">
                            <option value="Manga" {{ $comic->type == 'Manga' ? 'selected' : '' }}>Manga</option>
                            <option value="Manhwa" {{ $comic->type == 'Manhwa' ? 'selected' : '' }}>Manhwa</option>
                            <option value="Manhua" {{ $comic->type == 'Manhua' ? 'selected' : '' }}>Manhua</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-neutral-300 mb-2">Status <span class="text-red-500">*</span></label>
                        <select name="status" required class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none">
                            <option value="Ongoing" {{ $comic->status == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                            <option value="Completed" {{ $comic->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-neutral-300 mb-2">Ganti Cover (Opsional)</label>
                        <div class="flex items-center gap-4">
                            <img src="{{ Str::startsWith($comic->cover, 'http') ? $comic->cover : asset('storage/' . $comic->cover) }}" class="w-16 h-20 object-cover rounded-lg border border-white/10">
                            <input type="file" name="cover" accept="image/*" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none">
                        </div>
                    </div>
                </div>
            </div>

            <hr class="border-white/5">

            <div>
                <label class="block text-sm font-bold text-neutral-300 mb-4">Genre Komik <span class="text-red-500">*</span></label>
                
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                    @foreach($genres as $genre)
                        <label class="cursor-pointer group relative">
                            <input type="checkbox" name="genres[]" value="{{ $genre->id }}" class="peer sr-only"
                                   {{ $comic->genres->contains($genre->id) ? 'checked' : '' }}>
                            
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
                <textarea name="description" rows="5" required class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none">{{ old('description', $comic->description) }}</textarea>
            </div>

            <div class="flex justify-end gap-4 pt-4">
                <a href="{{ route('admin.comics.index') }}" class="px-6 py-2.5 rounded-xl text-neutral-400 hover:text-white font-bold transition-colors">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-xl font-bold shadow-lg shadow-blue-900/20 transition-all flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i> Update Komik
                </button>
            </div>

        </form>
    </div>
</div>
@endsection