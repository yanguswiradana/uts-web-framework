<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anime;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AnimeController extends Controller
{
    public function index()
    {
        $animes = Anime::latest()->paginate(10);
        return view('admin.animes.index', compact('animes'));
    }

    public function create()
    {
        return view('admin.animes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'studio' => 'required',
            'release_year' => 'required|numeric',
            'cover' => 'required|image|max:2048',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title . '-' . Str::random(5));
        
        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('animes', 'public');
        }

        Anime::create($data);
        return redirect()->route('admin.animes.index')->with('success', 'Anime berhasil ditambahkan');
    }

    public function edit(Anime $anime)
    {
        return view('admin.animes.edit', compact('anime'));
    }

    public function update(Request $request, Anime $anime)
    {
        $data = $request->all();
        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('animes', 'public');
        }
        $anime->update($data);
        return redirect()->route('admin.animes.index')->with('success', 'Anime diupdate');
    }

    public function destroy(Anime $anime)
    {
        $anime->delete();
        return back()->with('success', 'Anime dihapus');
    }
}