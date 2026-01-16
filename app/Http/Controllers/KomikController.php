<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comic;
use App\Models\Chapter;
use App\Models\Genre;
use App\Models\Rating;
use App\Models\Comment; // Jangan lupa import Model Comment
use Illuminate\Support\Facades\Auth;

class KomikController extends Controller
{
    /**
     * HALAMAN HOME
     * Menampilkan Tab Populer (Manga/Manhwa/Manhua) dan Latest Updates
     */
    public function home()
    {
        // Query Dasar: Ambil komik beserta rata-rata rating
        $baseQuery = Comic::with('genres')
            ->withCount('chapters')
            ->withAvg('ratings', 'stars');

        // 1. Data untuk Tab Populer (Manga) - Ambil 10 teratas
        $manga = (clone $baseQuery)->where('type', 'Manga')
            ->orderBy('ratings_avg_stars', 'desc') // Urutkan rating tertinggi
            ->take(10)->get();

        // 2. Data untuk Tab Populer (Manhwa)
        $manhwa = (clone $baseQuery)->where('type', 'Manhwa')
            ->orderBy('ratings_avg_stars', 'desc')
            ->take(10)->get();

        // 3. Data untuk Tab Populer (Manhua)
        $manhua = (clone $baseQuery)->where('type', 'Manhua')
            ->orderBy('ratings_avg_stars', 'desc')
            ->take(10)->get();

        // 4. Data Latest Updates (Semua Tipe) - Diurutkan berdasarkan chapter terbaru
        $latestUpdates = Chapter::with(['comic.genres']) // Eager load relasi
            ->latest()
            ->take(15) // Ambil 15 update terakhir
            ->get()
            ->map(function ($chapter) {
                $comic = $chapter->comic;
                if ($comic) {
                    // Load rating manual karena ini dari model Chapter ke Comic
                    $comic->loadAvg('ratings', 'stars');
                    $comic->latest_chapter = $chapter->number;
                    $comic->updated_time = $chapter->created_at->diffForHumans();
                }
                return $comic;
            })
            ->unique('id') // Hindari duplikat komik jika update banyak chapter sekaligus
            ->filter();

        return view('home', compact('manga', 'manhwa', 'manhua', 'latestUpdates'));
    }

    /**
     * HALAMAN EXPLORE (PENCARIAN & FILTER)
     */
    public function index(Request $request)
    {
        $query = Comic::with('genres')
                      ->withCount('chapters')
                      ->withAvg('ratings', 'stars');

        // Filter Genre
        if ($request->has('genre')) {
            $genres = (array) $request->input('genre');
            if (!empty($genres)) {
                $query->whereHas('genres', function ($q) use ($genres) {
                    $q->whereIn('name', $genres);
                });
            }
        }

        // Filter Status
        if ($request->has('status') && $request->status != 'Semua') {
            $query->where('status', $request->status);
        }

        // Filter Tipe
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Search Judul
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Sorting
        $sort = $request->input('sort', 'Terbaru');
        switch ($sort) {
            case 'Populer (All Time)':
                $query->orderBy('ratings_avg_stars', 'desc');
                break;
            case 'A-Z':
                $query->orderBy('title', 'asc');
                break;
            case 'Terbaru':
            default:
                $query->latest();
                break;
        }

        $paginatedComics = $query->paginate(12)->withQueryString();
        $allGenres = Genre::orderBy('name')->pluck('name');
        
        return view('pages.explore', [
            'paginatedComics' => $paginatedComics,
            'allGenres' => $allGenres,
            'selectedGenres' => (array) $request->input('genre', []),
            'selectedStatus' => $request->input('status', 'Semua'),
            'searchTerm' => $request->input('search', ''),
            'sortBy' => $sort,
        ]);
    }

