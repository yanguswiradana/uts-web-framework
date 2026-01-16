<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anime;
use App\Models\AnimeEpisode;
use Illuminate\Http\Request;

class AnimeEpisodeController extends Controller
{
    public function index()
    {
        // Load data episode beserta info Animenya
        $episodes = AnimeEpisode::with('anime')->latest()->paginate(10);
        return view('admin.anime_episodes.index', compact('episodes'));
    }

    public function create()
    {
        $animes = Anime::orderBy('title')->get();
        return view('admin.anime_episodes.create', compact('animes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'anime_id' => 'required|exists:animes,id',
            'episode_number' => 'required|numeric',
            'youtube_link' => 'required|url',
        ]);

        AnimeEpisode::create($request->all());
        return redirect()->route('admin.anime_episodes.index')->with('success', 'Episode berhasil ditambah');
    }

    // --- BAGIAN YANG DITAMBAHKAN ---
    
    public function edit(AnimeEpisode $animeEpisode)
    {
        $animes = Anime::orderBy('title')->get();
        return view('admin.anime_episodes.edit', compact('animeEpisode', 'animes'));
    }

    public function update(Request $request, AnimeEpisode $animeEpisode)
    {
        $request->validate([
            'anime_id' => 'required|exists:animes,id',
            'episode_number' => 'required|numeric',
            'youtube_link' => 'required|url',
        ]);

        $animeEpisode->update($request->all());
        return redirect()->route('admin.anime_episodes.index')->with('success', 'Episode berhasil diperbarui');
    }
    // --------------------------------

    public function destroy(AnimeEpisode $animeEpisode)
    {
        $animeEpisode->delete();
        return back()->with('success', 'Episode dihapus');
    }
}