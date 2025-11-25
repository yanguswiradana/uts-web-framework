<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class KomikController extends Controller
{
    public function index(Request $request)
    {
        // 1. DATA MASTER (Dipindahkan dari View)
        // Perhatikan perbaikan struktur pada 'Omniscient Reader’s Viewpoint'
        $covers = [
            'images/orv.jpg', 'images/infinite_mage.jpg', 'images/nano_machine.jpg',
            'images/bones.jpg', 'images/cosmic_heavenly_demon_3077.jpg', 'images/mykisah.jpg',
            'images/pick_me_up.jpg', 'images/reality_quest.jpg', 'images/reicarnated_demon_god.jpg',
            'images/return_of_the_disaster_class_hero.jpg', 'images/return_of_the_mount_hua_sect.jpg',
            'images/star_ginseng_store.jpg', 'images/The_Extra.jpg', 'images/villain_to_kill.jpg',
            'images/raja_rasis.jpg', 'images/solo_max_level_newbie.jpg', 'images/kuli.jpg',
            'images/return_of_the_mad_demon.jpg', 'images/World_after_the_fall.jpg', 'images/The_ultimate_of_all_ages.jpg',
        ];

        $comicData = [
            // FIX: Genre digabung jadi satu string atau array yang valid
            ['title' => 'Omniscient Reader’s Viewpoint', 'chapters' => 289, 'genre' => 'Fantasy, System, Adventure', 'status' => 'Ongoing'],
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

        // Merge Data
        $allComics = collect($comicData)->map(function ($data, $index) use ($covers) {
            // Cek biar tidak error index offset jika jumlah cover < jumlah data
            $coverImg = isset($covers[$index]) ? $covers[$index] : 'images/default.jpg';
            return array_merge($data, ['cover' => $coverImg]);
        });

        // 2. LOGIKA FILTER
        $selectedGenres = (array) $request->input('genre', []);
        $selectedStatus = $request->input('status', 'Semua');
        $searchTerm = $request->input('search', '');
        $sortBy = $request->input('sort', 'Terbaru');

        $filteredComics = $allComics->filter(function ($comic) use ($selectedGenres, $selectedStatus, $searchTerm) {
            // Normalize genre
            $comicGenresStr = is_array($comic['genre']) ? implode(',', $comic['genre']) : $comic['genre'];
            $comicGenres = array_map('trim', explode(',', $comicGenresStr));
            
            $comicGenresLower = array_map('mb_strtolower', $comicGenres);
            $selectedLower = array_map('mb_strtolower', $selectedGenres);

            // Filter Logic
            $genreMatch = empty($selectedGenres) || count(array_intersect($comicGenresLower, $selectedLower)) > 0;
            $statusMatch = ($selectedStatus == 'Semua') || ($comic['status'] == $selectedStatus);
            $searchMatch = empty($searchTerm) || (stripos($comic['title'], $searchTerm) !== false);

            return $genreMatch && $statusMatch && $searchMatch;
        });

        // 3. LOGIKA SORTING
        switch ($sortBy) {
            case 'Populer (All Time)':
                $filteredComics = $filteredComics->sortByDesc('chapters');
                break;
            case 'Terbanyak Dibaca':
                $filteredComics = $filteredComics->shuffle(); // Simulasi random
                break;
            case 'A-Z':
                $filteredComics = $filteredComics->sortBy('title');
                break;
            case 'Terbaru':
            default:
                $filteredComics = $filteredComics->reverse();
                break;
        }

        // 4. PAGINATION MANUAL (Wajib karena kita pakai Array/Collection, bukan Database)
        $currentPage = Paginator::resolveCurrentPage();
        $perPage = 10; // Jumlah item per halaman
        $currentPageItems = $filteredComics->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $paginatedComics = new LengthAwarePaginator(
            $currentPageItems,
            $filteredComics->count(),
            $perPage,
            $currentPage,
            [
                'path' => Paginator::resolveCurrentPath(),
                'query' => $request->query(), // Penting: Menyimpan parameter filter saat pindah halaman
            ]
        );

        $allGenres = ['Action', 'Fantasy', 'Romance', 'Comedy', 'Horror', 'Slice of Life', 'Sci-Fi', 'Drama', 'Adventure', 'Cultivation', 'Gore', 'System', 'Magic', 'Murim', 'Supernatural'];

        // Kirim semua variabel ke View
        return view('pages.explore', compact('paginatedComics', 'allGenres', 'selectedGenres', 'selectedStatus', 'searchTerm', 'sortBy'));
    }
}