@extends('layouts.admin')
@section('title', 'Tambah Episode Anime')
@section('content')
<div class="max-w-3xl mx-auto bg-neutral-900 p-8 rounded-2xl border border-white/10">
    <form action="{{ route('admin.anime_episodes.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <div>
            <label class="block text-neutral-400 mb-2">Pilih Anime</label>
            <select name="anime_id" class="w-full bg-neutral-950 border border-white/10 rounded-xl p-3 text-white">
                @foreach($animes as $anime)
                    <option value="{{ $anime->id }}">{{ $anime->title }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-neutral-400 mb-2">Episode Ke-</label>
            <input type="number" name="episode_number" class="w-full bg-neutral-950 border border-white/10 rounded-xl p-3 text-white" required>
        </div>

        <div>
            <label class="block text-neutral-400 mb-2">Judul Episode (Opsional)</label>
            <input type="text" name="title" class="w-full bg-neutral-950 border border-white/10 rounded-xl p-3 text-white">
        </div>

        <div>
            <label class="block text-neutral-400 mb-2">Link Youtube</label>
            <input type="url" name="youtube_link" placeholder="https://www.youtube.com/watch?v=..." class="w-full bg-neutral-950 border border-white/10 rounded-xl p-3 text-white" required>
            <p class="text-xs text-neutral-500 mt-1">Copy paste link lengkap dari browser.</p>
        </div>

        <button class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-xl font-bold w-full">Simpan Episode</button>
    </form>
</div>
@endsection