    /**
     * HALAMAN LIBRARY (BOOKMARKS)
     */
    public function library(Request $request)
    {
        $user = Auth::user();
        
        // Ambil dari relasi bookmarks milik user
        $query = $user->bookmarks()
                      ->withCount('chapters')
                      ->withAvg('ratings', 'stars');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Urutkan berdasarkan waktu ditambahkan ke library
        $favoriteComics = $query->orderByPivot('created_at', 'desc')->get();

        return view('pages.library', compact('favoriteComics'));
    }

    /**
     * HALAMAN DETAIL KOMIK
     */
    public function show($slug)
    {
        $comic = Comic::where('slug', $slug)
            ->with(['genres', 'chapters' => function($q) {
                $q->orderBy('number', 'desc');
            }])
            ->withCount('chapters')
            ->withAvg('ratings', 'stars')
            ->with(['user_rating']) // Cek apakah user login sudah rate ini
            ->firstOrFail();

        $chapters = $comic->chapters;

        return view('pages.detail', compact('comic', 'chapters'));
    }

    /**
     * HALAMAN BACA (READER) DENGAN KOMENTAR
     */
    public function read($slug, $chapterNumber)
    {
        $comic = Comic::where('slug', $slug)->firstOrFail();
        
        // Load Chapter + Komentar + User Pemilik Komentar
        $chapter = $comic->chapters()
                         ->where('number', $chapterNumber)
                         ->with(['comments.user']) // Eager Load agar performa cepat
                         ->firstOrFail();

        // Navigasi Prev/Next
        $prevChapter = $comic->chapters()->where('number', '<', $chapterNumber)->orderBy('number', 'desc')->first();
        $nextChapter = $comic->chapters()->where('number', '>', $chapterNumber)->orderBy('number', 'asc')->first();
        $chapters = $comic->chapters()->orderBy('number', 'desc')->get();

        // Decode Gambar JSON
        $chapterImages = $chapter->content_images ?? [];
        if (is_string($chapterImages)) {
            $chapterImages = json_decode($chapterImages, true);
        }
        
        // Pastikan path gambar benar (support URL luar atau Storage lokal)
        $chapterImages = array_map(function($path) {
            return str_starts_with($path, 'http') ? $path : asset('storage/' . $path);
        }, $chapterImages ?? []);

        return view('pages.read', [
            'comic' => $comic,
            'chapter' => $chapter,
            'chapterNumber' => $chapterNumber,
            'chapterImages' => $chapterImages,
            'prevChapter' => $prevChapter ? $prevChapter->number : null,
            'nextChapter' => $nextChapter ? $nextChapter->number : null,
            'chapters' => $chapters,
            'comments' => $chapter->comments, // Kirim data komentar ke view
        ]);

        
    }

    /**
     * ACTION: BOOKMARK TOGGLE
     */
    public function toggleBookmark($slug)
    {
        $user = Auth::user();
        $comic = Comic::where('slug', $slug)->firstOrFail();

        if ($user->hasBookmarked($comic->id)) {
            $user->bookmarks()->detach($comic->id);
            return back()->with('info', 'Dihapus dari library.');
        } else {
            $user->bookmarks()->attach($comic->id);
            return back()->with('success', 'Disimpan ke library!');
        }
    }

    /**
     * ACTION: RATING
     */
    public function rate(Request $request, $slug)
    {
        $request->validate(['stars' => 'required|integer|min:1|max:5']);
        $comic = Comic::where('slug', $slug)->firstOrFail();

        Rating::updateOrCreate(
            ['user_id' => Auth::id(), 'comic_id' => $comic->id],
            ['stars' => $request->stars]
        );

        return back()->with('success', 'Terima kasih atas penilaianmu!');
    }

    /**
     * ACTION: POST COMMENT
     */
    public function postComment(Request $request, $chapterId)
    {
        $request->validate([
            'body' => 'required|string|max:1000', // Maksimal 1000 karakter
        ]);

        // Simpan Komentar
        Comment::create([
            'user_id' => Auth::id(),
            'chapter_id' => $chapterId,
            'body' => $request->body
        ]);

        return back()->with('success', 'Komentar berhasil dikirim!');
    }

    
}