@extends('layouts.app')

@section('title', $anime->title)

@section('content')

    <div class="relative bg-neutral-900 border border-white/5 rounded-3xl p-6 md:p-10 mb-10 overflow-hidden shadow-2xl">
        
        <div class="absolute top-0 right-0 w-96 h-96 bg-red-600/20 rounded-full blur-[100px] -mr-20 -mt-20 pointer-events-none"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row gap-8 md:gap-12">
            
            <div class="w-full md:w-72 shrink-0 group">
                <div class="aspect-[2/3] rounded-2xl overflow-hidden shadow-2xl border border-white/10 relative">
                    <img src="{{ Str::startsWith($anime->cover, 'http') ? $anime->cover : asset('storage/' . $anime->cover) }}" 
                         alt="{{ $anime->title }}" 
                         class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                    
                    <div class="absolute top-3 right-3 px-3 py-1 rounded-full text-xs font-bold backdrop-blur-md border border-white/20 
                        {{ $anime->status == 'Ongoing' ? 'bg-green-500/80 text-white' : 'bg-blue-500/80 text-white' }}">
                        {{ $anime->status }}
                    </div>
                </div>
            </div>

            <div class="flex-1 flex flex-col">
                <div class="mb-4">
                    <span class="text-red-500 font-bold tracking-wider text-xs uppercase mb-2 block flex items-center gap-2">
                        <i data-lucide="clapperboard" class="w-3 h-3"></i>
                        STUDIO: {{ $anime->studio }}
                    </span>
                    
                    <h1 class="text-3xl md:text-5xl font-bold text-white leading-tight mb-2">{{ $anime->title }}</h1>
                    
                    <div class="flex items-center gap-2 text-neutral-400 text-sm mb-6">
                        <i data-lucide="calendar" class="w-4 h-4 text-neutral-500"></i>
                        <span class="font-medium">Rilis Tahun: <span class="text-white">{{ $anime->release_year }}</span></span>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 border-y border-white/5 py-6 mb-6">
                    <div>
                        <p class="text-neutral-500 text-xs uppercase font-bold mb-1">Total Episode</p>
                        <p class="text-white font-bold text-lg">{{ $anime->episodes->count() }} Eps</p>
                    </div>
                    
                    <div>
                        <p class="text-neutral-500 text-xs uppercase font-bold mb-1">Status</p>
                        <p class="text-white font-bold text-lg">{{ $anime->status }}</p>
                    </div>

                    <div>
                        <p class="text-neutral-500 text-xs uppercase font-bold mb-1">Format</p>
                        <p class="text-white font-bold text-lg">TV / Series</p>
                    </div>
                </div>

                <div class="mb-8 flex-1">
                    <h3 class="text-white font-bold mb-2 flex items-center gap-2">
                        <i data-lucide="align-left" class="w-4 h-4 text-red-500"></i> Sinopsis
                    </h3>
                    <p class="text-neutral-400 text-sm leading-relaxed whitespace-pre-line">
                        {{ $anime->description ?? 'Belum ada sinopsis untuk anime ini.' }}
                    </p>
                </div>

                <div class="flex gap-3 mt-auto">
                    @if($anime->episodes->count() > 0)
                        <a href="{{ route('anime.watch', [$anime->slug, $anime->episodes->sortBy('episode_number')->first()->episode_number]) }}" 
                           class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3.5 px-6 rounded-xl shadow-lg shadow-red-900/40 transition-all flex items-center justify-center gap-2 hover:-translate-y-0.5">
                            <i data-lucide="play-circle" class="w-6 h-6 fill-current"></i>
                            <span>Mulai Nonton</span>
                        </a>
                    @else
                        <button disabled class="flex-1 bg-neutral-800 text-neutral-500 font-bold py-3.5 px-6 rounded-xl cursor-not-allowed flex items-center justify-center gap-2">
                            <i data-lucide="clock" class="w-5 h-5"></i>
                            <span>Segera Tayang</span>
                        </button>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-white flex items-center gap-2">
            <i data-lucide="list-video" class="w-6 h-6 text-red-500"></i> Daftar Episode
        </h2>
        
        <div class="relative hidden sm:block">
            <input type="text" placeholder="Cari episode..." class="bg-neutral-900 border border-white/10 rounded-full py-2 pl-9 pr-4 text-sm focus:outline-none focus:border-red-500 w-48 transition-all focus:w-64 text-white">
            <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-neutral-500"></i>
        </div>
    </div>

    <div class="bg-neutral-900 border border-white/5 rounded-2xl overflow-hidden shadow-xl">
        <div class="max-h-[600px] overflow-y-auto custom-scrollbar p-2">
            @if($anime->episodes->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    @foreach($anime->episodes as $ep)
                        <a href="{{ route('anime.watch', [$anime->slug, $ep->episode_number]) }}" 
                           class="group flex items-center justify-between p-4 rounded-xl bg-neutral-950 border border-white/5 hover:border-red-500/50 hover:bg-white/5 transition-all">
                            
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-lg bg-neutral-800 flex items-center justify-center text-neutral-500 group-hover:bg-red-600 group-hover:text-white transition-colors relative overflow-hidden">
                                    <span class="font-bold text-sm relative z-10">{{ $ep->episode_number }}</span>
                                    <i data-lucide="play" class="absolute w-8 h-8 opacity-10 -right-2 -bottom-2 group-hover:opacity-20"></i>
                                </div>
                                
                                <div>
                                    <h4 class="text-white font-medium text-sm group-hover:text-red-400 transition-colors">
                                        Episode {{ $ep->episode_number }}
                                    </h4>
                                    <p class="text-xs text-neutral-500 mt-0.5">
                                        {{ $ep->title ? $ep->title : 'Tanpa Judul' }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                <span class="text-[10px] text-neutral-600 border border-white/5 px-2 py-1 rounded bg-black/20">
                                    {{ $ep->created_at->format('d M') }}
                                </span>
                                <i data-lucide="chevron-right" class="w-5 h-5 text-neutral-600 group-hover:text-white transition-colors"></i>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="py-12 text-center">
                    <div class="w-16 h-16 bg-neutral-800 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="film" class="w-8 h-8 text-neutral-600"></i>
                    </div>
                    <p class="text-neutral-500">Belum ada episode yang diupload.</p>
                </div>
            @endif
        </div>
    </div>

    <div class="mb-20"></div>

@endsection