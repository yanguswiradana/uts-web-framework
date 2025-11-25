<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class KomikController extends Controller
{
    /**
     * PRIVATE METHOD: PUSAT DATA (SINGLE SOURCE OF TRUTH)
     * Semua data komik (Home, Explore, Library, Detail) diambil dari sini.
     */
    private function getComicData()
    {
        $rawComics = [
            // --- DATA DARI HOME/EXPLORE ---
            ['title' => 'Omniscient Reader’s Viewpoint', 'type' => 'Manhwa', 'chapters' => 289, 'genre' => 'Fantasy, System, Adventure', 'status' => 'Ongoing', 'rating' => 9.8, 'cover' => 'images/orv.jpg'],
            ['title' => 'Infinite Mage', 'type' => 'Manhwa', 'chapters' => 145, 'genre' => 'Action, Fantasy, Magic', 'status' => 'Ongoing', 'rating' => 9.2, 'cover' => 'images/infinite_mage.jpg'],
            ['title' => 'Nano Machine', 'type' => 'Manhwa', 'chapters' => 287, 'genre' => 'Murim, System, Supernatural', 'status' => 'Ongoing', 'rating' => 9.5, 'cover' => 'images/nano_machine.jpg'],
            ['title' => 'Pick Me Up', 'type' => 'Manhwa', 'chapters' => 176, 'genre' => 'Comedy, Action, Adventure', 'status' => 'Ongoing', 'rating' => 9.7, 'cover' => 'images/pick_me_up.jpg'],
            ['title' => 'Reality Quest', 'type' => 'Manhwa', 'chapters' => 179, 'genre' => 'Action, Fantasy, System', 'status' => 'Ongoing', 'rating' => 9.1, 'cover' => 'images/reality_quest.jpg'],
            ['title' => 'The World After The Fall', 'type' => 'Manhwa', 'chapters' => 209, 'genre' => 'Adventure, Fantasy, Action', 'status' => 'Ongoing', 'rating' => 9.2, 'cover' => 'images/World_after_the_fall.jpg'],
            ['title' => 'Return of the Mount Hua Sect', 'type' => 'Manhwa', 'chapters' => 152, 'genre' => 'Murim, Action, Comedy', 'status' => 'Ongoing', 'rating' => 9.9, 'cover' => 'images/return_of_the_mount_hua_sect.jpg'],

            // --- DATA TAMBAHAN DARI LIBRARY KAMU ---
            ['title' => 'Bones', 'type' => 'Manhwa', 'chapters' => 30, 'genre' => 'Action, Gore, Thriller', 'status' => 'Ongoing', 'rating' => 8.8, 'cover' => 'images/bones.jpg'],
            ['title' => 'Star Ginseng Store', 'type' => 'Manhwa', 'chapters' => 186, 'genre' => 'Drama, Slice of Life', 'status' => 'Ongoing', 'rating' => 8.5, 'cover' => 'images/star_ginseng_store.jpg'],
            ['title' => 'My Bias Gets On The Last Train', 'type' => 'Manhwa', 'chapters' => 54, 'genre' => 'Romance, Fantasy', 'status' => 'Ongoing', 'rating' => 8.7, 'cover' => 'images/mykisah.jpg'],

            // --- DATA DUMMY MANGA/MANHUA ---
            ['title' => 'One Piece', 'type' => 'Manga', 'chapters' => 1100, 'genre' => 'Adventure, Action', 'status' => 'Ongoing', 'rating' => 9.9, 'cover' => 'https://via.placeholder.com/300x400?text=One+Piece'],
            ['title' => 'Jujutsu Kaisen', 'type' => 'Manga', 'chapters' => 250, 'genre' => 'Action, Supernatural', 'status' => 'Ongoing', 'rating' => 9.4, 'cover' => 'https://via.placeholder.com/300x400?text=JJK'],
            ['title' => 'Magic Emperor', 'type' => 'Manhua', 'chapters' => 500, 'genre' => 'Cultivation, Action', 'status' => 'Ongoing', 'rating' => 9.5, 'cover' => 'https://via.placeholder.com/300x400?text=Magic+Emperor'],
            ['title' => 'Tales of Demons and Gods', 'type' => 'Manhua', 'chapters' => 450, 'genre' => 'Cultivation, Fantasy', 'status' => 'Ongoing', 'rating' => 9.0, 'cover' => 'https://via.placeholder.com/300x400?text=Tales+Demons'],
        ];

        return collect($rawComics)->map(function ($data) {
            $slug = Str::slug($data['title']);

            // Pastikan cover ada
            if (!isset($data['cover']) || empty($data['cover'])) {
                $data['cover'] = 'https://via.placeholder.com/300x400/1f2937/FFFFFF?text=No+Cover';
            }

            return array_merge($data, [
                'slug' => $slug,
                // Default synopsis jika belum ada
                'synopsis' => "Sinopsis default untuk komik " . $data['title'] . ". Cerita seru yang wajib kamu baca!"
            ]);
        });
    }

    // --- 1. HALAMAN HOME ---
    public function home()
    {
        $allComics = $this->getComicData();

        $manga = $allComics->where('type', 'Manga')->values()->take(6);
        $manhwa = $allComics->where('type', 'Manhwa')->values()->take(6);
        $manhua = $allComics->where('type', 'Manhua')->values()->take(6);
        $latestUpdates = $allComics->shuffle()->take(12);

        return view('home', compact('manga', 'manhwa', 'manhua', 'latestUpdates'));
    }

    // --- 2. HALAMAN EXPLORE ---
    public function index(Request $request)
    {
        $allComics = $this->getComicData();

        // Parameter Filter
        $selectedGenres = (array) $request->input('genre', []);
        $selectedStatus = $request->input('status', 'Semua');
        $searchTerm = $request->input('search', '');
        $sortBy = $request->input('sort', 'Terbaru');

        // Logic Filter
        $filteredComics = $allComics->filter(function ($comic) use ($selectedGenres, $selectedStatus, $searchTerm) {
            $comicGenresStr = is_array($comic['genre']) ? implode(',', $comic['genre']) : $comic['genre'];
            $comicGenres = array_map('trim', explode(',', $comicGenresStr));
            $comicGenresLower = array_map('mb_strtolower', $comicGenres);
            $selectedLower = array_map('mb_strtolower', $selectedGenres);

            $genreMatch = empty($selectedGenres) || count(array_intersect($comicGenresLower, $selectedLower)) > 0;
            $statusMatch = ($selectedStatus == 'Semua') || ($comic['status'] == $selectedStatus);
            $searchMatch = empty($searchTerm) || (stripos($comic['title'], $searchTerm) !== false);

            return $genreMatch && $statusMatch && $searchMatch;
        });

        // Logic Sort
        switch ($sortBy) {
            case 'Populer (All Time)': $filteredComics = $filteredComics->sortByDesc('chapters'); break;
            case 'Terbanyak Dibaca': $filteredComics = $filteredComics->sortByDesc('rating'); break;
            case 'A-Z': $filteredComics = $filteredComics->sortBy('title'); break;
            case 'Terbaru': default: $filteredComics = $filteredComics->reverse(); break;
        }

        // Pagination
        $currentPage = Paginator::resolveCurrentPage();
        $perPage = 12;
        $currentPageItems = $filteredComics->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $paginatedComics = new LengthAwarePaginator(
            $currentPageItems, $filteredComics->count(), $perPage, $currentPage,
            ['path' => Paginator::resolveCurrentPath(), 'query' => $request->query()]
        );

        $allGenres = ['Action', 'Fantasy', 'Romance', 'Comedy', 'Horror', 'Slice of Life', 'Sci-Fi', 'Drama', 'Adventure', 'Cultivation', 'Gore', 'System', 'Magic', 'Murim', 'Supernatural'];

        return view('pages.explore', compact('paginatedComics', 'allGenres', 'selectedGenres', 'selectedStatus', 'searchTerm', 'sortBy'));
    }

    // --- 3. HALAMAN LIBRARY (BARU) ---
    public function library(Request $request)
    {
        $allComics = $this->getComicData();
        $searchTerm = $request->input('search');

        // DAFTAR JUDUL FAVORIT (Simulasi Database User Favorites)
        // Kita hanya mengambil data yang judulnya ada di list ini
        $myFavoriteTitles = [
            'Bones',
            'Star Ginseng Store',
            'My Bias Gets On The Last Train',
            'Pick Me Up',
            'Nano Machine',
            'Reality Quest'
        ];

        // 1. Ambil komik yang sesuai dengan daftar favorit
        $favoriteComics = $allComics->filter(function($comic) use ($myFavoriteTitles) {
            return in_array($comic['title'], $myFavoriteTitles);
        });

        // 2. Jika ada pencarian di dalam Library
        if ($searchTerm) {
            $favoriteComics = $favoriteComics->filter(function($comic) use ($searchTerm) {
                return stripos($comic['title'], $searchTerm) !== false;
            });
        }

        return view('pages.library', compact('favoriteComics'));
    }

    // --- 4. HALAMAN DETAIL ---
    public function show($slug)
    {
        $allComics = $this->getComicData();
        $comic = $allComics->firstWhere('slug', $slug);

        if (!$comic) {
            abort(404);
        }

        // Dummy Chapters
        $chapters = [];
        $totalChapters = $comic['chapters'];
        for ($i = $totalChapters; $i >= 1; $i--) {
            $daysAgo = ($totalChapters - $i) * 2;
            $chapters[] = [
                'number' => $i,
                'title' => null,
                'date' => now()->subDays($daysAgo)->diffForHumans(),
                'image' => $comic['cover'],
                'is_new' => $i > ($totalChapters - 3)
            ];
        }
        $latestChapters = array_slice($chapters, 0, 12);

        return view('pages.detail', compact('comic', 'chapters', 'latestChapters'));
    }
}
