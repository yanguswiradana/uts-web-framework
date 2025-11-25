@extends('layouts.app')

@section('title', 'Library Saya - KOMIKIN')

@section('content')

<?php
// Data Dummy Library
// Catatan: Saya ubah 'image_html' menjadi 'image_url' agar kita bisa styling tag <img> nya langsung (zoom, rounded, dll)
$favoriteComics = [
    [
        'title' => 'Bones', 
        'chapter' => 30, 
        'type' => 'Manhwa',
        'image_url' => asset('images/bones.jpg')
    ],
    [
        'title' => 'Star Ginseng Store', 
        'chapter' => 186, 
        'type' => 'Manhwa',
        'image_url' => asset('images/star_ginseng_store.jpg')
    ],
    [
        'title' => 'My Bias Gets On The Last Train', 
        'chapter' => 54, 
        'type' => 'Manhwa',
        'image_url' => asset('images/my bias gets on the last train.jpg')
    ],
    [
        'title' => 'Pick Me Up', 
        'chapter' => 176, 
        'type' => 'Manhwa',
        'image_url' => asset('images/pick_me_up.jpg')
    ],
    [
        'title' => 'Nano Machine', 
        'chapter' => 287, 
        'type' => 'Manhwa',
        'image_url' => asset('images/nano_machine.jpg')
    ],
    [
        'title' => 'Reality Quest', 
        'chapter' => 179, 
        'type' => 'Manhwa',
        'image_url' => asset('images/reality_quest.jpg')
    ],
];
?>

<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10 min-h-screen">

    <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 border-b border-gray-800 pb-6">
        <div>
            <h1 class="text-3xl font-extrabold text-white flex items-center">
                <span class="mr-3 text-purple-500">❤️</span> Library Saya
            </h1>
            <p class="text-gray-400 mt-2 text-sm">
                Daftar bacaan favorit kamu ({{ count($favoriteComics) }} Komik)
            </p>
        </div>
        
        <div class="mt-4 md:mt-0 w-full md:w-auto">
            <div class="relative">
                <input type="text" placeholder="Cari judul..." 
                       class="bg-gray-800 text-sm text-gray-200 pl-10 pr-4 py-2.5 rounded-full border border-gray-700 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition w-full md:w-64">
                <div class="absolute left-3 top-2.5 text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-x-5 gap-y-10">

        @foreach ($favoriteComics as $comic)
        <div class="group relative cursor-pointer">
            
            <a href="/comic/{{ Str::slug($comic['title']) }}" class="block">
                
                <div class="relative aspect-[3/4] rounded-xl overflow-hidden bg-gray-900 shadow-md transition-all duration-300 group-hover:shadow-purple-500/40 group-hover:-translate-y-1">
                    
                    <div class="absolute top-0 left-0 z-10 bg-purple-600/90 backdrop-blur-sm text-white text-[10px] font-bold px-2 py-1 rounded-br-lg shadow-sm">
                        {{ $comic['type'] ?? 'Manhwa' }}
                    </div>

                    <img src="{{ $comic['image_url'] ?? 'https://via.placeholder.com/300x400' }}" 
                         alt="{{ $comic['title'] }}" 
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    
                    <div class="absolute inset-x-0 bottom-0 h-1/4 bg-gradient-to-t from-gray-900/60 to-transparent pointer-events-none"></div>

                </div>
            </a>

            <div class="mt-3 px-1">
                <a href="/comic/{{ Str::slug($comic['title']) }}" class="group-hover:text-purple-400 transition-colors duration-200">
                    <h3 class="text-gray-100 font-bold text-[15px] leading-snug line-clamp-1" title="{{ $comic['title'] }}">
                        {{ $comic['title'] }}
                    </h3>
                </a>

                <div class="flex justify-between items-center mt-2">
                    <span class="inline-flex items-center text-xs text-gray-400 font-medium">
                        <svg class="w-3 h-3 mr-1 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        Ch. {{ $comic['chapter'] }}
                    </span>
                    
                    <span class="text-[11px] text-gray-500">
                        1 jam lalu
                    </span>
                </div>
            </div>

        </div>
        @endforeach

    </div>

    @if(empty($favoriteComics))
    <div class="flex flex-col items-center justify-center py-20 text-center">
        <div class="w-24 h-24 bg-gray-800 rounded-full flex items-center justify-center mb-4">
            <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
        </div>
        <h3 class="text-xl text-white font-bold">Belum ada Favorit</h3>
        <p class="text-gray-500 mt-2 max-w-sm">Tandai komik yang kamu suka agar mudah ditemukan di sini.</p>
        <a href="/" class="mt-6 px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-sm font-semibold transition">
            Jelajahi Sekarang
        </a>
    </div>
    @endif

</div>
@endsection