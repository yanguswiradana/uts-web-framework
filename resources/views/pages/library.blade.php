@extends('layouts.app')

@section('title', 'Library Saya - KOMIKIN')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ activeTab: 'continue' }">

    <h1 class="text-4xl font-extrabold text-white mb-8 border-b border-purple-500 pb-3">Perpustakaan Saya</h1>

    <div class="flex space-x-6 border-b border-gray-700 mb-8 overflow-x-auto pb-2">
        <button @click="activeTab = 'continue'"
                :class="activeTab === 'continue' ? 'text-purple-500 border-b-2 border-purple-500 font-semibold' : 'text-gray-400 hover:text-purple-500'"
                class="tab-btn py-2 px-4 text-lg focus:outline-none transition duration-150 whitespace-nowrap">
            Lanjut Baca (4)
        </button>
        <button @click="activeTab = 'favorites'"
                :class="activeTab === 'favorites' ? 'text-purple-500 border-b-2 border-purple-500 font-semibold' : 'text-gray-400 hover:text-purple-500'"
                class="tab-btn py-2 px-4 text-lg focus:outline-none transition duration-150 whitespace-nowrap">
            Favorit (12)
        </button>
        <button @click="activeTab = 'history'"
                :class="activeTab === 'history' ? 'text-purple-500 border-b-2 border-purple-500 font-semibold' : 'text-gray-400 hover:text-purple-500'"
                class="tab-btn py-2 px-4 text-lg focus:outline-none transition duration-150 whitespace-nowrap">
            Riwayat Baca
        </button>
    </div>

    <div x-show="activeTab === 'continue'" class="space-y-6">
        <h2 class="text-2xl font-bold text-white mb-4">Lanjutkan dari Chapter Terakhir</h2>

        @for ($i = 0; $i < 3; $i++)
        <div class="flex bg-gray-800 p-4 rounded-lg shadow-xl border border-gray-700 items-center hover:bg-gray-700 transition duration-150">
            <img src="https://via.placeholder.com/90x120/1f2937/FFFFFF?text=C-{{$i+1}}" alt="Thumbnail" class="w-16 h-24 object-cover rounded shadow-lg mr-6">
            <div class="flex-grow">
                <p class="font-bold text-white text-xl">Judul Komik Favorit {{$i+1}}</p>
                <p class="text-purple-400 text-sm mt-1">Lanjut: Chapter 85</p>
                <p class="text-gray-400 text-xs">Genre: Fantasy | Last Read: 2 jam lalu</p>
            </div>
            <a href="#" class="bg-purple-600 text-white py-2 px-4 rounded-full hover:bg-purple-700 font-semibold text-sm transition duration-150 whitespace-nowrap">
                Baca Sekarang
            </a>
        </div>
        @endfor
    </div>

    <div x-show="activeTab === 'favorites'">
        <h2 class="text-2xl font-bold text-white mb-4">Komik yang Anda Favoritkan</h2>
        <div class="grid
                 grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5
                 gap-4 sm:gap-6">

                @for ($i = 0; $i < 10; $i++)
                <div class="bg-gray-800 rounded-lg shadow-xl overflow-hidden comic-card border border-gray-700">
                    <img src="https://via.placeholder.com/150x225/1f2937/FFFFFF?text=FAV+{{$i+1}}" alt="Cover Komik" class="w-full">
                    <div class="p-3">
                        <h3 class="font-semibold text-white truncate text-base">Judul Favorit {{$i+1}}</h3>
                        <p class="text-sm text-purple-400">Chapter: 150</p>
                    </div>
                </div>
                @endfor
            </div>
    </div>

    <div x-show="activeTab === 'history'">
        <h2 class="text-2xl font-bold text-white mb-4">Riwayat Semua Bacaan</h2>
        <p class="text-gray-400">Daftar semua komik yang pernah Anda buka (List View)</p>
        </div>

</div>
@endsection
