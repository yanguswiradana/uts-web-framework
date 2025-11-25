@extends('layouts.app')

@section('title', 'Beranda - KOMIKIN')

@section('content')

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        <section class="mt-8" x-data="{ activeCategory: 'manga' }">
            <h2 class="text-3xl font-bold mb-6 text-white">🔥 Pilihan Editor</h2>

            <div class="flex space-x-4 border-b border-gray-700 mb-8 overflow-x-auto pb-2">
                <button @click="activeCategory = 'manga'"
                        :class="activeCategory === 'manga' ? 'text-purple-500 border-b-2 border-purple-500 font-semibold' : 'text-gray-400 hover:text-purple-500'"
                        class="category-btn py-2 px-4 text-lg focus:outline-none transition duration-150 whitespace-nowrap">
                    Manga 🇯🇵
                </button>
                <button @click="activeCategory = 'manhua'"
                        :class="activeCategory === 'manhua' ? 'text-purple-500 border-b-2 border-purple-500 font-semibold' : 'text-gray-400 hover:text-purple-500'"
                        class="category-btn py-2 px-4 text-lg focus:outline-none transition duration-150 whitespace-nowrap">
                    Manhua 🇨🇳
                </button>
                <button @click="activeCategory = 'manhwa'"
                        :class="activeCategory === 'manhwa' ? 'text-purple-500 border-b-2 border-purple-500 font-semibold' : 'text-gray-400 hover:text-purple-500'"
                        class="category-btn py-2 px-4 text-lg focus:outline-none transition duration-150 whitespace-nowrap">
                    Manhwa 🇰🇷
                </button>
            </div>

            <div id="comic-panel" class="grid
                 grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 sm:gap-6">

                <template x-for="i in 6" :key="activeCategory + i">
                    <div class="bg-gray-800 rounded-lg shadow-xl overflow-hidden transition transform hover:scale-[1.03] duration-300 comic-card border border-gray-700">
                        <img :src="`https://via.placeholder.com/150x225/1f2937/FFFFFF?text=${activeCategory.toUpperCase()}`" alt="Cover Komik" class="w-full">
                        <div class="p-3">
                            <h3 class="font-semibold text-white truncate text-base">Judul Komik</h3>
                            <p class="text-sm text-purple-400">Chapter: <span x-text="100 + i"></span></p>
                        </div>
                    </div>
                </template>
            </div>
        </section>

        <hr class="my-10 border-gray-700">

        <section class="mt-10">
            <h2 class="text-3xl font-bold mb-6 text-white">📚 Semua Komik</h2>
            <div class="grid
                 grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 sm:gap-6">

                @for ($i = 0; $i < 12; $i++)
                <div class="bg-gray-800 rounded-lg shadow-xl overflow-hidden transition transform hover:shadow-2xl duration-300 comic-card border border-gray-700">
                    <img src="https://via.placeholder.com/150x225/1f2937/FFFFFF?text=All+Komik+{{$i+1}}" alt="Cover Komik" class="w-full">
                    <div class="p-3">
                        <h3 class="font-semibold text-white truncate text-base">Komik {{$i+1}}</h3>
                        <p class="text-sm text-gray-400">View: 1.2K</p>
                    </div>
                </div>
                @endfor
            </div>

            <div class="flex justify-center items-center space-x-2 mt-10">
                <a href="#" class="py-2 px-3 border border-gray-700 rounded-lg text-gray-400 hover:bg-gray-800 transition duration-150 disabled:opacity-50 text-sm">
                    &laquo; Prev
                </a>
                <div class="hidden sm:flex space-x-1">
                    <a href="#" class="py-2 px-4 border border-purple-500 rounded-lg bg-purple-600 text-white font-bold text-sm">1</a>
                    <a href="#" class="py-2 px-4 border border-gray-700 rounded-lg bg-gray-800 hover:bg-gray-700 text-gray-200 transition duration-150 text-sm">2</a>
                    <a href="#" class="py-2 px-4 border border-gray-700 rounded-lg bg-gray-800 hover:bg-gray-700 text-gray-200 transition duration-150 text-sm">3</a>
                    <span class="py-2 px-4 text-gray-500 text-sm">...</span>
                </div>
                <a href="#" class="py-2 px-3 border border-gray-700 rounded-lg text-gray-400 hover:bg-gray-800 transition duration-150 text-sm">
                    Next &raquo;
                </a>
            </div>
        </section>

        <hr class="my-10 border-gray-700">

        <section class="mt-10" x-data="{ topTab: 'weekly' }">
            <h2 class="text-3xl font-bold mb-6 text-white">🏆 Komik Populer</h2>

            <div class="flex space-x-4 border-b border-gray-700 mb-8 overflow-x-auto pb-2">
                <button @click="topTab = 'weekly'"
                        :class="topTab === 'weekly' ? 'text-purple-500 border-b-2 border-purple-500 font-semibold' : 'text-gray-400 hover:text-purple-500'"
                        class="tab-top-btn py-2 px-4 text-lg focus:outline-none transition duration-150 whitespace-nowrap">
                    Mingguan
                </button>
                <button @click="topTab = 'daily'"
                        :class="topTab === 'daily' ? 'text-purple-500 border-b-2 border-purple-500 font-semibold' : 'text-gray-400 hover:text-purple-500'"
                        class="tab-top-btn py-2 px-4 text-lg focus:outline-none transition duration-150 whitespace-nowrap">
                    Harian
                </button>
                <button @click="topTab = 'all-time'"
                        :class="topTab === 'all-time' ? 'text-purple-500 border-b-2 border-purple-500 font-semibold' : 'text-gray-400 hover:text-purple-500'"
                        class="tab-top-btn py-2 px-4 text-lg focus:outline-none transition duration-150 whitespace-nowrap">
                    Sepanjang Masa
                </button>
            </div>

            <div id="top-comics-content">
                @for ($i = 1; $i <= 5; $i++)
                <div class="flex items-center space-x-4 p-3 border-b border-gray-700 hover:bg-gray-800 transition duration-150">
                    <span class="text-2xl font-extrabold w-8 text-center"
                          :class="{'text-purple-500': {{$i}} <= 3, 'text-gray-400': {{$i}} > 3}">
                        #{{$i}}
                    </span>
                    <img src="https://via.placeholder.com/60x90/4b5563/FFFFFF" alt="Thumbnail" class="w-12 h-18 object-cover rounded shadow">
                    <div class="flex-grow">
                        <p class="font-bold text-white text-base">Judul Komik Rank <span x-text="topTab"></span></p>
                        <p class="text-sm text-gray-400">Chapter: 300 | Genre: Fantasy</p>
                    </div>
                    <span class="text-purple-400 font-semibold hidden sm:block">2.5M Views</span>
                </div>
                @endfor
            </div>
        </section>

    </div>

@endsection
