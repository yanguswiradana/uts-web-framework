<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comic;
use App\Models\Genre;
use Illuminate\Http\Request;

class ComicController extends Controller
{
    public function index()
    {
        // with('genres') untuk optimasi query (Eager Loading)
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
            'genres' => 'array' // Array ID dari checkbox
        ]);

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
            'genres' => 'array'
        ]);

        $comic->update($validated);

        if($request->has('genres')) {
            $comic->genres()->sync($request->genres);
        }

        return redirect()->route('admin.comics.index')->with('success', 'Komik berhasil diupdate!');
    }

    public function destroy(Comic $comic)
    {
        $comic->genres()->detach(); // Lepas relasi genre dulu
        $comic->delete();
        return redirect()->route('admin.comics.index')->with('success', 'Komik dihapus!');
    }
}