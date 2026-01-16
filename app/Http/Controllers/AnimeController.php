<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use App\Models\AnimeEpisode;
use Illuminate\Http\Request;

class AnimeController extends Controller
{
    // Halaman Utama Anime
    public function index()
    {
        $latestEpisodes = AnimeEpisode::with('anime')->latest()->take(6)->get();
        $animes = Anime::latest()->paginate(12);
        
        return view('pages.anime.index', compact('animes', 'latestEpisodes'));
    }

    // Halaman Detail Anime
    public function show($slug)
    {
        $anime = Anime::where('slug', $slug)->with('episodes')->firstOrFail();
        return view('pages.anime.show', compact('anime'));
    }

    // Halaman Nonton (Player)
    public function watch($slug, $episodeNumber)
    {
        $anime = Anime::where('slug', $slug)->firstOrFail();
        
        $currentEpisode = $anime->episodes()->where('episode_number', $episodeNumber)->firstOrFail();
        
        // Navigasi Prev/Next
        $prevEpisode = $anime->episodes()->where('episode_number', '<', $episodeNumber)->orderBy('episode_number', 'desc')->first();
        $nextEpisode = $anime->episodes()->where('episode_number', '>', $episodeNumber)->orderBy('episode_number', 'asc')->first();

        return view('pages.anime.watch', compact('anime', 'currentEpisode', 'prevEpisode', 'nextEpisode'));
    }
}