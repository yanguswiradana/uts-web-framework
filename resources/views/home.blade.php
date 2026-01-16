@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <div class="relative bg-neutral-900 border border-white/5 rounded-3xl p-8 md:p-12 mb-6 overflow-hidden shadow-2xl">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-purple-600/20 rounded-full blur-[120px] -mr-32 -mt-32 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-blue-600/10 rounded-full blur-[100px] -ml-20 -mb-20 pointer-events-none"></div>
        
        <div class="relative z-10 max-w-2xl">
            <span class="inline-block px-3 py-1 mb-4 text-xs font-bold tracking-wider text-purple-300 uppercase bg-purple-500/10 border border-purple-500/20 rounded-full">
                Platform Baca Komik Terbaik
            </span>
            <h1 class="text-4xl md:text-6xl font-extrabold text-white leading-tight mb-6">
                Jelajahi Dunia <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-500">Imajinasi</span>.
            </h1>
            <p class="text-lg text-neutral-400 mb-8 leading-relaxed">
                Baca ribuan Manga, Manhwa, dan Manhua favoritmu dengan update tercepat dan kualitas HD.
            </p>
            
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('explore.index') }}" class="px-8 py-3.5 bg-purple-600 hover:bg-purple-700 text-white font-bold rounded-xl shadow-lg shadow-purple-900/30 transition-all hover:-translate-y-1 flex items-center gap-2">
                    <i data-lucide="compass" class="w-5 h-5"></i>
                    Mulai Jelajah
                </a>
                @guest
                <a href="{{ route('register') }}" class="px-8 py-3.5 bg-neutral-800 hover:bg-neutral-700 text-white font-bold rounded-xl border border-white/5 transition-all hover:-translate-y-1 flex items-center gap-2">
                    <i data-lucide="user-plus" class="w-5 h-5"></i>
                    Daftar Akun
                </a>
                @endguest
            </div>
        </div>
    </div>

    <div class="py-8">
    <div class="relative rounded-3xl overflow-hidden border border-white/10 group">
        <div class="absolute inset-0 bg-[url('https://c4.wallpaperflare.com/wallpaper/295/163/719/anime-anime-boys-picture-in-picture-kimetsu-no-yaiba-kamado-tanjir%C5%8D-hd-wallpaper-preview.jpg')] bg-cover bg-center"></div>
        
        <div class="absolute inset-0 bg-gradient-to-r from-neutral-950 via-neutral-950/80 to-transparent"></div>
        
        <div class="relative z-10 p-8 md:p-12 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="max-w-xl">
                <span class="bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded mb-3 inline-block">FITUR BARU</span>
                <h2 class="text-3xl md:text-4xl font-black text-white mb-3 italic">BOSAN BACA KOMIK?</h2>
                <p class="text-neutral-300 text-sm md:text-base mb-6 leading-relaxed">
                    Sekarang kamu bisa nonton anime favorit langsung di Komikin! Streaming lancar via Youtube, update setiap hari.
                </p>
                
                <a href="{{ route('anime.index') }}" class="inline-flex items-center gap-2 bg-white text-neutral-950 px-6 py-3 rounded-xl font-bold hover:bg-neutral-200 transition-colors">
                    <i data-lucide="tv" class="w-5 h-5"></i>
                    Mulai Nonton Anime
                </a>
            </div>
            
            <div class="hidden md:block">
                <div class="w-24 h-24 rounded-full bg-red-600/20 border border-red-500/30 flex items-center justify-center animate-bounce">
                    <i data-lucide="play" class="w-10 h-10 text-red-500 fill-current ml-1"></i>
                </div>
            </div>
        </div>
    </div>
