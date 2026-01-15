<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Comic;     // <-- Gunakan Model Comic
use App\Models\Genre;     // <-- Gunakan Model Genre
use App\Models\Chapter;   // <-- Gunakan Model Chapter

class KomikController extends Controller
{
    // --- 1. HALAMAN HOME ---
    public function home()
    {
        // Ambil data dari Database + Relasi Genre & Chapters
        // withCount('chapters') agar kita tahu total chapter tanpa load semua datanya
        $allComics = Comic::with('genres')->withCount('chapters')->latest()->get();

        $manga = $allComics->where('type', 'Manga')->take(6);
        $manhwa = $allComics->where('type', 'Manhwa')->take(6);
        $manhua = $allComics->where('type', 'Manhua')->take(6);
        
        // Update terbaru berdasarkan chapter yang baru dibuat
        $latestUpdates = Chapter::with('comic')
            ->latest()
            ->take(12)
            ->get()
            ->map(function ($chapter) {
                // Format agar sesuai tampilan Home
                $comic = $chapter->comic;
                $comic->latest_chapter = $chapter->number;
                $comic->updated_time = $chapter->created_at->diffForHumans();
                return $comic;
            });

        return view('home', compact('manga', 'manhwa', 'manhua', 'latestUpdates'));
    }

    // --- 2. HALAMAN EXPLORE ---
    public function index(Request $request)
    {
        $query = Comic::with('genres')->withCount('chapters');

        // Filter Genre
        if ($request->has('genre')) {
            $genres = (array) $request->input('genre');
            // Cari komik yang punya relasi genre X
            $query->whereHas('genres', function ($q) use ($genres) {
                $q->whereIn('name', $genres);
            });
        }

        // Filter Status
        if ($request->has('status') && $request->status != 'Semua') {
            $query->where('status', $request->status);
        }

        // Filter Search
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Sorting
        $sort = $request->input('sort', 'Terbaru');
        switch ($sort) {
            case 'Populer (All Time)':
                $query->orderBy('chapters_count', 'desc'); // Sementara pakai jumlah chapter sbg popularitas
                break;
            case 'A-Z':
                $query->orderBy('title', 'asc');
                break;
            default:
                $query->latest();
                break;
        }

        $paginatedComics = $query->paginate(12)->withQueryString();
        
        // Data Pendukung View
        $allGenres = Genre::pluck('name'); // Ambil nama genre dari DB
        $selectedGenres = (array) $request->input('genre', []);
        $selectedStatus = $request->input('status', 'Semua');
        $searchTerm = $request->input('search', '');
        $sortBy = $request->input('sort', 'Terbaru');

        return view('pages.explore', compact('paginatedComics', 'allGenres', 'selectedGenres', 'selectedStatus', 'searchTerm', 'sortBy'));
    }

    // --- 3. HALAMAN LIBRARY ---
    public function library(Request $request)
    {
        // TODO: Nanti kita buat fitur bookmark beneran di database
        // Sementara kita ambil semua komik dulu sebagai contoh
        $favoriteComics = Comic::withCount('chapters')->limit(5)->get();
        
        return view('pages.library', compact('favoriteComics'));
    }

    // --- 4. HALAMAN DETAIL ---
    public function show($slug)
    {
        // Ambil data komik berdasarkan slug
        $comic = Comic::where('slug', $slug)
            ->with(['genres', 'chapters' => function($q) {
                $q->latest(); // Urutkan chapter dari yang terbaru
            }])
            ->firstOrFail();

        $chapters = $comic->chapters;

        return view('pages.detail', compact('comic', 'chapters'));
    }

    // --- 5. HALAMAN BACA CHAPTER ---
    public function read($slug, $chapterNumber)
    {
        $comic = Comic::where('slug', $slug)->firstOrFail();
        
        // Ambil chapter spesifik
        $chapter = $comic->chapters()->where('number', $chapterNumber)->firstOrFail();

        // Navigasi Prev/Next
        $prevChapter = $comic->chapters()->where('number', '<', $chapterNumber)->orderBy('number', 'desc')->first();
        $nextChapter = $comic->chapters()->where('number', '>', $chapterNumber)->orderBy('number', 'asc')->first();

        // Ambil gambar dari kolom JSON (yang sudah kita bahas tadi)
        $chapterImages = $chapter->content_images ?? [];
        
        // Ubah path storage jadi URL public asset
        $chapterImages = array_map(function($path) {
            return asset('storage/' . $path);
        }, $chapterImages);

        return view('pages.read', [
            'comic' => $comic,
            'chapterNumber' => $chapterNumber,
            'chapterImages' => $chapterImages,
            'prevChapter' => $prevChapter ? $prevChapter->number : null,
            'nextChapter' => $nextChapter ? $nextChapter->number : null
        ]);
    }
}