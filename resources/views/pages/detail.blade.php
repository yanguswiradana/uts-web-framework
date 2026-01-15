@extends('layouts.app')

@section('title', $comic->title . ' - KOMIKIN')

@section('content')

    <div class="absolute top-0 left-0 w-full h-[600px] overflow-hidden -z-10">
        <div class="absolute inset-0 bg-gradient-to-b from-neutral-950/30 via-neutral-950/90 to-neutral-950"></div>
        <img src="{{ Str::startsWith($comic->cover, 'http') ? $comic->cover : asset('storage/' . $comic->cover) }}" 
             class="w-full h-full object-cover blur-3xl opacity-30">
    </div>

    <div class="flex flex-col md:flex-row gap-10 items-start mt-10">
        
        <div class="w-full md:w-[300px] shrink-0 sticky top-24">
            <div class="rounded-2xl overflow-hidden shadow-2xl border border-white/10 group relative">
                <img src="{{ Str::startsWith($comic->cover, 'http') ? $comic->cover : asset('storage/' . $comic->cover) }}" 
                     alt="{{ $comic->title }}" 
                     class="w-full h-auto object-cover">
                
                <div class="absolute top-3 right-3">
                    <span class="px-3 py-1 rounded-full text-xs font-bold backdrop-blur-md border border-white/20 shadow-lg
                        {{ $comic->status == 'Ongoing' ? 'bg-green-500/20 text-green-400' : 'bg-blue-500/20 text-blue-400' }}">
                        {{ $comic->status }}
                    </span>
                </div>
            </div>

            <div class="md:hidden mt-6 flex gap-3">
                @php $firstCh = $chapters->sortBy('number')->first(); @endphp
                @if($firstCh)
                <a href="{{ route('komik.read', [$comic->slug, $firstCh->number]) }}" class="flex-1 bg-purple-600 text-white py-3 rounded-xl font-bold text-center">Baca</a>
                @endif
            </div>
        </div>

        <div class="flex-1 min-w-0">
            <h1 class="text-3xl md:text-5xl font-bold text-white mb-2 leading-tight">{{ $comic->title }}</h1>
            <div class="flex flex-wrap items-center gap-4 text-sm text-neutral-400 mb-6">
                <span class="flex items-center gap-1.5"><i data-lucide="pen-tool" class="w-4 h-4"></i> {{ $comic->author }}</span>
                <span class="w-1 h-1 rounded-full bg-neutral-600"></span>
                <span class="flex items-center gap-1.5"><i data-lucide="book-open" class="w-4 h-4"></i> {{ $comic->type }}</span>
                <span class="w-1 h-1 rounded-full bg-neutral-600"></span>
                <span class="text-yellow-500 flex items-center gap-1"><i data-lucide="star" class="w-4 h-4 fill-yellow-500"></i> 4.8</span>
            </div>

            <div class="flex flex-wrap gap-2 mb-8">
                @foreach($comic->genres as $genre)
                    <a href="{{ route('explore.index', ['genre[]' => $genre->name]) }}" 
                       class="px-3 py-1.5 rounded-lg text-xs font-medium bg-white/5 hover:bg-purple-600 hover:text-white border border-white/5 transition-all text-neutral-300">
                        {{ $genre->name }}
                    </a>
                @endforeach
            </div>

            <div class="hidden md:flex flex-wrap gap-4 mb-10">
                @php $firstCh = $chapters->sortBy('number')->first(); @endphp
                
                @if($firstCh)
                <a href="{{ route('komik.read', [$comic->slug, $firstCh->number]) }}" 
                   class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-3.5 rounded-xl font-bold transition-all shadow-lg shadow-purple-900/30 flex items-center gap-2 hover:scale-105">
                    <i data-lucide="book-open-check" class="w-5 h-5"></i> Mulai Baca Ch. {{ $firstCh->number }}
                </a>
                @endif

                <button class="bg-neutral-800 hover:bg-neutral-700 text-white px-6 py-3.5 rounded-xl font-bold transition-all border border-white/5 flex items-center gap-2">
                    <i data-lucide="bookmark" class="w-5 h-5"></i> Bookmark
                </button>
            </div>

            <div class="bg-neutral-900 border border-white/5 rounded-2xl p-6 mb-10">
                <h3 class="text-lg font-bold text-white mb-3 flex items-center gap-2">
                    <i data-lucide="align-left" class="w-5 h-5 text-purple-500"></i> Sinopsis
                </h3>
                <p class="text-neutral-400 leading-relaxed text-sm md:text-base">
                    {{ $comic->description ?? 'Tidak ada deskripsi.' }}
                </p>
            </div>

            <div class="mb-10">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-white">Chapter List</h3>
                    
                    <div class="relative">
                        <input type="text" placeholder="Cari Ch..." class="bg-neutral-900 border border-white/10 rounded-lg py-1.5 pl-8 pr-3 text-xs text-white focus:border-purple-500 focus:outline-none w-32">
                        <i data-lucide="search" class="absolute left-2.5 top-2 w-3 h-3 text-neutral-500"></i>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-[500px] overflow-y-auto pr-2 custom-scrollbar">
                    @foreach($chapters as $chapter)
                    <a href="{{ route('komik.read', [$comic->slug, $chapter->number]) }}" 
                       class="group flex items-center justify-between p-4 rounded-xl bg-neutral-900 border border-white/5 hover:border-purple-500/50 hover:bg-neutral-800 transition-all">
                        
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-neutral-800 flex items-center justify-center text-neutral-500 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                                <span class="text-xs font-bold">{{ $chapter->number }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-white group-hover:text-purple-400 transition-colors">Chapter {{ $chapter->number }}</p>
                                <p class="text-[10px] text-neutral-500">{{ $chapter->created_at->format('d M Y') }}</p>
                            </div>
                        </div>

                        <i data-lucide="chevron-right" class="w-4 h-4 text-neutral-600 group-hover:text-white"></i>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection