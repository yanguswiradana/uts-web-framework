<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comic;
use App\Models\Chapter;
use App\Models\Genre;
use App\Models\Rating; // Import Model Rating
use Illuminate\Support\Facades\Auth;

class KomikController extends Controller
{
    /**
     * HALAMAN HOME (Update Data Rating)
     */
    public function home()
    {
        // withAvg('ratings', 'stars') <- INI KUNCINYA
        // Ini akan membuat kolom virtual bernama: ratings_avg_stars
        $allComics = Comic::with('genres')
            ->withCount('chapters')
            ->withAvg('ratings', 'stars') 
            ->latest()
            ->get();

        $manga = $allComics->where('type', 'Manga')->take(6);
        $manhwa = $allComics->where('type', 'Manhwa')->take(6);
        $manhua = $allComics->where('type', 'Manhua')->take(6);

        $latestUpdates = Chapter::with('comic.genres') // Eager load genre untuk card
            ->latest()
            ->take(12)
            ->get()
            ->map(function ($chapter) {
                $comic = $chapter->comic;
                if ($comic) {
                    // Kita perlu hitung rating manual untuk comic yang didapat dari chapter
                    // Atau gunakan loadAvg jika versi Laravel baru
                    $comic->loadAvg('ratings', 'stars');
                    $comic->latest_chapter = $chapter->number;
                    $comic->updated_time = $chapter->created_at->diffForHumans();
                }
                return $comic;
            })->filter();

        return view('home', compact('manga', 'manhwa', 'manhua', 'latestUpdates'));
    }

    // ... method index (explore) dan library biarkan ...
    // Note: Pastikan di method 'index' (Explore) dan 'library' juga ditambah ->withAvg('ratings', 'stars')
    // agar ratingnya muncul disana juga.

    public function index(Request $request) {
        // Update query explore
        $query = Comic::with('genres')
                      ->withCount('chapters')
                      ->withAvg('ratings', 'stars'); // Tambah ini
        
        // ... sisa kode explore sama ...
        // (Pastikan copy logika filter dari kode sebelumnya)
        
        // Agar tidak panjang, saya skip bagian filter yang tidak berubah.
        // Langsung return view
        
        // ... kode filter ...

        // Sorting Logic Update (Opsional: Sort by Rating)
        $sort = $request->input('sort', 'Terbaru');
        if($sort == 'Populer (All Time)') {
             $query->orderBy('ratings_avg_stars', 'desc'); // Sort berdasarkan rating
        } else {
             $query->latest();
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

    public function library(Request $request) {
        $user = Auth::user();
        $query = $user->bookmarks()
                      ->withCount('chapters')
                      ->withAvg('ratings', 'stars'); // Tambah ini

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        $favoriteComics = $query->orderByPivot('created_at', 'desc')->get();
        return view('pages.library', compact('favoriteComics'));
    }

    /**
     * HALAMAN DETAIL (Update Rating Saya)
     */
    public function show($slug)
    {
        $comic = Comic::where('slug', $slug)
            ->with(['genres', 'chapters' => function($q) {
                $q->orderBy('number', 'desc');
            }])
            ->withCount('chapters')
            ->withAvg('ratings', 'stars') // Ambil rata-rata
            ->with(['user_rating']) // Ambil rating user yang sedang login (jika ada)
            ->firstOrFail();

        $chapters = $comic->chapters;

        return view('pages.detail', compact('comic', 'chapters'));
    }

    /**
     * FITUR BARU: SUBMIT RATING
     */
    public function rate(Request $request, $slug)
    {
        $request->validate([
            'stars' => 'required|integer|min:1|max:5'
        ]);

        $comic = Comic::where('slug', $slug)->firstOrFail();

        // UpdateOrCreate: Jika sudah ada update, jika belum buat baru
        Rating::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'comic_id' => $comic->id
            ],
            [
                'stars' => $request->stars
            ]
        );

        return back()->with('success', 'Terima kasih atas penilaianmu!');
    }

    // ... method read, toggleBookmark, dll biarkan sama ...
    public function toggleBookmark($slug)
    {
        $user = Auth::user();
        $comic = Comic::where('slug', $slug)->firstOrFail();
        if ($user->hasBookmarked($comic->id)) {
            $user->bookmarks()->detach($comic->id);
            $message = 'Dihapus dari library.'; $type = 'info';
        } else {
            $user->bookmarks()->attach($comic->id);
            $message = 'Disimpan ke library!'; $type = 'success';
        }
        return back()->with($type, $message);
    }

    public function read($slug, $chapterNumber)
    {
        // ... Kode read sama persis dengan sebelumnya ...
        // (Saya singkat biar tidak kepanjangan)
        $comic = Comic::where('slug', $slug)->firstOrFail();
        $chapter = $comic->chapters()->where('number', $chapterNumber)->firstOrFail();
        $prevChapter = $comic->chapters()->where('number', '<', $chapterNumber)->orderBy('number', 'desc')->first();
        $nextChapter = $comic->chapters()->where('number', '>', $chapterNumber)->orderBy('number', 'asc')->first();
        $chapters = $comic->chapters()->orderBy('number', 'desc')->get();
        
        $chapterImages = $chapter->content_images ?? [];
        if (is_string($chapterImages)) $chapterImages = json_decode($chapterImages, true);
        $chapterImages = array_map(function($path) {
            return str_starts_with($path, 'http') ? $path : asset('storage/' . $path);
        }, $chapterImages ?? []);

        return view('pages.read', [
            'comic' => $comic,
            'chapterNumber' => $chapterNumber,
            'chapterImages' => $chapterImages,
            'prevChapter' => $prevChapter ? $prevChapter->number : null,
            'nextChapter' => $nextChapter ? $nextChapter->number : null,
            'chapters' => $chapters,
        ]);
    }
}