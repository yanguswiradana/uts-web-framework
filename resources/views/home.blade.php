@extends('layouts.app')

@section('title', 'Beranda - KOMIKIN')

@section('content')

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        <section class="mt-8" x-data="{ activeCategory: 'manhwa' }">

            <h2 class="text-3xl font-bold mb-6 text-white flex items-center">
                <span class="mr-2">🔥</span> Pilihan Editor
            </h2>

            <div class="flex space-x-2 border-b border-gray-800 mb-6 overflow-x-auto pb-2 scrollbar-hide">
                <button @click="activeCategory = 'manga'"
                        :class="activeCategory === 'manga' ? 'bg-white text-gray-900' : 'bg-gray-800 text-gray-400 hover:bg-gray-700'"
                        class="py-1.5 px-5 rounded-full text-sm font-bold transition duration-200 whitespace-nowrap">
                    Manga 🇯🇵
                </button>
                <button @click="activeCategory = 'manhua'"
                        :class="activeCategory === 'manhua' ? 'bg-white text-gray-900' : 'bg-gray-800 text-gray-400 hover:bg-gray-700'"
                        class="py-1.5 px-5 rounded-full text-sm font-bold transition duration-200 whitespace-nowrap">
                    Manhua 🇨🇳
                </button>
                <button @click="activeCategory = 'manhwa'"
                        :class="activeCategory === 'manhwa' ? 'bg-white text-gray-900' : 'bg-gray-800 text-gray-400 hover:bg-gray-700'"
                        class="py-1.5 px-5 rounded-full text-sm font-bold transition duration-200 whitespace-nowrap">
                    Manhwa 🇰🇷
                </button>
            </div>

            <div x-show="activeCategory === 'manga'" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-x-4 gap-y-8" style="display: none;">
                @foreach($manga as $comic)
                    <a href="{{ route('komik.show', $comic['slug']) }}" class="group cursor-pointer">
                        <div class="relative aspect-[3/4] rounded-xl overflow-hidden shadow-lg transition-all duration-300 group-hover:shadow-purple-500/30 group-hover:-translate-y-1">
                            <div class="absolute top-2 left-2 z-10 flex flex-col items-start gap-1">
                                <span class="bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded shadow-sm">UP</span>
                            </div>
                            <img src="{{ Str::startsWith($comic['cover'], 'http') ? $comic['cover'] : asset($comic['cover']) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            <div class="absolute inset-x-0 bottom-0 h-1/4 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div class="absolute bottom-2 right-2 z-10"><span class="text-xl drop-shadow-md">🇯🇵</span></div>
                        </div>
                        <div class="mt-3">
                            <h3 class="text-gray-100 font-bold text-[15px] leading-tight line-clamp-2 group-hover:text-purple-400 transition-colors">{{ $comic['title'] }}</h3>
                            <div class="flex justify-between items-center mt-2 text-xs text-gray-400">
                                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-purple-500"></span>Ch. {{ $comic['chapters'] }}</span>
                                <span class="text-yellow-500/90">★ {{ $comic['rating'] }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div x-show="activeCategory === 'manhua'" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-x-4 gap-y-8" style="display: none;">
                @foreach($manhua as $comic)
                     <a href="{{ route('komik.show', $comic['slug']) }}" class="group cursor-pointer">
                        <div class="relative aspect-[3/4] rounded-xl overflow-hidden shadow-lg transition-all duration-300 group-hover:shadow-purple-500/30 group-hover:-translate-y-1">
                            <div class="absolute top-2 left-2 z-10 flex flex-col items-start gap-1">
                                <span class="bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded shadow-sm">UP</span>
                            </div>
                            <img src="{{ Str::startsWith($comic['cover'], 'http') ? $comic['cover'] : asset($comic['cover']) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            <div class="absolute inset-x-0 bottom-0 h-1/4 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div class="absolute bottom-2 right-2 z-10"><span class="text-xl drop-shadow-md">🇨🇳</span></div>
                        </div>
                        <div class="mt-3">
                            <h3 class="text-gray-100 font-bold text-[15px] leading-tight line-clamp-2 group-hover:text-purple-400 transition-colors">{{ $comic['title'] }}</h3>
                            <div class="flex justify-between items-center mt-2 text-xs text-gray-400">
                                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-purple-500"></span>Ch. {{ $comic['chapters'] }}</span>
                                <span class="text-yellow-500/90">★ {{ $comic['rating'] }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div x-show="activeCategory === 'manhwa'" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-x-4 gap-y-8">
                @foreach($manhwa as $comic)
                     <a href="{{ route('komik.show', $comic['slug']) }}" class="group cursor-pointer">
                        <div class="relative aspect-[3/4] rounded-xl overflow-hidden shadow-lg transition-all duration-300 group-hover:shadow-purple-500/30 group-hover:-translate-y-1">
                            <div class="absolute top-2 left-2 z-10 flex flex-col items-start gap-1">
                                <span class="bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded shadow-sm">UP</span>
                            </div>
                            <img src="{{ Str::startsWith($comic['cover'], 'http') ? $comic['cover'] : asset($comic['cover']) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            <div class="absolute inset-x-0 bottom-0 h-1/4 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div class="absolute bottom-2 right-2 z-10"><span class="text-xl drop-shadow-md">🇰🇷</span></div>
                        </div>
                        <div class="mt-3">
                            <h3 class="text-gray-100 font-bold text-[15px] leading-tight line-clamp-2 group-hover:text-purple-400 transition-colors">{{ $comic['title'] }}</h3>
                            <div class="flex justify-between items-center mt-2 text-xs text-gray-400">
                                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-purple-500"></span>Ch. {{ $comic['chapters'] }}</span>
                                <span class="text-yellow-500/90">★ {{ $comic['rating'] }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        <hr class="my-12 border-gray-800">

        <section class="mt-10">
            <h2 class="text-3xl font-bold mb-6 text-white flex items-center">
                <span class="mr-2">📚</span> Baru Rilis
            </h2>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-x-4 gap-y-8">
                @foreach ($latestUpdates as $comic)
                <a href="{{ route('komik.show', $comic['slug']) }}" class="group cursor-pointer">
                    <div class="relative aspect-[3/4] rounded-xl overflow-hidden bg-gray-800 shadow-md transition-all duration-300 group-hover:shadow-purple-500/20 group-hover:-translate-y-1">
                        <div class="absolute top-0 right-0 z-10 bg-purple-600/90 backdrop-blur-sm text-white text-[10px] font-bold px-2 py-1 rounded-bl-lg uppercase">
                            {{ $comic['type'] }}
                        </div>
                        <img src="{{ Str::startsWith($comic['cover'], 'http') ? $comic['cover'] : asset($comic['cover']) }}"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        <div class="absolute inset-x-0 bottom-0 h-10 bg-gradient-to-t from-black/50 to-transparent"></div>
                    </div>

                    <div class="mt-3 px-1">
                        <h3 class="text-gray-200 font-bold text-sm leading-snug line-clamp-2 group-hover:text-purple-400 transition-colors">
                            {{ $comic['title'] }}
                        </h3>
                        <div class="flex justify-between items-center mt-1.5 text-xs text-gray-500">
                            <span>Ch. {{ $comic['chapters'] }}</span>
                            <span>{{ rand(1,24) }} jam lalu</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <div class="flex justify-center items-center space-x-2 mt-12">
                <a href="{{ route('explore.index') }}" class="px-6 py-2 bg-gray-800 rounded-lg text-gray-400 hover:text-white hover:bg-gray-700 transition font-bold">
                    Lihat Semua Komik
                </a>
            </div>
        </section>

        <div class="mb-20"></div>
    </div>

@endsection
