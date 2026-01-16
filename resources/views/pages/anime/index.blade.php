@extends('layouts.app')

@section('title', 'Nonton Anime Sub Indo')

@section('content')
<div class="relative bg-neutral-900 border-b border-white/5 overflow-hidden">
    <div class="absolute inset-0 bg-red-600/10 blur-[100px] pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-4 py-16 relative z-10 text-center">
        <span class="text-red-500 font-bold tracking-widest text-xs uppercase mb-2 block">Komikin Anime Station</span>
        <h1 class="text-4xl md:text-6xl font-black text-white mb-4">
            STREAMING <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-orange-500">ANIME</span> GRATIS
        </h1>
        <p class="text-neutral-400 max-w-2xl mx-auto">
            Nikmati ribuan episode anime terbaru langsung dari server Youtube. Cepat, Hemat Kuota, dan Legal.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-12">
    <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
        <i data-lucide="play-circle" class="w-6 h-6 text-red-500"></i> Episode Terbaru
    </h2>
    
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach($latestEpisodes as $ep)
            <a href="{{ route('anime.watch', [$ep->anime->slug, $ep->episode_number]) }}" class="group relative aspect-[3/4] rounded-xl overflow-hidden bg-neutral-800 border border-white/5">
                <img src="{{ $ep->anime->cover ? asset('storage/'.$ep->anime->cover) : 'https://via.placeholder.com/300' }}" 
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>
                
                <div class="absolute bottom-0 p-3 w-full">
                    <div class="bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded w-fit mb-1">
                        EP {{ $ep->episode_number }}
                    </div>
                    <h3 class="text-white text-sm font-bold truncate">{{ $ep->anime->title }}</h3>
                </div>
                
                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <div class="w-12 h-12 bg-red-600 rounded-full flex items-center justify-center shadow-lg shadow-red-900/50">
                        <i data-lucide="play" class="w-6 h-6 text-white fill-current ml-1"></i>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    <h2 class="text-2xl font-bold text-white mb-6 mt-16 flex items-center gap-2">
        <i data-lucide="grid" class="w-6 h-6 text-red-500"></i> Daftar Anime
    </h2>
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
        @foreach($animes as $anime)
            <a href="{{ route('anime.show', $anime->slug) }}" class="group">
                <div class="aspect-[3/4] rounded-xl overflow-hidden mb-3 border border-white/5 relative">
                    <img src="{{ asset('storage/'.$anime->cover) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                    <div class="absolute top-2 right-2 bg-black/60 backdrop-blur px-2 py-0.5 rounded text-[10px] text-white font-bold border border-white/10">
                        {{ $anime->status }}
                    </div>
                </div>
                <h3 class="text-white font-bold text-sm truncate group-hover:text-red-500 transition-colors">{{ $anime->title }}</h3>
                <p class="text-neutral-500 text-xs">{{ $anime->release_year }} • {{ $anime->studio }}</p>
            </a>
        @endforeach
    </div>
</div>
@endsection