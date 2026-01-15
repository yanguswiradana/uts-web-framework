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
        $request->validate([
            'title' => 'required',
            'type'  => 'required',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Max 2MB
            'genres'=> 'array'
        ]);

        $data = $request->except(['cover', 'genres']);
        $data['slug'] = Str::slug($request->title);

        // --- 1. PROSES UPLOAD COVER BARU ---
        if ($request->hasFile('cover')) {
            // File akan disimpan di: storage/app/public/comics
            $path = $request->file('cover')->store('comics', 'public');
            $data['cover'] = $path;
        }

        $comic = Comic::create($data);

        // Simpan Relasi Genre
        if($request->has('genres')){
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
        $request->validate([
            'title' => 'required',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except(['cover', 'genres']);
        $data['slug'] = Str::slug($request->title);

        // --- 2. PROSES GANTI COVER ---
        if ($request->hasFile('cover')) {
            // Hapus gambar lama (jika ada dan bukan link internet)
            if ($comic->cover && !Str::startsWith($comic->cover, 'http')) {
                Storage::disk('public')->delete($comic->cover);
            }
            
            // Upload gambar baru
            $path = $request->file('cover')->store('comics', 'public');
            $data['cover'] = $path;
        }

        $comic->update($data);

        // Update Relasi Genre
        if($request->has('genres')){
            $comic->genres()->sync($request->genres);
        }

        return redirect()->route('admin.comics.index')->with('success', 'Komik berhasil diperbarui!');
    }

    public function destroy(Comic $comic)
    {
        // --- 3. HAPUS FILE FISIK SAAT DATA DIHAPUS ---
        if ($comic->cover && !Str::startsWith($comic->cover, 'http')) {
            Storage::disk('public')->delete($comic->cover);
        }
        
        $comic->genres()->detach();
        $comic->delete();

        return redirect()->route('admin.comics.index')->with('success', 'Komik berhasil dihapus!');
    }
}