@extends('layouts.app')

@section('title', 'Beranda - KOMIKIN')

@section('content')

    <div class="relative rounded-3xl overflow-hidden bg-neutral-900 border border-white/5 mb-12 p-8 md:p-12 shadow-2xl">
        <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-purple-600/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-80 h-80 bg-indigo-600/20 rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="relative z-10 max-w-2xl">
            <div class="inline-block px-3 py-1 mb-4 text-xs font-bold tracking-wider text-purple-300 uppercase bg-purple-500/10 rounded-full border border-purple-500/20">
                Welcome to Komikin
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 leading-tight">
                Baca Komik Favoritmu <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400">Tanpa Batas</span>
            </h1>
            <p class="text-neutral-400 text-lg mb-8 max-w-lg">
                Platform baca Manga, Manhwa, dan Manhua terlengkap dengan update tercepat dan kualitas gambar HD.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('explore.index') }}" class="inline-flex items-center gap-2 bg-white text-neutral-950 font-bold px-6 py-3 rounded-full hover:bg-neutral-200 transition-colors shadow-lg shadow-white/10">
                    Mulai Jelajah <i data-lucide="compass" class="w-4 h-4"></i>
                </a>
            </div>
        </div>
    </div>

    <section class="mb-16">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                <i data-lucide="zap" class="w-6 h-6 text-yellow-500 fill-yellow-500"></i> 
                Update Terbaru
            </h2>
            <a href="{{ route('explore.index') }}" class="text-sm font-medium text-neutral-500 hover:text-white transition-colors flex items-center gap-1">
                Lihat Semua <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-5">
            @foreach ($latestUpdates as $comic)
                <x-comic-card-home :comic="$comic" />
            @endforeach
        </div>
    </section>

    <section x-data="{ activeTab: 'manhwa' }" class="min-h-[500px]">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
            <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                <i data-lucide="layers" class="w-6 h-6 text-purple-500"></i> 
                Koleksi Populer
            </h2>

            <div class="flex items-center gap-2 overflow-x-auto pb-2 md:pb-0">
                <button @click="activeTab = 'manhwa'" 
                        :class="activeTab === 'manhwa' ? 'bg-purple-600 text-white shadow-lg shadow-purple-500/25 border-purple-500' : 'bg-neutral-900 text-neutral-400 border-white/10 hover:bg-neutral-800 hover:text-white'"
                        class="px-5 py-2 text-sm font-bold rounded-full border transition-all whitespace-nowrap flex items-center gap-2">
                    🇰🇷 Manhwa
                </button>
                <button @click="activeTab = 'manga'" 
                        :class="activeTab === 'manga' ? 'bg-purple-600 text-white shadow-lg shadow-purple-500/25 border-purple-500' : 'bg-neutral-900 text-neutral-400 border-white/10 hover:bg-neutral-800 hover:text-white'"
                        class="px-5 py-2 text-sm font-bold rounded-full border transition-all whitespace-nowrap flex items-center gap-2">
                    🇯🇵 Manga
                </button>
                <button @click="activeTab = 'manhua'" 
                        :class="activeTab === 'manhua' ? 'bg-purple-600 text-white shadow-lg shadow-purple-500/25 border-purple-500' : 'bg-neutral-900 text-neutral-400 border-white/10 hover:bg-neutral-800 hover:text-white'"
                        class="px-5 py-2 text-sm font-bold rounded-full border transition-all whitespace-nowrap flex items-center gap-2">
                    🇨🇳 Manhua
                </button>
            </div>
        </div>

        <div x-show="activeTab === 'manhwa'" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-5">
            @forelse($manhwa as $comic)
                <x-comic-card-home :comic="$comic" flag="🇰🇷" />
            @empty
                <div class="col-span-full py-20 text-center text-neutral-500 bg-neutral-900/50 rounded-2xl border border-white/5 border-dashed">
                    <p>Belum ada data Manhwa.</p>
                </div>
            @endforelse
        </div>
        
        <div x-show="activeTab === 'manga'" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-5" style="display: none;">
            @forelse($manga as $comic)
                <x-comic-card-home :comic="$comic" flag="🇯🇵" />
            @empty
                <div class="col-span-full py-20 text-center text-neutral-500 bg-neutral-900/50 rounded-2xl border border-white/5 border-dashed">
                    <p>Belum ada data Manga.</p>
                </div>
            @endforelse
        </div>

        <div x-show="activeTab === 'manhua'" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-5" style="display: none;">
            @forelse($manhua as $comic)
                <x-comic-card-home :comic="$comic" flag="🇨🇳" />
            @empty
                <div class="col-span-full py-20 text-center text-neutral-500 bg-neutral-900/50 rounded-2xl border border-white/5 border-dashed">
                    <p>Belum ada data Manhua.</p>
                </div>
            @endforelse
        </div>
    </section>

    <div class="mb-20"></div>

@endsection