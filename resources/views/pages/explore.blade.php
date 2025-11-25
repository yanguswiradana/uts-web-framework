@extends('layouts.app')

@section('title', 'Explore Komik - KOMIKIN')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <h1 class="text-4xl font-extrabold text-white mb-8 border-b border-purple-500 pb-3">Explore Komik Terbaru</h1>

    <div class="flex flex-col lg:flex-row gap-8">

@php
    // --- DATA KOMIK LENGKAP (Data Anda yang sudah disiapkan sebelumnya) ---
    $covers = [
        'images/orv.jpg',
        'images/infinite_mage.jpg',
        'images/nano_machine.jpg',
        'images/bones.jpg',
        'images/cosmic_heavenly_demon_3077.jpg',
        'images/mykisah.jpg',
        'images/pick_me_up.jpg',
        'images/reality_quest.jpg',
        'images/reicarnated_demon_god.jpg',
        'images/return_of_the_disaster_class_hero.jpg',
        'images/return_of_the_mount_hua_sect.jpg',
        'images/star_ginseng_store.jpg',
        'images/The_Extra.jpg',
        'images/villain_to_kill.jpg',
        'images/raja_rasis.jpg',
        'images/solo_max_level_newbie.jpg',
        'images/kuli.jpg',
        'images/return_of_the_mad_demon.jpg',
        'images/World_after_the_fall.jpg',
        'images/The_ultimate_of_all_ages.jpg',
    ];

    $comicData = [
        ['title' => 'Omniscient Reader’s Viewpoint', 'chapters' => 289, 'genre' => 'Fantasy', 'System', 'Adventure' , 'status' => 'Ongoing'],
        ['title' => 'Infinite Mage', 'chapters' => 145, 'genre' => 'Action, Fantasy, Magic', 'status' => 'Ongoing'],
        ['title' => 'Nano Machine', 'chapters' => 287, 'genre' => 'Murim, System, Supernatural', 'status' => 'Ongoing'],
        ['title' => 'Bones', 'chapters' => 30, 'genre' => 'Adventure, Gore, Action', 'status' => 'Ongoing'],
        ['title' => 'Cosmic Heavenly Demon 3077', 'chapters' => 65, 'genre' => 'Sci-Fi, Murim, Cultivation', 'status' => 'Ongoing'],
        ['title' => 'My Bias Gets On The Last Train', 'chapters' => 450, 'genre' => 'Romance, Comedy, Drama', 'status' => 'Ongoing'],
        ['title' => 'Pick Me Up', 'chapters' => 176, 'genre' => 'Comedy, Action, Adventure', 'status' => 'Ongoing'],
        ['title' => 'Reality Quest', 'chapters' => 179, 'genre' => 'Action, Fantasy, System', 'status' => 'Ongoing'],
        ['title' => 'Chronicles Of The Reincarnated Demon God', 'chapters' => 58, 'genre' => 'Action, Murim, Fantasy', 'status' => 'Completed'],
        ['title' => 'The Return of The Disaster Class Hero', 'chapters' => 152, 'genre' => 'Action, Adventure, comedy', 'status' => 'Ongoing'],
        ['title' => 'Return of the Mount Hua Sect', 'chapters' => 152, 'genre' => 'Murim, Action, Comedy', 'status' => 'Completed'],
        ['title' => 'Star Ginseng Store', 'chapters' => 186, 'genre' => 'Slice of Life, Romance, Drama', 'status' => 'Ongoing'],
        ['title' => 'The Extra’s Academy Survival Guide', 'chapters' => 82, 'genre' => 'Fantasy, Action, Adventure', 'status' => 'Completed'],
        ['title' => 'Villain To Kill', 'chapters' => 209, 'genre' => 'Supernatural, Action, Fantasy', 'status' => 'Ongoing'],
        ['title' => 'The Knight King Who Returned With A God', 'chapters' => 139, 'genre' => 'Action, Adventure, Fantasy', 'status' => 'Ongoing'],
        ['title' => 'Solo Max-Level Newbie', 'chapters' => 233, 'genre' => 'System, Action, Adventure, Fantasy', 'status' => 'Ongoing'],
        ['title' => 'The Greatest Estate Developer', 'chapters' => 216, 'genre' => 'Drama, Comedy, Action, Fantasy', 'status' => 'Ongoing'],
        ['title' => 'The Return Of the Crazy Demon', 'chapters' => 179, 'genre' => 'Murim, Action, Comedy, Adventure', 'status' => 'Ongoing'],
        ['title' => 'The World After The Fall', 'chapters' => 209, 'genre' => 'Adventure, Fantasy, Action', 'status' => 'Ongoing'],
        ['title' => 'The Ultimate of All Ages', 'chapters' => 479, 'genre' => 'Cultivation, Action, Fantasy, Adventure', 'status' => 'Ongoing'],
    ];

    // Gabungkan data komik dan cover menjadi satu array (lebih mudah di-filter)
    $allComics = collect($comicData)->map(function ($data, $index) use ($covers) {
        return array_merge($data, ['cover' => $covers[$index]]);
    });

    // --- LOGIKA FILTER BERDASARKAN QUERY PARAMETER ---

    // Ambil input dari URL (misalnya: ?genre[]=Action&status=Ongoing&search=solo)
    // Pastikan selalu array (jika user hanya memilih 1 genre, request bisa mengembalikan string)
    $selectedGenres = (array) request('genre', []);
    $selectedStatus = request('status', 'Semua');
    $searchTerm = request('search', '');
    $sortBy = request('sort', 'Terbaru');

    $filteredComics = $allComics->filter(function ($comic) use ($selectedGenres, $selectedStatus, $searchTerm) {
        // Normalize genre(s) pada data komik ke array
        if (is_array($comic['genre'])) {
            $comicGenres = array_map('trim', $comic['genre']);
        } else {
            // Jika string, dipisah berdasarkan koma
            $comicGenres = array_map('trim', explode(',', $comic['genre']));
        }

        // Lowercase semua untuk perbandingan case-insensitive
        $comicGenresLower = array_map('mb_strtolower', $comicGenres);
        $selectedLower = array_map('mb_strtolower', $selectedGenres);

        // Filter Genre: Jika tidak ada genre yang dipilih ATAU ada intersection antara genre komik dan yang dipilih
        $genreMatch = empty($selectedGenres) || count(array_intersect($comicGenresLower, $selectedLower)) > 0;

        // Filter Status: Jika status 'Semua' ATAU status komik cocok dengan status yang dipilih
        $statusMatch = ($selectedStatus == 'Semua') || ($comic['status'] == $selectedStatus);

        // Filter Pencarian: Jika tidak ada input pencarian ATAU judul komik mengandung kata kunci
        $searchMatch = empty($searchTerm) || (stripos($comic['title'], $searchTerm) !== false);

        return $genreMatch && $statusMatch && $searchMatch;
    });

    // --- LOGIKA SORTING (Pengurutan) ---
    switch ($sortBy) {
        case 'Populer (All Time)':
            // Logika sorting populer (di dunia nyata, ini akan didasarkan pada kolom view_count)
            $filteredComics = $filteredComics->sortByDesc('chapters'); // Contoh: Populer = Chapter banyak
            break;
        case 'Terbanyak Dibaca':
            // Logika sorting terbanyak dibaca
            $filteredComics = $filteredComics->shuffle(); // Placeholder random
            break;
        case 'A-Z':
            $filteredComics = $filteredComics->sortBy('title');
            break;
        case 'Terbaru':
        default:
            $filteredComics = $filteredComics->reverse(); // Membalik urutan untuk simulasi terbaru
            break;
    }

    $allGenres = ['Action', 'Fantasy', 'Romance', 'Comedy', 'Horror', 'Slice of Life', 'Sci-Fi', 'Drama', 'Adventure', 'Cultivation', 'Gore', 'System', 'Magic', 'Murim', 'Supernatural'];
