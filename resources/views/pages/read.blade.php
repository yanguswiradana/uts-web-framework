@extends('layouts.app')

@section('title', 'Baca ' . $comic->title . ' Chapter ' . $chapterNumber . ' - KOMIKIN')

@section('content')
<div class="bg-gray-950 min-h-screen pb-20">
    
    <div class="sticky top-0 z-50 bg-gray-900/90 backdrop-blur-md border-b border-gray-800 py-3 shadow-lg">
        <div class="container mx-auto px-4 flex flex-col md:flex-row md:items-center justify-between gap-4">
            
            {{-- Tombol Back & Judul --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('komik.show', $comic->slug) }}" class="p-2 hover:bg-gray-800 rounded-lg transition text-gray-400 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-white font-bold text-sm md:text-base line-clamp-1">{{ $comic->title }}</h1>
                    <p class="text-purple-400 text-xs font-medium">Chapter {{ $chapterNumber }}</p>
                </div>
            </div>

            {{-- Tombol Prev/Next --}}
            <div class="flex items-center justify-center gap-2">
                @if($prevChapter)
                    <a href="{{ route('komik.read', [$comic->slug, $prevChapter]) }}" class="px-4 py-2 bg-gray-800 hover:bg-purple-600 text-white rounded-lg text-sm font-bold transition flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Prev
                    </a>
                @else
                    <button disabled class="px-4 py-2 bg-gray-800/50 text-gray-600 rounded-lg text-sm font-bold cursor-not-allowed opacity-50">Prev</button>
                @endif

                <div class="relative group">
                    <button class="px-6 py-2 bg-gray-800 text-white rounded-lg text-sm font-bold flex items-center gap-2 border border-gray-700">
                        Ch. {{ $chapterNumber }}
                    </button>
                </div>

                @if($nextChapter)
                    <a href="{{ route('komik.read', [$comic->slug, $nextChapter]) }}" class="px-4 py-2 bg-gray-800 hover:bg-purple-600 text-white rounded-lg text-sm font-bold transition flex items-center gap-2">
                        Next
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                @else
                    <button disabled class="px-4 py-2 bg-gray-800/50 text-gray-600 rounded-lg text-sm font-bold cursor-not-allowed opacity-50">Next</button>
                @endif
            </div>
        </div>
    </div>

    <div class="container mx-auto mt-0 flex flex-col items-center max-w-4xl bg-black min-h-screen">
        <div class="w-full space-y-0 shadow-2xl shadow-purple-500/5">
            @forelse($chapterImages as $image)
                <div class="relative group w-full">
                    {{-- Lazy Loading untuk performa --}}
                    <img src="{{ $image }}" 
                         alt="Page {{ $loop->iteration }}" 
                         class="w-full h-auto block select-none" 
                         loading="lazy">
                </div>
            @empty
                <div class="py-20 text-center text-gray-500">
                    <p>Tidak ada gambar di chapter ini.</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="container mx-auto px-4 mt-12 pb-12 flex flex-col items-center">
        <div class="bg-gray-900 p-8 rounded-2xl border border-gray-800 text-center w-full max-w-2xl">
            <h3 class="text-white font-bold text-xl mb-4">Chapter Selesai!</h3>
            <p class="text-gray-400 mb-8">Apa langkah selanjutnya?</p>
            
            <div class="flex flex-wrap justify-center gap-4">
                @if($prevChapter)
                    <a href="{{ route('komik.read', [$comic->slug, $prevChapter]) }}" class="px-6 py-3 bg-gray-800 hover:bg-gray-700 text-white rounded-xl font-bold transition border border-gray-700">
                        &laquo; Chapter Sebelumnya
                    </a>
                @endif

                @if($nextChapter)
                    <a href="{{ route('komik.read', [$comic->slug, $nextChapter]) }}" class="px-8 py-3 bg-purple-600 hover:bg-purple-500 text-white rounded-xl font-bold transition shadow-lg shadow-purple-600/20">
                        Chapter Berikutnya &raquo;
                    </a>
                @else
                    <a href="{{ route('komik.show', $comic->slug) }}" class="px-8 py-3 bg-white hover:bg-gray-200 text-gray-900 rounded-xl font-bold transition">
                        Kembali ke Detail
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="fixed bottom-6 right-6 z-40 hidden md:block" 
     x-data="{ percent: 0 }" 
     @scroll.window="percent = Math.round((window.pageYOffset / (document.documentElement.scrollHeight - window.innerHeight)) * 100)">
    
    <div class="bg-gray-900/90 backdrop-blur-md border border-gray-800 p-3 rounded-full flex items-center gap-3 shadow-2xl cursor-pointer hover:bg-gray-800 transition"
         @click="window.scrollTo({top: 0, behavior: 'smooth'})">
        <div class="w-10 h-10 rounded-full border-4 border-gray-800 relative flex items-center justify-center">
            <svg class="absolute inset-0 w-full h-full -rotate-90">
                <circle cx="20" cy="20" r="16" fill="transparent" stroke="currentColor" stroke-width="4" class="text-gray-700"></circle>
                <circle cx="20" cy="20" r="16" fill="transparent" stroke="currentColor" stroke-width="4" class="text-purple-500 transition-all duration-100" 
                        :style="`stroke-dasharray: 100; stroke-dashoffset: ${100 - percent}`"></circle>
            </svg>
            <span class="text-[10px] font-bold text-white" x-text="percent + '%'"></span>
        </div>
    </div>
</div>
@endsection