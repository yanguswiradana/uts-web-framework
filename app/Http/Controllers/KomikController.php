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
     */
    public function home()
    {
        $baseQuery = Comic::with('genres')
            ->withCount('chapters')
            ->withAvg('ratings', 'stars');

        // 1. Tab Populer (Manga)
        $manga = (clone $baseQuery)->where('type', 'Manga')
            ->orderBy('ratings_avg_stars', 'desc')
            ->take(10)->get();

        // 2. Tab Populer (Manhwa)
        $manhwa = (clone $baseQuery)->where('type', 'Manhwa')
            ->orderBy('ratings_avg_stars', 'desc')
            ->take(10)->get();

        // 3. Tab Populer (Manhua)
        $manhua = (clone $baseQuery)->where('type', 'Manhua')
            ->orderBy('ratings_avg_stars', 'desc')
            ->take(10)->get();

        // 4. Latest Updates
        $latestUpdates = Chapter::with(['comic.genres'])
            ->latest()
            ->take(15)
            ->get()
            ->map(function ($chapter) {
                $comic = $chapter->comic;
                if ($comic) {
                    $comic->loadAvg('ratings', 'stars');
                    $comic->latest_chapter = $chapter->number;
                    $comic->updated_time = $chapter->created_at->diffForHumans();
                }
                return $comic;
            })
            ->unique('id')
            ->filter();

        return view('home', compact('manga', 'manhwa', 'manhua', 'latestUpdates'));
    }

    /**
     * HALAMAN EXPLORE
     */
    public function index(Request $request)
    {
        $query = Comic::with('genres')
                      ->withCount('chapters')
                      ->withAvg('ratings', 'stars');

        if ($request->has('genre')) {
            $genres = (array) $request->input('genre');
            if (!empty($genres)) {
                $query->whereHas('genres', function ($q) use ($genres) {
                    $q->whereIn('name', $genres);
                });
            }
        }

        if ($request->has('status') && $request->status != 'Semua') {
            $query->where('status', $request->status);
        }

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

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
     * HALAMAN LIBRARY
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
     * HALAMAN BACA (READER) - UPDATED FOR NESTED COMMENTS
     */
    public function read($slug, $chapterNumber)
    {
        $comic = Comic::where('slug', $slug)->firstOrFail();
        
        $chapter = $comic->chapters()
                         ->where('number', $chapterNumber)
                         ->firstOrFail();

        // UPDATE LOGIC KOMENTAR:
        // Hanya ambil komentar INDUK (parent_id = null)
        // Eager load User dan Balasan (Replies) beserta usernya
        $comments = $chapter->comments()
                            ->whereNull('parent_id') 
                            ->with(['user', 'replies.user']) 
                            ->latest()
                            ->get();

        // Navigasi
        $prevChapter = $comic->chapters()->where('number', '<', $chapterNumber)->orderBy('number', 'desc')->first();
        $nextChapter = $comic->chapters()->where('number', '>', $chapterNumber)->orderBy('number', 'asc')->first();
        $chapters = $comic->chapters()->orderBy('number', 'desc')->get();

        // Decode Gambar
        $chapterImages = $chapter->content_images ?? [];
        if (is_string($chapterImages)) {
            $chapterImages = json_decode($chapterImages, true);
        }
        
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
            'comments' => $comments, // Kirim komentar yang sudah difilter
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
     * ACTION: POST COMMENT - UPDATED FOR AJAX & REPLIES
     */
    public function postComment(Request $request, $chapterId)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id' // Validasi ID Induk
        ]);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'chapter_id' => $chapterId,
            'body' => $request->body,
            'parent_id' => $request->parent_id // Simpan Parent ID jika ada (Balasan)
        ]);

        // Load data user untuk dikirim balik ke JS
        $comment->load('user');

        // Jika request datang dari AJAX (Fetch/Axios), kembalikan JSON
        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Komentar berhasil dikirim!',
                'comment' => $comment, 
                'user_initial' => substr($comment->user->name, 0, 1),
                'time_ago' => 'Baru saja' // Karena baru dibuat
            ]);
        }

        // Fallback jika JS mati (Reload Halaman)
        return back()->with('success', 'Komentar berhasil dikirim!');
    }
}