@endphp

<div class="flex flex-col lg:flex-row gap-6">

    {{-- 1. SIDEBAR FILTER (Dibungkus dalam FORM) --}}
    <aside class="w-full lg:w-1/4 p-6 bg-gray-800 rounded-lg shadow-xl border border-gray-700 hidden lg:block">
        <form method="GET" action="{{ url()->current() }}">
            <h3 class="text-xl font-bold text-white mb-4 border-b border-gray-700 pb-2">Filter</h3>

            {{-- Filter Genre --}}
            <div class="mb-6">
                <label class="block text-gray-200 font-semibold mb-2">Genre</label>
                <div class="grid grid-cols-2 gap-2 text-sm max-h-60 overflow-y-auto pr-2">
                    @foreach ($allGenres as $genre)
                        <label class="flex items-center text-gray-400 hover:text-purple-400 cursor-pointer">
                            {{-- NAME WAJIB ARRAY: genre[] --}}
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

    {{-- 2. KONTEN UTAMA (Pencarian & Daftar Komik) --}}
    <div class="w-full lg:w-3/4">

        {{-- Form Pencarian dan Sorting --}}
        <form method="GET" action="{{ url()->current() }}" class="flex flex-col sm:flex-row justify-between items-center gap-2 mb-6 p-4 bg-gray-800 rounded-lg border border-gray-700">
            
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

            {{-- Submit Button --}}
            <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 font-semibold transition duration-150 text-sm whitespace-nowrap">
                Cari
            </button>

            {{-- Input tersembunyi untuk mempertahankan filter genre dan status saat sorting/search --}}
            @foreach($selectedGenres as $genre)
                <input type="hidden" name="genre[]" value="{{ $genre }}">
            @endforeach
            <input type="hidden" name="status" value="{{ $selectedStatus }}">

        </form>

        {{-- Daftar Komik yang Difilter --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-6">
            @forelse ($filteredComics as $comic)
                <div class="bg-gray-800 rounded-lg shadow-xl overflow-hidden transition transform hover:scale-[1.03] duration-300 comic-card border border-gray-700">
                    <img src="{{ asset($comic['cover']) }}" alt="Cover Komik {{ $comic['title'] }}" class="w-full aspect-2/3 object-cover">
                    <div class="p-3">
                        <h3 class="font-semibold text-white truncate text-base">{{ $comic['title'] }}</h3>
                        <p class="text-sm text-purple-400">Chapter: {{ $comic['chapters'] }} | {{ $comic['genre'] }}</p>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center p-8 bg-gray-800 rounded-lg border border-gray-700">
                    <p class="text-lg text-gray-400">Tidak ada komik yang ditemukan dengan filter tersebut.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="flex justify-center items-center space-x-2 mt-10">
            <a href="#" class="py-2 px-3 border border-gray-700 rounded-lg text-gray-400 hover:bg-gray-800 transition duration-150 text-sm">
                &laquo; Prev
            </a>
            <a href="#" class="py-2 px-4 border border-purple-500 rounded-lg bg-purple-600 text-white font-bold text-sm">1</a>
            <a href="#" class="py-2 px-4 border border-gray-700 rounded-lg bg-gray-800 hover:bg-gray-700 text-gray-200 text-sm">2</a>
            <span class="py-2 px-4 text-gray-500 text-sm">...</span>
            <a href="#" class="py-2 px-3 border border-gray-700 rounded-lg text-gray-400 hover:bg-gray-800 transition duration-150 text-sm">
                Next &raquo;
            </a>
        </div>
    </div>
</div>
</div>
@endsection