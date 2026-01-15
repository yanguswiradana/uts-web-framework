<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comic;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Wajib import ini

class ComicController extends Controller
{
    public function index()
    {
        $comics = Comic::with('genres')->latest()->paginate(10);
        return view('admin.comics.index', compact('comics'));
    }

    public function create()
    {
        $genres = Genre::all();
        return view('admin.comics.create', compact('genres'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:comics',
            'type' => 'required',
            'status' => 'required',
            'author' => 'required',
            'cover' => 'nullable|image|max:2048', // Validasi Cover (Max 2MB)
            'genres' => 'array'
        ]);

        // LOGIKA UPLOAD COVER
        if ($request->hasFile('cover')) {
            // Simpan ke storage/app/public/covers
            $path = $request->file('cover')->store('covers', 'public');
            $validated['cover'] = $path;
        }

        $comic = Comic::create($validated);

        if($request->has('genres')) {
            $comic->genres()->attach($request->genres);
        }

        return redirect()->route('admin.comics.index')->with('success', 'Komik berhasil ditambahkan!');
    }

    public function edit(Comic $comic)
    {
        $genres = Genre::all();
        return view('admin.comics.edit', compact('comic', 'genres'));
    }

    public function update(Request $request, Comic $comic)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:comics,slug,' . $comic->id,
            'type' => 'required',
            'status' => 'required',
            'author' => 'required',
            'cover' => 'nullable|image|max:2048', // Validasi Cover
            'genres' => 'array'
        ]);

        // LOGIKA UPDATE COVER
        if ($request->hasFile('cover')) {
            
            // 1. Hapus cover lama dari storage jika ada
            if ($comic->cover && Storage::disk('public')->exists($comic->cover)) {
                Storage::disk('public')->delete($comic->cover);
            }
            
            // 2. Upload cover baru
            $path = $request->file('cover')->store('covers', 'public');
            $validated['cover'] = $path;
        }

        $comic->update($validated);

        if($request->has('genres')) {
            $comic->genres()->sync($request->genres);
        }

        return redirect()->route('admin.comics.index')->with('success', 'Komik berhasil diupdate!');
    }

    public function destroy(Comic $comic)
    {
        // 1. Hapus File Cover
        if ($comic->cover && Storage::disk('public')->exists($comic->cover)) {
            Storage::disk('public')->delete($comic->cover);
        }

        // 2. Lepas Relasi & Hapus Data
        $comic->genres()->detach();
        $comic->delete();
        
        return redirect()->route('admin.comics.index')->with('success', 'Komik dihapus!');
    }
}