</div>

    <section class="mb-16" x-data="{ activeTab: 'Manga' }">
        
        <div class="flex flex-col md:flex-row items-center justify-between mb-6 gap-4">
            <h2 class="text-2xl font-bold text-white flex items-center gap-3">
                <i data-lucide="trophy" class="w-6 h-6 text-yellow-500"></i>
                Populer Saat Ini
            </h2>

            <div class="flex bg-neutral-900 p-1 rounded-xl border border-white/5">
                <button @click="activeTab = 'Manga'" 
                        :class="activeTab === 'Manga' ? 'bg-purple-600 text-white shadow-lg' : 'text-neutral-400 hover:text-white hover:bg-white/5'"
                        class="px-5 py-2 rounded-lg text-sm font-bold transition-all duration-300">
                    Manga
                </button>
                <button @click="activeTab = 'Manhwa'" 
                        :class="activeTab === 'Manhwa' ? 'bg-purple-600 text-white shadow-lg' : 'text-neutral-400 hover:text-white hover:bg-white/5'"
                        class="px-5 py-2 rounded-lg text-sm font-bold transition-all duration-300">
                    Manhwa
                </button>
                <button @click="activeTab = 'Manhua'" 
                        :class="activeTab === 'Manhua' ? 'bg-purple-600 text-white shadow-lg' : 'text-neutral-400 hover:text-white hover:bg-white/5'"
                        class="px-5 py-2 rounded-lg text-sm font-bold transition-all duration-300">
                    Manhua
                </button>
            </div>
        </div>

        <div x-show="activeTab === 'Manga'" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0">
            @if($manga->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-5">
                    @foreach($manga as $comic)
                        <x-comic-card-home :comic="$comic" />
                    @endforeach
                </div>
            @else
                <div class="py-12 text-center border border-white/5 rounded-2xl bg-neutral-900/50">
                    <p class="text-neutral-500">Belum ada data Manga.</p>
                </div>
            @endif
            <div class="mt-6 text-center">
                <a href="{{ route('explore.index', ['type' => 'Manga']) }}" class="inline-flex items-center gap-2 text-sm font-bold text-neutral-400 hover:text-white transition-colors">
                    Lihat Semua Manga <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>

        <div x-show="activeTab === 'Manhwa'" style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0">
            @if($manhwa->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-5">
                    @foreach($manhwa as $comic)
                        <x-comic-card-home :comic="$comic" />
                    @endforeach
                </div>
            @else
                <div class="py-12 text-center border border-white/5 rounded-2xl bg-neutral-900/50">
                    <p class="text-neutral-500">Belum ada data Manhwa.</p>
                </div>
            @endif
            <div class="mt-6 text-center">
                <a href="{{ route('explore.index', ['type' => 'Manhwa']) }}" class="inline-flex items-center gap-2 text-sm font-bold text-neutral-400 hover:text-white transition-colors">
                    Lihat Semua Manhwa <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>

        <div x-show="activeTab === 'Manhua'" style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0">
            @if($manhua->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-5">
                    @foreach($manhua as $comic)
                        <x-comic-card-home :comic="$comic" />
                    @endforeach
                </div>
            @else
                <div class="py-12 text-center border border-white/5 rounded-2xl bg-neutral-900/50">
                    <p class="text-neutral-500">Belum ada data Manhua.</p>
                </div>
            @endif
            <div class="mt-6 text-center">
                <a href="{{ route('explore.index', ['type' => 'Manhua']) }}" class="inline-flex items-center gap-2 text-sm font-bold text-neutral-400 hover:text-white transition-colors">
                    Lihat Semua Manhua <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>

    </section>

    <div class="h-px bg-gradient-to-r from-transparent via-white/10 to-transparent mb-16"></div>

    <section class="mb-16">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl md:text-3xl font-bold text-white flex items-center gap-3">
                <div class="p-2 bg-purple-500/10 rounded-lg">
                    <i data-lucide="zap" class="w-6 h-6 text-purple-500"></i>
                </div>
                Update Terbaru
            </h2>
            <a href="{{ route('explore.index', ['sort' => 'Terbaru']) }}" class="group flex items-center gap-1 text-sm font-bold text-neutral-500 hover:text-white transition-colors">
                Lihat Semua Update <i data-lucide="arrow-right" class="w-4 h-4 transition-transform group-hover:translate-x-1"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-5">
            @forelse($latestUpdates as $comic)
                <x-comic-card-home :comic="$comic" />
            @empty
                <div class="col-span-full py-16 text-center bg-neutral-900/50 rounded-3xl border border-white/5">
                    <div class="w-16 h-16 bg-neutral-800 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="inbox" class="w-8 h-8 text-neutral-500"></i>
                    </div>
                    <h3 class="text-white font-bold text-lg mb-1">Belum ada update</h3>
                    <p class="text-neutral-500 text-sm">Cek kembali nanti untuk chapter terbaru.</p>
                </div>
            @endforelse
        </div>
        
        <div class="mt-10 text-center">
             <a href="{{ route('explore.index') }}" class="px-8 py-3 bg-neutral-800 hover:bg-neutral-700 text-white font-bold rounded-xl border border-white/5 transition-all">
                Muat Lebih Banyak
            </a>
        </div>
    </section>

    <div class="mb-12"></div>

@endsection