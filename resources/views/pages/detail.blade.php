@extends('layouts.app')

@section('title', $comic['title'] . ' - KOMIKIN')

@section('content')
<div class="relative min-h-screen bg-[#0f0f0f] text-gray-200 pb-20">

    <div class="absolute top-0 left-0 w-full h-[500px] overflow-hidden z-0">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-[#0f0f0f]/80 to-[#0f0f0f] z-10"></div>
        <img src="{{ asset($comic['cover']) }}" alt="Background" class="w-full h-full object-cover blur-2xl opacity-40 scale-110">
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 pt-10">

        <div class="flex flex-col md:flex-row gap-8 items-start">

            <div class="w-full md:w-[280px] flex-shrink-0 mx-auto md:mx-0">
                <div class="aspect-[3/4] rounded-xl overflow-hidden shadow-2xl shadow-purple-900/20 border border-gray-700/50">
                    <img src="{{ asset($comic['cover']) }}" alt="{{ $comic['title'] }}" class="w-full h-full object-cover">
                </div>
            </div>

            <div class="flex-1 w-full">
                <h1 class="text-3xl md:text-5xl font-bold text-white mb-2 leading-tight">
                    {{ $comic['title'] }}
                </h1>
                <p class="text-gray-400 text-lg mb-6 italic">Alternative Title Here (Korea/China)</p>

                <div class="flex flex-wrap gap-3 mb-8">
                    <a href="{{ route('komik.read', [$comic['slug'], 1]) }}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-8 rounded-lg flex items-center gap-2 transition shadow-lg shadow-purple-600/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                        </svg>
                        Baca
                    </a>
                    <button class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-lg flex items-center gap-2 border border-gray-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                        </svg>
                        Bookmark
                    </button>
                    <button class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-3 px-4 rounded-lg border border-gray-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </button>
                </div>

                <div class="flex items-center gap-6 text-sm md:text-base text-gray-300 mb-6">
                    <div class="flex items-center gap-1">
                        <span class="text-yellow-500 text-lg">★</span>
                        <span class="font-bold text-white">8.5</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path></svg>
                        <span>13,533</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <span>1.8m</span>
                    </div>
                </div>

                <div x-data="{ expanded: false }" class="mb-8">
                    <p class="text-gray-300 leading-relaxed" :class="expanded ? '' : 'line-clamp-3'">
                        {{ $comic['synopsis'] }}
                    </p>
                    <button @click="expanded = !expanded" class="text-purple-400 text-sm font-semibold hover:text-purple-300 mt-1 focus:outline-none">
                        <span x-text="expanded ? 'Show Less' : '... Read More'"></span>
                    </button>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div class="bg-gray-900/50 p-3 rounded-lg border border-gray-800">
                        <span class="block text-gray-500 text-xs uppercase tracking-wider font-bold mb-1">Genre</span>
                        <span class="text-gray-200">{{ $comic['genre'] }}</span>
                    </div>
                    <div class="bg-gray-900/50 p-3 rounded-lg border border-gray-800">
                        <span class="block text-gray-500 text-xs uppercase tracking-wider font-bold mb-1">Author</span>
                        <span class="text-gray-200">Menyusul</span>
                    </div>
                    <div class="bg-gray-900/50 p-3 rounded-lg border border-gray-800">
                        <span class="block text-gray-500 text-xs uppercase tracking-wider font-bold mb-1">Artist</span>
                        <span class="text-gray-200">Menyusul</span>
                    </div>
                    <div class="bg-gray-900/50 p-3 rounded-lg border border-gray-800">
                        <span class="block text-gray-500 text-xs uppercase tracking-wider font-bold mb-1">Format</span>
                        <span class="text-gray-200">Manhwa</span>
                    </div>
                </div>

            </div>
        </div>
        <hr class="border-gray-800 my-10">

        <div class="mt-8">
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <div class="flex items-center gap-4">
                    <h2 class="text-2xl font-bold text-white">Chapters</h2>
                    <span class="bg-gray-800 text-gray-300 text-xs px-2 py-1 rounded">{{ count($chapters) }}</span>
                </div>

                <div class="relative w-full md:w-64">
                    <input type="text" placeholder="Cari Chapter, Contoh: 23"
                           class="w-full bg-black/30 border border-gray-700 rounded-lg py-2.5 pl-4 pr-10 text-sm text-gray-200 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500">
                    <button class="absolute right-3 top-2.5 text-gray-500 hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($chapters as $chapter)
                <a href="{{ route('komik.read', [$comic['slug'], $chapter['number']]) }}" class="group relative bg-[#161616] hover:bg-[#1f1f1f] rounded-lg overflow-hidden flex items-center p-3 border border-transparent hover:border-gray-700 transition duration-200">

                    <div class="w-20 h-16 rounded overflow-hidden flex-shrink-0 mr-4 relative">
                        <img src="{{ asset($chapter['image']) }}" alt="Ch {{ $chapter['number'] }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div class="absolute inset-0 bg-black/20"></div>
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start">
                            <h3 class="text-white font-bold text-sm truncate group-hover:text-purple-400 transition">
                                Chapter {{ $chapter['number'] }}
                            </h3>

                            @if($chapter['is_new'])
                            <span class="bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded flex-shrink-0 ml-2 animate-pulse">
                                UP
                            </span>
                            @endif
                        </div>
                        <p class="text-gray-500 text-xs mt-1">{{ $chapter['date'] }}</p>
                    </div>
                </a>
                @endforeach
            </div>

            <div class="mt-8 text-center">
                 <button class="bg-gray-800 hover:bg-gray-700 text-gray-300 font-semibold py-2 px-6 rounded-full text-sm transition">
                    Muat Lebih Banyak
                </button>
            </div>
        </div>
        </div>
</div>
@endsection
