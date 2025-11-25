@extends('layouts.app')

@section('title', 'Explore Komik - KOMIKIN')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10 min-h-screen">

    <!-- Header Section -->
    <div class="mb-8 border-b border-gray-800 pb-5">
        <h1 class="text-3xl font-extrabold text-white flex items-center">
            <span class="mr-3 text-purple-500">🔍</span> Explore Komik
        </h1>
        <p class="text-gray-400 mt-2 text-sm">Temukan bacaan baru dari ribuan koleksi kami.</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">

        {{-- 1. SIDEBAR FILTER (Sticky pada Desktop) --}}
        <aside class="w-full lg:w-1/4 h-fit lg:sticky lg:top-24">
            <div class="bg-gray-900 rounded-xl p-6 border border-gray-800 shadow-lg">
                <form method="GET" action="{{ route('explore.index') }}">
                    <div class="flex items-center justify-between mb-4 border-b border-gray-800 pb-2">
                        <h3 class="text-lg font-bold text-white">Filter</h3>
                        <button type="submit" class="text-xs text-purple-400 hover:text-purple-300">Terapkan</button>
                    </div>

                    {{-- Filter Genre --}}
                    <div class="mb-6">
                        <label class="block text-gray-400 text-xs font-bold uppercase tracking-wider mb-3">Genre</label>
                        <div class="space-y-2 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                            @foreach ($allGenres as $genre)
                                <label class="flex items-center group cursor-pointer">
                                    <div class="relative flex items-center">
                                        <input type="checkbox" name="genre[]" value="{{ $genre }}"
                                            class="peer appearance-none h-4 w-4 border border-gray-600 rounded bg-gray-800 checked:bg-purple-600 checked:border-purple-600 focus:ring-0 focus:ring-offset-0 transition"
                                            {{ in_array($genre, $selectedGenres) ? 'checked' : '' }}>
                                        <svg class="absolute w-3 h-3 text-white hidden peer-checked:block pointer-events-none left-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <span class="ml-2 text-sm text-gray-400 group-hover:text-white transition">{{ $genre }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Filter Status --}}
                    <div class="mb-6">
                        <label class="block text-gray-400 text-xs font-bold uppercase tracking-wider mb-3">Status</label>
                        <select name="status" class="w-full px-3 py-2 bg-gray-800 border border-gray-700 text-gray-200 text-sm rounded-lg focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition">
                            <option value="Semua" {{ $selectedStatus == 'Semua' ? 'selected' : '' }}>Semua Status</option>
                            <option value="Ongoing" {{ $selectedStatus == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                            <option value="Completed" {{ $selectedStatus == 'Completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-purple-600 text-white py-2.5 rounded-lg hover:bg-purple-700 font-bold text-sm transition shadow-lg shadow-purple-500/20">
                        Filter Hasil
                    </button>
                </form>
            </div>
        </aside>

        {{-- 2. KONTEN UTAMA --}}
        <div class="w-full lg:w-3/4">

            {{-- Toolbar: Search & Sort --}}
            <div class="bg-gray-900 p-4 rounded-xl border border-gray-800 mb-8 flex flex-col md:flex-row gap-4 justify-between items-center shadow-sm">
                
                {{-- Search Form --}}
                <form method="GET" action="{{ route('explore.index') }}" class="w-full md:flex-1 relative">
                    <!-- Hidden inputs untuk menjaga filter sidebar tetap aktif saat search -->
                    @foreach($selectedGenres as $genre)
                        <input type="hidden" name="genre[]" value="{{ $genre }}">
                    @endforeach
                    <input type="hidden" name="status" value="{{ $selectedStatus }}">
                    <input type="hidden" name="sort" value="{{ $sortBy }}">

                    <input type="text" name="search" value="{{ $searchTerm }}" placeholder="Cari judul komik..." 
                           class="w-full bg-gray-800 text-gray-200 pl-10 pr-4 py-2.5 rounded-lg border border-gray-700 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition text-sm">
                    <div class="absolute left-3 top-2.5 text-gray-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </form>

                {{-- Sort Dropdown --}}
                <form method="GET" action="{{ route('explore.index') }}" class="w-full md:w-auto">
                    <!-- Hidden inputs untuk menjaga filter & search tetap aktif saat sort -->
                    @foreach($selectedGenres as $genre)
                        <input type="hidden" name="genre[]" value="{{ $genre }}">
                    @endforeach
                    <input type="hidden" name="status" value="{{ $selectedStatus }}">
                    <input type="hidden" name="search" value="{{ $searchTerm }}">

                    <div class="flex items-center space-x-2">
                        <span class="text-xs text-gray-500 whitespace-nowrap hidden sm:inline">Urutkan:</span>
                        <select name="sort" onchange="this.form.submit()"
                            class="w-full md:w-48 px-3 py-2.5 bg-gray-800 border border-gray-700 text-gray-200 text-sm rounded-lg focus:outline-none focus:border-purple-500 cursor-pointer">
                            <option value="Terbaru" {{ $sortBy == 'Terbaru' ? 'selected' : '' }}>Terbaru Update</option>
                            <option value="Populer (All Time)" {{ $sortBy == 'Populer (All Time)' ? 'selected' : '' }}>Terpopuler</option>
                            <option value="Terbanyak Dibaca" {{ $sortBy == 'Terbanyak Dibaca' ? 'selected' : '' }}>Terbanyak Dibaca</option>
                            <option value="A-Z" {{ $sortBy == 'A-Z' ? 'selected' : '' }}>Abjad A-Z</option>
                        </select>
                    </div>
                </form>
            </div>

            {{-- Grid Daftar Komik (Clean Style) --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 xl:grid-cols-4 gap-x-5 gap-y-10">
                @forelse ($paginatedComics as $comic)
                    <div class="group relative cursor-pointer">
                        
                        <!-- Link Image Wrapper -->
                        <a href="#" class="block">
                            <div class="relative aspect-[3/4] rounded-xl overflow-hidden bg-gray-800 shadow-md transition-all duration-300 group-hover:shadow-purple-500/40 group-hover:-translate-y-1">
                                
                                {{-- Badge Status --}}
                                <div class="absolute top-0 left-0 z-10 px-2 py-1 text-[10px] font-bold text-white rounded-br-lg shadow-sm
                                    {{ $comic['status'] == 'Ongoing' ? 'bg-purple-600' : 'bg-blue-600' }}">
                                    {{ $comic['status'] }}
                                </div>

                                {{-- Image --}}
                                <img src="{{ asset($comic['cover']) }}" alt="{{ $comic['title'] }}" 
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                
                                {{-- Gradient Overlay Bawah (Subtle) --}}
                                <div class="absolute inset-x-0 bottom-0 h-1/4 bg-gradient-to-t from-gray-900/60 to-transparent pointer-events-none"></div>
                            </div>
                        </a>

                        <!-- Text Info -->
                        <div class="mt-3 px-1">
                            <a href="#" class="group-hover:text-purple-400 transition-colors duration-200">
                                <h3 class="text-gray-100 font-bold text-[15px] leading-snug line-clamp-2" title="{{ $comic['title'] }}">
                                    {{ $comic['title'] }}
                                </h3>
                            </a>
                            
                            <div class="mt-2 space-y-1">
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-gray-400">Chapter</span>
                                    <span class="text-purple-400 font-bold">{{ $comic['chapters'] }}</span>
                                </div>
                                <div class="text-[11px] text-gray-500 truncate">
                                    {{ is_array($comic['genre']) ? implode(', ', $comic['genre']) : $comic['genre'] }}
                                </div>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-20 text-center text-gray-500">
                        <div class="w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-white">Oops, Tidak Ditemukan</h3>
                        <p class="mt-1 text-sm">Coba kurangi filter atau gunakan kata kunci lain.</p>
                        <a href="{{ route('explore.index') }}" class="mt-4 px-5 py-2 bg-gray-800 hover:bg-gray-700 text-white rounded-lg text-sm transition">
                            Reset Filter
                        </a>
                    </div>
                @endforelse
            </div>

            {{-- Pagination Styling --}}
            <div class="mt-12">
                {{ $paginatedComics->links('pagination::tailwind') }} 
                {{-- Pastikan view pagination tailwind tersedia, atau gunakan default --}}
            </div>
            
        </div>
    </div>
</div>

<style>
    /* Custom Scrollbar untuk list Genre */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #1f2937; 
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #4b5563; 
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #6b7280; 
    }
</style>
@endsection