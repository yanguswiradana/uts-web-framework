@extends('layouts.app')

@section('title', 'Explore Komik - KOMIKIN')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <h1 class="text-4xl font-extrabold text-white mb-8 border-b border-purple-500 pb-3">Explore Komik Terbaru</h1>

    <div class="flex flex-col lg:flex-row gap-6">

        {{-- 1. SIDEBAR FILTER --}}
        <aside class="w-full lg:w-1/4 p-6 bg-gray-800 rounded-lg shadow-xl border border-gray-700 hidden lg:block">
            <form method="GET" action="{{ route('explore.index') }}">
                <h3 class="text-xl font-bold text-white mb-4 border-b border-gray-700 pb-2">Filter</h3>

                {{-- Filter Genre --}}
                <div class="mb-6">
                    <label class="block text-gray-200 font-semibold mb-2">Genre</label>
                    <div class="grid grid-cols-2 gap-2 text-sm max-h-60 overflow-y-auto pr-2">
                        @foreach ($allGenres as $genre)
                            <label class="flex items-center text-gray-400 hover:text-purple-400 cursor-pointer">
                                <input type="checkbox" name="genre[]" value="{{ $genre }}"
                                    class="form-checkbox h-4 w-4 text-purple-600 bg-gray-900 border-gray-600 rounded mr-2 focus:ring-purple-500"
                                    {{ in_array($genre, $selectedGenres) ? 'checked' : '' }}>
                                {{ $genre }}
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Filter Status --}}
                <div class="mb-6">
                    <label class="block text-gray-200 font-semibold mb-2">Status</label>
                    <select name="status" class="w-full p-2 bg-gray-900 border border-gray-700 text-gray-200 rounded-lg focus:border-purple-500 focus:ring-purple-500">
                        <option class="bg-gray-800" value="Semua" {{ $selectedStatus == 'Semua' ? 'selected' : '' }}>Semua</option>
                        <option class="bg-gray-800" value="Ongoing" {{ $selectedStatus == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                        <option class="bg-gray-800" value="Completed" {{ $selectedStatus == 'Completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>

                <button type="submit" class="w-full bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700 font-semibold transition duration-150">
                    Terapkan Filter
                </button>
            </form>
        </aside>

        {{-- 2. KONTEN UTAMA --}}
        <div class="w-full lg:w-3/4">

            {{-- Form Pencarian dan Sorting --}}
            <form method="GET" action="{{ route('explore.index') }}" class="flex flex-col sm:flex-row justify-between items-center gap-2 mb-6 p-4 bg-gray-800 rounded-lg border border-gray-700">
                
                {{-- Input Pencarian --}}
                <input type="text" name="search" placeholder="Cari Judul Komik..." value="{{ $searchTerm }}"
                    class="flex-1 p-2 bg-gray-900 border border-gray-700 text-gray-200 rounded-lg focus:border-purple-500 focus:ring-purple-500 text-sm">
                
                {{-- Input Sorting --}}
                <select name="sort" onchange="this.form.submit()"
                    class="p-2 bg-gray-900 border border-gray-700 text-gray-200 rounded-lg text-sm focus:border-purple-500 focus:ring-purple-500">
                    <option class="bg-gray-800" value="Terbaru" {{ $sortBy == 'Terbaru' ? 'selected' : '' }}>Terbaru</option>
                    <option class="bg-gray-800" value="Populer (All Time)" {{ $sortBy == 'Populer (All Time)' ? 'selected' : '' }}>Populer (All Time)</option>
                    <option class="bg-gray-800" value="Terbanyak Dibaca" {{ $sortBy == 'Terbanyak Dibaca' ? 'selected' : '' }}>Terbanyak Dibaca</option>
                    <option class="bg-gray-800" value="A-Z" {{ $sortBy == 'A-Z' ? 'selected' : '' }}>A-Z</option>
                </select>

                {{-- Tombol Cari --}}
                <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 font-semibold transition duration-150 text-sm whitespace-nowrap">
                    Cari
                </button>

                {{-- Hidden Inputs (untuk mempertahankan filter sidebar saat search/sort) --}}
                @foreach($selectedGenres as $genre)
                    <input type="hidden" name="genre[]" value="{{ $genre }}">
                @endforeach
                <input type="hidden" name="status" value="{{ $selectedStatus }}">

            </form>

            {{-- Daftar Komik --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-6">
                @forelse ($paginatedComics as $comic)
                    <div class="bg-gray-800 rounded-lg shadow-xl overflow-hidden transition transform hover:scale-[1.03] duration-300 comic-card border border-gray-700 group">
                        <div class="relative aspect-2/3 overflow-hidden">
                            <img src="{{ asset($comic['cover']) }}" alt="{{ $comic['title'] }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            {{-- Overlay Status --}}
                            <span class="absolute top-2 right-2 px-2 py-1 text-xs font-bold rounded {{ $comic['status'] == 'Ongoing' ? 'bg-green-600 text-white' : 'bg-blue-600 text-white' }}">
                                {{ $comic['status'] }}
                            </span>
                        </div>
                        <div class="p-3">
                            <h3 class="font-semibold text-white truncate text-base mb-1" title="{{ $comic['title'] }}">{{ $comic['title'] }}</h3>
                            <p class="text-xs text-gray-400 mb-1">Chapter: <span class="text-purple-400 font-bold">{{ $comic['chapters'] }}</span></p>
                            
                            {{-- Render Genre dengan aman --}}
                            <p class="text-xs text-gray-500 truncate">
                                {{ is_array($comic['genre']) ? implode(', ', $comic['genre']) : $comic['genre'] }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center p-12 bg-gray-800 rounded-lg border border-gray-700 text-center">
                        <svg class="w-16 h-16 text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <h3 class="text-lg font-medium text-gray-300">Tidak ada komik ditemukan</h3>
                        <p class="text-gray-500 mt-1">Coba kurangi filter atau cari kata kunci lain.</p>
                        <a href="{{ route('explore.index') }}" class="mt-4 px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-600 transition">Reset Filter</a>
                    </div>
                @endforelse
            </div>

            {{-- Pagination (Otomatis dari Laravel) --}}
            <div class="mt-10 px-4">
                {{ $paginatedComics->links() }}
            </div>
            
        </div>
    </div>
</div>
@endsection