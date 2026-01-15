<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comic;
use App\Models\Chapter;
use App\Models\Genre;

class KomikController extends Controller
{
    /**
     * HALAMAN HOME
     * Menampilkan kategori komik dan update chapter terbaru.
     */
    public function home()
    {
        // 1. Ambil Semua Komik (Eager Load Genre & Hitung Chapter)
        $allComics = Comic::with('genres')->withCount('chapters')->latest()->get();

        // 2. Pisahkan per Kategori (Limit 6 per kategori)
        $manga = $allComics->where('type', 'Manga')->take(6);
        $manhwa = $allComics->where('type', 'Manhwa')->take(6);
        $manhua = $allComics->where('type', 'Manhua')->take(6);

        // 3. Update Terbaru (Berdasarkan Chapter yang baru diupload)
        // Kita ambil 12 chapter terakhir, lalu ambil data komiknya
        $latestUpdates = Chapter::with('comic')
            ->latest()
            ->take(12)
            ->get()
            ->map(function ($chapter) {
                // Kita "pinjam" object comic-nya, lalu tempel data chapter terbaru
                $comic = $chapter->comic;
                if ($comic) {
                    $comic->latest_chapter = $chapter->number;
                    $comic->updated_time = $chapter->created_at->diffForHumans();
                }
                return $comic;
            })->filter(); // Filter null jika ada komik yang terhapus

        return view('home', compact('manga', 'manhwa', 'manhua', 'latestUpdates'));
    }

    /**
     * HALAMAN EXPLORE
     * Pencarian, Filter Genre, Status, dan Sorting.
     */
    public function index(Request $request)
    {
        // Query Dasar
        $query = Comic::with('genres')->withCount('chapters');

        // 1. Filter Genre (Many-to-Many)
        if ($request->has('genre')) {
            $genres = (array) $request->input('genre');
            if (!empty($genres)) {
                $query->whereHas('genres', function ($q) use ($genres) {
                    $q->whereIn('name', $genres);
                });
            }
        }

        // 2. Filter Status
        if ($request->has('status') && $request->status != 'Semua') {
            $query->where('status', $request->status);
        }

        // 3. Filter Search (Judul)
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // 4. Sorting
        $sort = $request->input('sort', 'Terbaru');
        switch ($sort) {
            case 'Populer (All Time)':
                $query->orderBy('chapters_count', 'desc'); // Populer = Paling banyak chapter (Sederhana)
                break;
            case 'A-Z':
                $query->orderBy('title', 'asc');
                break;
            case 'Terbaru':
            default:
                $query->latest(); // updated_at desc
                break;
        }

        // Pagination
        $paginatedComics = $query->paginate(12)->withQueryString();

        // Data Pendukung untuk Sidebar Filter
        $allGenres = Genre::orderBy('name')->pluck('name'); // List semua genre
        
        return view('pages.explore', [
            'paginatedComics' => $paginatedComics,
            'allGenres' => $allGenres,
            // Kirim parameter agar filter tetap tercentang di view
            'selectedGenres' => (array) $request->input('genre', []),
            'selectedStatus' => $request->input('status', 'Semua'),
            'searchTerm' => $request->input('search', ''),
            'sortBy' => $sort,
        ]);
    }

    /**
     * HALAMAN LIBRARY
     * Daftar komik favorit user (Saat ini simulasi ambil data acak/limit).
     */
    public function library(Request $request)
    {
        // TODO: Idealnya ini mengambil dari tabel 'bookmarks' milik user yang login.
        // Sementara kita ambil 12 komik acak sebagai simulasi "Library".
        
        $query = Comic::withCount('chapters');

        // Fitur Search di dalam Library
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Ambil data
        $favoriteComics = $query->limit(12)->get(); // Limit 12 dulu

        return view('pages.library', compact('favoriteComics'));
    }

    /**
     * HALAMAN DETAIL KOMIK
     */
    public function show($slug)
    {
        $comic = Comic::where('slug', $slug)
            ->with(['genres', 'chapters' => function($q) {
                $q->orderBy('number', 'desc'); // Chapter urut dari terbesar (terbaru)
            }])
            ->withCount('chapters')
            ->firstOrFail();

        $chapters = $comic->chapters;

        return view('pages.detail', compact('comic', 'chapters'));
    }

    /**
     * HALAMAN BACA (READER)
     */
    public function read($slug, $chapterNumber)
    {
        // 1. Ambil Komik
        $comic = Comic::where('slug', $slug)->firstOrFail();
        
        // 2. Ambil Chapter yang sedang dibaca
        $chapter = $comic->chapters()->where('number', $chapterNumber)->firstOrFail();

        // 3. Logic Navigasi (Prev & Next)
        // Prev = Chapter yang nomornya LEBIH KECIL tapi paling mendekati (Desc)
        $prevChapter = $comic->chapters()
            ->where('number', '<', $chapterNumber)
            ->orderBy('number', 'desc')
            ->first();

        // Next = Chapter yang nomornya LEBIH BESAR tapi paling mendekati (Asc)
        $nextChapter = $comic->chapters()
            ->where('number', '>', $chapterNumber)
            ->orderBy('number', 'asc')
            ->first();

        // 4. List SEMUA Chapter (Untuk Modal Popup List)
        $chapters = $comic->chapters()->orderBy('number', 'desc')->get();

        // 5. Proses Gambar Chapter (Ubah Path Storage ke URL Asset Public)
        $chapterImages = $chapter->content_images ?? [];
        if (is_string($chapterImages)) {
            // Jaga-jaga kalau tersimpan sebagai string JSON
            $chapterImages = json_decode($chapterImages, true);
        }
        
        $chapterImages = array_map(function($path) {
            // Cek kalau path sudah full URL (misal dummy), biarkan. Kalau path storage, kasi asset()
            return str_starts_with($path, 'http') ? $path : asset('storage/' . $path);
        }, $chapterImages ?? []);

        return view('pages.read', [
            'comic' => $comic,
            'chapterNumber' => $chapterNumber,
            'chapterImages' => $chapterImages,
            'prevChapter' => $prevChapter ? $prevChapter->number : null,
            'nextChapter' => $nextChapter ? $nextChapter->number : null,
            'chapters' => $chapters, // Penting untuk fitur "List Chapter" di reader
        ]);
    }
}