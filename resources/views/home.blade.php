@extends('layouts.app')

@section('title', 'Beranda - KOMIKIN')

@section('content')

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        <section class="mt-8" x-data="{ activeCategory: 'manga' }">
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

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-x-4 gap-y-8">
                <template x-for="i in 6" :key="activeCategory + i">
                    <div class="group cursor-pointer">
                        
                        <div class="relative aspect-[3/4] rounded-xl overflow-hidden shadow-lg transition-all duration-300 group-hover:shadow-purple-500/30 group-hover:-translate-y-1">
                            
                            <div class="absolute top-2 left-2 z-10 flex flex-col items-start gap-1">
                                <span class="bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded shadow-sm">UP</span>
                                <template x-if="i <= 2">
                                    <span class="bg-amber-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded shadow-sm">🔥 HOT</span>
                                </template>
                            </div>

                            <img :src="`https://via.placeholder.com/300x400/1f2937/FFFFFF?text=${activeCategory.toUpperCase()}`" 
                                 alt="Cover" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            
                            <div class="absolute inset-x-0 bottom-0 h-1/4 bg-gradient-to-t from-black/60 to-transparent"></div>

                            <div class="absolute bottom-2 right-2 z-10">
                                <span class="text-xl drop-shadow-md" x-show="activeCategory === 'manga'">🇯🇵</span>
                                <span class="text-xl drop-shadow-md" x-show="activeCategory === 'manhua'">🇨🇳</span>
                                <span class="text-xl drop-shadow-md" x-show="activeCategory === 'manhwa'">🇰🇷</span>
                            </div>
                        </div>

                        <div class="mt-3">
                            <h3 class="text-gray-100 font-bold text-[15px] leading-tight line-clamp-2 group-hover:text-purple-400 transition-colors">
                                Keajaiban Legenda Kediaman Duke Yang Sangat Panjang Judulnya
                            </h3>
                            
                            <div class="flex justify-between items-center mt-2 text-xs text-gray-400">
                                <span class="flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                                    Ch. <span x-text="100 + i"></span>
                                </span>
                                <span class="flex items-center gap-1 text-yellow-500/90">
                                    ★ 4.8
                                </span>
                            </div>
                        </div>

                    </div>
                </template>
            </div>
        </section>

        <hr class="my-12 border-gray-800">

        <section class="mt-10">
            <h2 class="text-3xl font-bold mb-6 text-white flex items-center">
                <span class="mr-2">📚</span> Baru Rilis
            </h2>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-x-4 gap-y-8">
                @for ($i = 0; $i < 12; $i++)
                <div class="group cursor-pointer">
                    <div class="relative aspect-[3/4] rounded-xl overflow-hidden bg-gray-800 shadow-md transition-all duration-300 group-hover:shadow-purple-500/20 group-hover:-translate-y-1">
                        <div class="absolute top-0 right-0 z-10 bg-purple-600/90 backdrop-blur-sm text-white text-[10px] font-bold px-2 py-1 rounded-bl-lg">
                            MANHWA
                        </div>

                        <img src="https://via.placeholder.com/300x400/1f2937/FFFFFF?text=Komik+{{$i+1}}" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        
                        <div class="absolute inset-x-0 bottom-0 h-10 bg-gradient-to-t from-black/50 to-transparent"></div>
                    </div>

                    <div class="mt-3 px-1">
                        <h3 class="text-gray-200 font-bold text-sm leading-snug line-clamp-2 group-hover:text-purple-400 transition-colors">
                            Dukedom's Legendary Prodigy Level {{$i+1}}
                        </h3>
                        <div class="flex justify-between items-center mt-1.5 text-xs text-gray-500">
                            <span>Chapter 45</span>
                            <span>2 jam lalu</span>
                        </div>
                    </div>
                </div>
                @endfor
            </div>

            <div class="flex justify-center items-center space-x-2 mt-12">
                <a href="#" class="h-10 px-4 flex items-center justify-center bg-gray-800 rounded-lg text-gray-400 hover:text-white hover:bg-gray-700 transition">Previous</a>
                <a href="#" class="h-10 w-10 flex items-center justify-center bg-purple-600 rounded-lg text-white font-bold shadow-lg shadow-purple-500/30">1</a>
                <a href="#" class="h-10 w-10 flex items-center justify-center bg-gray-800 rounded-lg text-gray-400 hover:bg-gray-700 transition">2</a>
                <a href="#" class="h-10 w-10 flex items-center justify-center bg-gray-800 rounded-lg text-gray-400 hover:bg-gray-700 transition">3</a>
                <a href="#" class="h-10 px-4 flex items-center justify-center bg-gray-800 rounded-lg text-gray-400 hover:text-white hover:bg-gray-700 transition">Next</a>
            </div>
        </section>
        
        <div class="mb-20"></div> 
    </div>

@endsection