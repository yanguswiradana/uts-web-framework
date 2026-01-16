@extends('layouts.app')

@section('title', 'Nonton ' . $anime->title . ' Episode ' . $currentEpisode->episode_number)

@section('content')
<div class="bg-black min-h-screen pb-20">
    
    <div class="w-full bg-neutral-900 border-b border-white/5">
        <div class="max-w-6xl mx-auto">
            <div class="relative aspect-video w-full bg-black shadow-2xl">
                <iframe 
                    class="absolute inset-0 w-full h-full"
                    src="https://www.youtube.com/embed/{{ $currentEpisode->youtube_id }}?autoplay=1&rel=0&modestbranding=1" 
                    title="YouTube video player" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen>
                </iframe>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row gap-8">
            
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-2">
                    <a href="{{ route('anime.index') }}" class="text-red-500 text-xs font-bold hover:underline">ANIME</a>
                    <span class="text-neutral-600 text-xs">•</span>
                    <a href="{{ route('anime.show', $anime->slug) }}" class="text-neutral-400 text-xs font-bold hover:text-white">{{ $anime->title }}</a>
                </div>
                
                <h1 class="text-2xl font-bold text-white mb-4">
                    Episode {{ $currentEpisode->episode_number }} 
                    @if($currentEpisode->title) <span class="text-neutral-500 font-normal">- {{ $currentEpisode->title }}</span> @endif
                </h1>

                <div class="flex gap-3 mb-8">
                    @if($prevEpisode)
                        <a href="{{ route('anime.watch', [$anime->slug, $prevEpisode->episode_number]) }}" class="px-6 py-3 rounded-lg bg-neutral-800 text-white font-bold hover:bg-neutral-700 transition-colors flex items-center gap-2">
                            <i data-lucide="skip-back" class="w-4 h-4"></i> Prev
                        </a>
                    @else
                        <button disabled class="px-6 py-3 rounded-lg bg-neutral-900 text-neutral-600 font-bold cursor-not-allowed">Prev</button>
                    @endif

                    @if($nextEpisode)
                        <a href="{{ route('anime.watch', [$anime->slug, $nextEpisode->episode_number]) }}" class="px-6 py-3 rounded-lg bg-red-600 text-white font-bold hover:bg-red-700 transition-colors flex items-center gap-2">
                            Next <i data-lucide="skip-forward" class="w-4 h-4"></i>
                        </a>
                    @endif
                </div>
            </div>

            <div class="w-full md:w-80 shrink-0">
                <div class="bg-neutral-900 border border-white/10 rounded-xl overflow-hidden">
                    <div class="p-4 border-b border-white/5 bg-neutral-800/50">
                        <h3 class="text-white font-bold text-sm">Daftar Episode</h3>
                    </div>
                    <div class="max-h-[400px] overflow-y-auto custom-scrollbar p-2">
                        @foreach($anime->episodes as $ep)
                            <a href="{{ route('anime.watch', [$anime->slug, $ep->episode_number]) }}" 
                               class="flex items-center gap-3 p-3 rounded-lg hover:bg-white/5 transition-colors {{ $ep->id == $currentEpisode->id ? 'bg-red-600/10 border border-red-500/30' : '' }}">
                                
                                <div class="w-8 h-8 rounded bg-neutral-800 flex items-center justify-center text-xs font-bold {{ $ep->id == $currentEpisode->id ? 'text-red-500' : 'text-neutral-400' }}">
                                    {{ $ep->episode_number }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium truncate {{ $ep->id == $currentEpisode->id ? 'text-red-400' : 'text-neutral-300' }}">
                                        Episode {{ $ep->episode_number }}
                                    </p>
                                </div>
                                @if($ep->id == $currentEpisode->id)
                                    <i data-lucide="bar-chart-2" class="w-4 h-4 text-red-500 animate-pulse"></i>
                                @else
                                    <i data-lucide="play" class="w-4 h-4 text-neutral-600"></i>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection