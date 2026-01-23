<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comic;
use App\Models\Chapter;
use App\Models\Genre;
use App\Models\Rating;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class KomikController extends Controller
{
    /**
     * HALAMAN HOME
     * - Tab Populer (Manga/Manhwa/Manhua)
     * - Update Terbaru (Berdasarkan Chapter)
     * - Semua Komik (Sort by Chapter Upload Time)
     */
    public function home()
    {
        // Query Dasar: Ambil komik beserta genre, jumlah chapter, dan rating
        $baseQuery = Comic::with('genres')
            ->withCount('chapters')
            ->withAvg('ratings', 'stars');

        // 1. Data Tab Populer (Manga, Manhwa, Manhua)
        $manga = (clone $baseQuery)->where('type', 'Manga')
            ->orderBy('ratings_avg_stars', 'desc')
            ->take(10)->get();

        $manhwa = (clone $baseQuery)->where('type', 'Manhwa')
            ->orderBy('ratings_avg_stars', 'desc')
            ->take(10)->get();

        $manhua = (clone $baseQuery)->where('type', 'Manhua')
            ->orderBy('ratings_avg_stars', 'desc')
            ->take(10)->get();

        // 2. Data Update Terbaru (Real-time dari Chapter)
        // Ambil chapter terbaru, lalu ambil komiknya.
        // limit(20) diambil lebih banyak untuk antisipasi duplikat komik (misal update 3 chapter sekaligus)
        $latestChapters = Chapter::with('comic.genres')
            ->latest()
            ->limit(20) 
            ->get()
            ->unique('comic_id') // Filter biar 1 komik cuma muncul sekali
            ->take(10); // Ambil 10 hasil unik

        // Format data agar mudah dipakai di View
        $latestUpdates = $latestChapters->map(function ($chapter) {
            $comic = $chapter->comic;
            if ($comic) {
                // Inject data chapter terbaru ke object komik
                $comic->loadAvg('ratings', 'stars'); // Load rating manual
                $comic->latest_chapter = $chapter->number;
                $comic->updated_time = $chapter->created_at->diffForHumans();
            }
            return $comic;
        })->filter();

        // 3. Data Semua Komik (Diurutkan berdasarkan Chapter yang baru diupload)
        $allComics = Comic::with('genres')
            ->withCount('chapters')
            ->withAvg('ratings', 'stars')
            // Subquery: Ambil waktu 'created_at' dari chapter terakhir milik komik ini
            ->addSelect(['last_chapter_uploaded_at' => Chapter::select('created_at')
                ->whereColumn('comic_id', 'comics.id')
                ->latest()
                ->take(1)
            ])
            // Sort: Komik dengan chapter terbaru muncul paling atas
            ->orderByDesc('last_chapter_uploaded_at')
            // Fallback: Jika belum ada chapter, urutkan berdasarkan waktu buat komik
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('home', compact('manga', 'manhwa', 'manhua', 'latestUpdates', 'allComics'));
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
        
        $query = $user->bookmarks()
                      ->withCount('chapters')
                      ->withAvg('ratings', 'stars');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

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
            ->with(['user_rating'])
            ->firstOrFail();

        $chapters = $comic->chapters;

        return view('pages.detail', compact('comic', 'chapters'));
    }

    /**
     * HALAMAN BACA (READER)
     */
    public function read($slug, $chapterNumber)
    {
        $comic = Comic::where('slug', $slug)->firstOrFail();
        
        $chapter = $comic->chapters()
                         ->where('number', $chapterNumber)
                         ->firstOrFail();

        // Ambil Komentar (Hanya Induk/Parent) + Eager Load User & Balasannya
        $comments = $chapter->comments()
                            ->whereNull('parent_id') 
                            ->with(['user', 'replies.user']) 
                            ->latest()
                            ->get();

        // Navigasi Prev/Next
        $prevChapter = $comic->chapters()->where('number', '<', $chapterNumber)->orderBy('number', 'desc')->first();
        $nextChapter = $comic->chapters()->where('number', '>', $chapterNumber)->orderBy('number', 'asc')->first();
        $chapters = $comic->chapters()->orderBy('number', 'desc')->get();

        // Decode Gambar JSON
        $chapterImages = $chapter->content_images ?? [];
        if (is_string($chapterImages)) {
            $chapterImages = json_decode($chapterImages, true);
        }
        
        // Pastikan path gambar valid (URL luar atau Storage lokal)
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
            'comments' => $comments,
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
     * ACTION: POST COMMENT (AJAX SUPPORT)
     */
    public function postComment(Request $request, $chapterId)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'chapter_id' => $chapterId,
            'body' => $request->body,
            'parent_id' => $request->parent_id
        ]);

        // Load relasi user untuk respon JSON
        $comment->load('user');

        // Jika Request dari Javascript (AJAX), return JSON
        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Komentar berhasil dikirim!',
                'comment' => $comment, 
                'user_initial' => substr($comment->user->name, 0, 1),
                'time_ago' => 'Baru saja'
            ]);
        }

        return back()->with('success', 'Komentar berhasil dikirim!');
    }
}