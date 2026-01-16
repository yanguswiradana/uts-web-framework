@extends('layouts.admin')
@section('title', 'Edit Episode')
@section('header_title', 'Edit Data Episode')

@section('content')
<div class="max-w-3xl mx-auto bg-neutral-900 border border-white/5 p-8 rounded-2xl shadow-xl">
    <form action="{{ route('admin.anime_episodes.update', $animeEpisode->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div>
            <label class="block text-sm font-bold text-neutral-300 mb-2">Pilih Anime</label>
            <select name="anime_id" class="w-full bg-neutral-950 border border-white/10 rounded-xl p-3 text-white focus:outline-none focus:border-red-500">
                @foreach($animes as $anime)
                    <option value="{{ $anime->id }}" {{ $animeEpisode->anime_id == $anime->id ? 'selected' : '' }}>
                        {{ $anime->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-neutral-300 mb-2">Episode Ke-</label>
            <input type="number" name="episode_number" value="{{ old('episode_number', $animeEpisode->episode_number) }}" class="w-full bg-neutral-950 border border-white/10 rounded-xl p-3 text-white focus:outline-none focus:border-red-500" required>
        </div>

        <div>
            <label class="block text-sm font-bold text-neutral-300 mb-2">Judul Episode (Opsional)</label>
            <input type="text" name="title" value="{{ old('title', $animeEpisode->title) }}" class="w-full bg-neutral-950 border border-white/10 rounded-xl p-3 text-white focus:outline-none focus:border-red-500">
        </div>

        <div>
            <label class="block text-sm font-bold text-neutral-300 mb-2">Link Youtube</label>
            <input type="url" name="youtube_link" value="{{ old('youtube_link', $animeEpisode->youtube_link) }}" class="w-full bg-neutral-950 border border-white/10 rounded-xl p-3 text-white focus:outline-none focus:border-red-500" required>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-white/5">
            <a href="{{ route('admin.anime_episodes.index') }}" class="px-6 py-2 rounded-xl text-neutral-400 hover:text-white transition-colors">Batal</a>
            <button class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-xl font-bold shadow-lg shadow-red-900/20">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection