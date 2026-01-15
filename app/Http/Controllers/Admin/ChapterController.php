<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Comic;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function index()
    {
        $chapters = Chapter::with('comic')->latest()->paginate(15);
        return view('admin.chapters.index', compact('chapters'));
    }

    public function create()
    {
        $comics = Comic::orderBy('title', 'asc')->get();
        return view('admin.chapters.create', compact('comics'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'comic_id' => 'required|exists:comics,id',
            'number' => 'required|numeric',
            'title' => 'required|max:255',
            'slug' => 'required|unique:chapters',
        ]);

        Chapter::create($validated);
        return redirect()->route('admin.chapters.index')->with('success', 'Chapter berhasil diupload!');
    }

    public function edit(Chapter $chapter)
    {
        $comics = Comic::orderBy('title', 'asc')->get();
        return view('admin.chapters.edit', compact('chapter', 'comics'));
    }

    public function update(Request $request, Chapter $chapter)
    {
        $validated = $request->validate([
            'comic_id' => 'required|exists:comics,id',
            'number' => 'required|numeric',
            'title' => 'required|max:255',
            'slug' => 'required|unique:chapters,slug,' . $chapter->id,
        ]);

        $chapter->update($validated);
        return redirect()->route('admin.chapters.index')->with('success', 'Chapter berhasil diupdate!');
    }

    public function destroy(Chapter $chapter)
    {
        $chapter->delete();
        return redirect()->route('admin.chapters.index')->with('success', 'Chapter dihapus!');
    }
}