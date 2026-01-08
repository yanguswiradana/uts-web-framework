@extends('layouts.app')

@section('title', 'Baca ' . $comic['title'] . ' Chapter ' . $chapterNumber . ' - KOMIKIN')

@section('content')
<div class="bg-gray-950 min-h-screen pb-20">
    <!-- Header/Navigation Reader -->
    <div class="sticky top-0 z-50 bg-gray-900/80 backdrop-blur-md border-b border-gray-800 py-3">
        <div class="container mx-auto px-4 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('komik.show', $comic['slug']) }}" class="p-2 hover:bg-gray-800 rounded-lg transition text-gray-400 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-white font-bold text-sm md:text-base line-clamp-1">{{ $comic['title'] }}</h1>
                    <p class="text-purple-400 text-xs font-medium">Chapter {{ $chapterNumber }}</p>
                </div>
            </div>

            <div class="flex items-center justify-center gap-2">
                @if($prevChapter)
                    <a href="{{ route('komik.read', [$comic['slug'], $prevChapter]) }}" class="px-4 py-2 bg-gray-800 hover:bg-purple-600 text-white rounded-lg text-sm font-bold transition flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Prev
                    </a>
                @else
                    <button disabled class="px-4 py-2 bg-gray-800/50 text-gray-600 rounded-lg text-sm font-bold cursor-not-allowed">Prev</button>
                @endif

                <div class="relative group">
                    <button class="px-6 py-2 bg-gray-800 text-white rounded-lg text-sm font-bold flex items-center gap-2 border border-gray-700">
                        Ch. {{ $chapterNumber }}
                    </button>
                </div>

                @if($nextChapter)
                    <a href="{{ route('komik.read', [$comic['slug'], $nextChapter]) }}" class="px-4 py-2 bg-gray-800 hover:bg-purple-600 text-white rounded-lg text-sm font-bold transition flex items-center gap-2">
                        Next
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                @else
                    <button disabled class="px-4 py-2 bg-gray-800/50 text-gray-600 rounded-lg text-sm font-bold cursor-not-allowed">Next</button>
                @endif
            </div>
        </div>
    </div>

    <!-- Image Viewer -->
    <div class="container mx-auto mt-4 flex flex-col items-center max-w-4xl">
        <div class="w-full space-y-0 shadow-2xl shadow-purple-500/5">
            @foreach($chapterImages as $image)
                <div class="relative group">
                    <img src="{{ $image }}" alt="Page {{ $loop->iteration }}" class="w-full h-auto block" loading="lazy">
                    <div class="absolute inset-0 bg-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Bottom Navigation -->
    <div class="container mx-auto px-4 mt-12 pb-12 flex flex-col items-center">
        <div class="bg-gray-900 p-8 rounded-2xl border border-gray-800 text-center w-full max-w-2xl">
            <h3 class="text-white font-bold text-xl mb-4">Selesai Membaca?</h3>
            <p class="text-gray-400 mb-8">Berikan rating untuk mendukung komik favoritmu!</p>
            
            <div class="flex flex-wrap justify-center gap-4">
                @if($prevChapter)
                    <a href="{{ route('komik.read', [$comic['slug'], $prevChapter]) }}" class="px-8 py-3 bg-gray-800 hover:bg-gray-700 text-white rounded-xl font-bold transition">
                        Chapter Sebelumnya
                    </a>
                @endif

                @if($nextChapter)
                    <a href="{{ route('komik.read', [$comic['slug'], $nextChapter]) }}" class="px-8 py-3 bg-purple-600 hover:bg-purple-500 text-white rounded-xl font-bold transition shadow-lg shadow-purple-600/20">
                        Chapter Berikutnya
                    </a>
                @else
                    <a href="{{ route('komik.show', $comic['slug']) }}" class="px-8 py-3 bg-white text-gray-900 rounded-xl font-bold transition">
                        Kembali ke Detail
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Simple Floating Progress -->
<div class="fixed bottom-6 right-6 z-50 hidden md:block" x-data="{ percent: 0 }" @scroll.window="percent = Math.round((window.pageYOffset / (document.documentElement.scrollHeight - window.innerHeight)) * 100)">
    <div class="bg-gray-900/90 backdrop-blur-md border border-gray-800 p-3 rounded-full flex items-center gap-3 shadow-2xl">
        <div class="w-12 h-12 rounded-full border-4 border-gray-800 relative flex items-center justify-center">
            <svg class="absolute inset-0 w-full h-full -rotate-90">
                <circle cx="24" cy="24" r="20" fill="transparent" stroke="currentColor" stroke-width="4" class="text-purple-600" :style="`stroke-dasharray: 125.6; stroke-dashoffset: ${125.6 - (125.6 * percent / 100)}`"></circle>
            </svg>
            <span class="text-[10px] font-bold text-white" x-text="percent + '%'"></span>
        </div>
    </div>
</div>
@endsection
