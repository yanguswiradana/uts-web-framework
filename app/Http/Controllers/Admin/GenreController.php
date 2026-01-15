<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::latest()->paginate(10);
        return view('admin.genres.index', compact('genres'));
    }

    public function create()
    {
        return view('admin.genres.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['name' => 'required|unique:genres|max:50']);
        $validated['slug'] = Str::slug($request->name);
        Genre::create($validated);
        return redirect()->route('admin.genres.index')->with('success', 'Genre berhasil ditambahkan!');
    }

    public function edit(Genre $genre)
    {
        return view('admin.genres.edit', compact('genre'));
    }

    public function update(Request $request, Genre $genre)
    {
        $validated = $request->validate(['name' => 'required|max:50|unique:genres,name,' . $genre->id]);
        $validated['slug'] = Str::slug($request->name);
        $genre->update($validated);
        return redirect()->route('admin.genres.index')->with('success', 'Genre berhasil diupdate!');
    }

    public function destroy(Genre $genre)
    {
        $genre->delete();
        return redirect()->route('admin.genres.index')->with('success', 'Genre dihapus!');
    }
}