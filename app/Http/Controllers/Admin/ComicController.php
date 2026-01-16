<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comic;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ComicController extends Controller
{
    /**
     * Tampilkan daftar komik
     */
    public function index()
    {
        $comics = Comic::withCount('chapters')->latest()->paginate(10);
        return view('admin.comics.index', compact('comics'));
    }

    /**
     * Form tambah komik
     */
    public function create()
    {
        $genres = Genre::orderBy('name')->get();
        return view('admin.comics.create', compact('genres'));
    }

    /**
     * Simpan komik baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:Manga,Manhwa,Manhua',
            'status' => 'required|in:Ongoing,Completed',
            'cover' => 'required|image|max:2048', // Max 2MB
            'release_year' => 'nullable|numeric|min:1900|max:'.(date('Y')+1),
            'genres' => 'array'
        ]);

        $coverPath = null;
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('covers', 'public');
        }

        $comic = Comic::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title . '-' . Str::random(5)),
            'author' => $request->author,
            'description' => $request->description,
            'type' => $request->type,
            'status' => $request->status,
            'cover' => $coverPath,
            'release_year' => $request->release_year,
        ]);

        // Attach Genres
        if ($request->has('genres')) {
            $comic->genres()->attach($request->genres);
        }

        return redirect()->route('admin.comics.index')->with('success', 'Komik berhasil ditambahkan');
    }

    /**
     * Form edit komik
     */
    public function edit(Comic $comic)
    {
        $genres = Genre::orderBy('name')->get();
        return view('admin.comics.edit', compact('comic', 'genres'));
    }

    /**
     * Update komik
     */
    public function update(Request $request, Comic $comic)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:Manga,Manhwa,Manhua',
            'status' => 'required|in:Ongoing,Completed',
            'cover' => 'nullable|image|max:2048',
            'release_year' => 'nullable|numeric',
            'genres' => 'array'
        ]);

        $data = $request->except(['cover', 'genres']);
        $data['slug'] = Str::slug($request->title);

        // Handle Cover Update
        if ($request->hasFile('cover')) {
            // Hapus cover lama jika bukan URL eksternal
            if ($comic->cover && !Str::startsWith($comic->cover, ['http://', 'https://'])) {
                if (Storage::disk('public')->exists($comic->cover)) {
                    Storage::disk('public')->delete($comic->cover);
                }
            }
            // Upload baru
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $comic->update($data);

        // Sync Genres
        if ($request->has('genres')) {
            $comic->genres()->sync($request->genres);
        }

        return redirect()->route('admin.comics.index')->with('success', 'Komik berhasil diperbarui');
    }

    /**
     * Hapus komik (AMAN UNTUK SEEDER & DATA MANUAL)
     */
    public function destroy(Comic $comic)
    {
        // 1. BERSIHKAN GAMBAR CHAPTER TERLEBIH DAHULU
        // Kita loop semua chapter milik komik ini dan hapus gambarnya satu per satu
        foreach ($comic->chapters as $chapter) {
            $images = $chapter->content_images;

            // Logika Decode Cerdas (Sama seperti ChapterController)
            if (is_string($images)) {
                $decoded = json_decode($images, true);
                if (is_string($decoded)) {
                    $decoded = json_decode($decoded, true);
                }
                $images = is_array($decoded) ? $decoded : [];
            } elseif (!is_array($images)) {
                $images = [];
            }

            // Hapus file fisik gambar chapter
            foreach ($images as $image) {
                if (!Str::startsWith($image, ['http://', 'https://'])) {
                    if (Storage::disk('public')->exists($image)) {
                        Storage::disk('public')->delete($image);
                    }
                }
            }
            
            // Hapus record chapter (Optional: sebenarnya cascade database sudah menangani ini, 
            // tapi manual delete memastikan event model lain jalan jika ada)
            $chapter->delete(); 
        }

        // 2. HAPUS COVER KOMIK
        if ($comic->cover && !Str::startsWith($comic->cover, ['http://', 'https://'])) {
            if (Storage::disk('public')->exists($comic->cover)) {
                Storage::disk('public')->delete($comic->cover);
            }
        }

        // 3. Hapus data Komik dari Database
        $comic->delete();

        return back()->with('success', 'Komik dan semua chapternya berhasil dihapus');
    }
}