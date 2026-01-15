@extends('layouts.app')

@section('title', 'Jelajah Komik - KOMIKIN')

@section('content')

    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2 flex items-center gap-2">
                <i data-lucide="compass" class="w-8 h-8 text-purple-500"></i> Jelajah Komik
            </h1>
            <p class="text-neutral-400 text-sm">Temukan bacaan baru dari ribuan koleksi kami.</p>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-8 items-start">
        
        <aside class="w-full lg:w-1/4 lg:sticky lg:top-24 space-y-6">
            
            <div class="bg-neutral-900 border border-white/5 rounded-2xl p-6 shadow-xl">
                <div class="flex items-center gap-2 mb-6 border-b border-white/5 pb-4">
                    <i data-lucide="sliders-horizontal" class="w-5 h-5 text-purple-500"></i>
                    <h3 class="font-bold text-white">Filter Pencarian</h3>
                </div>

                <form action="{{ route('explore.index') }}" method="GET">
                    <div class="mb-6">
                        <label class="block text-xs font-bold text-neutral-500 uppercase mb-2">Kata Kunci</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Judul komik..." 
                                   class="w-full bg-neutral-950 border border-white/10 rounded-xl py-3 pl-10 pr-4 text-sm text-white focus:border-purple-500 focus:outline-none transition-colors placeholder:text-neutral-700">
                            <i data-lucide="search" class="absolute left-3.5 top-3.5 w-4 h-4 text-neutral-500"></i>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs font-bold text-neutral-500 uppercase mb-2">Status</label>
                        <div class="relative">
                            <select name="status" class="w-full bg-neutral-950 border border-white/10 rounded-xl py-3 px-4 text-sm text-white focus:border-purple-500 focus:outline-none appearance-none cursor-pointer">
                                <option value="Semua">Semua Status</option>
                                <option value="Ongoing" {{ request('status') == 'Ongoing' ? 'selected' : '' }}>Ongoing (Berlanjut)</option>
                                <option value="Finished" {{ request('status') == 'Finished' ? 'selected' : '' }}>Finished (Tamat)</option>
                            </select>
                            <i data-lucide="chevron-down" class="absolute right-4 top-3.5 w-4 h-4 text-neutral-500 pointer-events-none"></i>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs font-bold text-neutral-500 uppercase mb-2">Urutkan</label>
                        <div class="relative">
                            <select name="sort" class="w-full bg-neutral-950 border border-white/10 rounded-xl py-3 px-4 text-sm text-white focus:border-purple-500 focus:outline-none appearance-none cursor-pointer">
                                <option value="Terbaru" {{ request('sort') == 'Terbaru' ? 'selected' : '' }}>Update Terbaru</option>
                                <option value="A-Z" {{ request('sort') == 'A-Z' ? 'selected' : '' }}>Abjad A-Z</option>
                                <option value="Populer (All Time)" {{ request('sort') == 'Populer (All Time)' ? 'selected' : '' }}>Paling Populer</option>
                            </select>
                            <i data-lucide="arrow-up-down" class="absolute right-4 top-3.5 w-4 h-4 text-neutral-500 pointer-events-none"></i>
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="block text-xs font-bold text-neutral-500 uppercase mb-3">Genre</label>
                        <div class="max-h-48 overflow-y-auto pr-2 space-y-2 custom-scrollbar">
                            @foreach($allGenres as $genre)
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <div class="relative flex items-center">
                                    <input type="checkbox" name="genre[]" value="{{ $genre }}" 
                                           class="peer appearance-none w-5 h-5 border border-white/20 rounded bg-neutral-950 checked:bg-purple-600 checked:border-purple-600 transition-colors"
                                           {{ in_array($genre, request('genre', [])) ? 'checked' : '' }}>
                                    <i data-lucide="check" class="absolute inset-0 w-3.5 h-3.5 text-white m-auto opacity-0 peer-checked:opacity-100 pointer-events-none"></i>
                                </div>
                                <span class="text-sm text-neutral-400 group-hover:text-white transition-colors select-none">{{ $genre }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-purple-900/20 flex items-center justify-center gap-2">
                        <i data-lucide="filter" class="w-4 h-4"></i> Terapkan Filter
                    </button>
                    
                    @if(request()->hasAny(['search', 'status', 'genre', 'sort']))
                    <a href="{{ route('explore.index') }}" class="block text-center mt-4 text-xs text-neutral-500 hover:text-white transition-colors">
                        Reset Filter
                    </a>
                    @endif
                </form>
            </div>
        </aside>

        <div class="flex-1 w-full">
            
            <div class="mb-6 flex items-center gap-2 text-sm text-neutral-400 bg-neutral-900/50 py-2 px-4 rounded-lg border border-white/5 w-fit">
                <span>Menampilkan</span>
                <span class="font-bold text-white">{{ $paginatedComics->count() }}</span>
                <span>dari</span>
                <span class="font-bold text-white">{{ $paginatedComics->total() }}</span>
                <span>Komik</span>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 xl:grid-cols-4 gap-5">
                @forelse($paginatedComics as $comic)
                    <x-comic-card-home :comic="$comic" />
                @empty
                    <div class="col-span-full py-20 text-center">
                        <div class="w-20 h-20 bg-neutral-900 rounded-full flex items-center justify-center mx-auto mb-4 border border-white/5">
                            <i data-lucide="search-x" class="w-10 h-10 text-neutral-600"></i>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-1">Tidak Ditemukan</h3>
                        <p class="text-neutral-500 text-sm">Coba kurangi filter atau cari kata kunci lain.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-10">
                {{ $paginatedComics->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
@endsection