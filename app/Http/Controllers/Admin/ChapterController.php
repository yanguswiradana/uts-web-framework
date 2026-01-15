<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Comic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ChapterController extends Controller
{
    public function index()
    {
        $chapters = Chapter::with('comic')->latest()->paginate(10);
        return view('admin.chapters.index', compact('chapters'));
    }

    public function create()
    {
        $selectedComicId = request('comic_id');
        $comics = Comic::orderBy('title')->get();
        return view('admin.chapters.create', compact('comics', 'selectedComicId'));
    }

    // UPDATE DI SINI: Validasi Title jadi Required
    public function store(Request $request)
    {
        $request->validate([
            'comic_id' => 'required|exists:comics,id',
            'number'   => 'required|numeric',
            'title'    => 'required|string|max:255', // SEKARANG WAJIB
            'slug'     => 'nullable|string|max:255',
            'content_images'   => 'required|array|min:1',
            'content_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048' 
        ]);

        $data = $request->except(['content_images']);

        // Logika Slug (Tetap sama)
        if ($request->filled('slug')) {
            $slugCandidate = Str::slug($request->slug);
        } else {
            // Gabungkan Nomor dan Judul karena judul sekarang wajib
            $slugCandidate = Str::slug('chapter-' . $request->number . '-' . $request->title);
        }

        if (Chapter::where('slug', $slugCandidate)->exists()) {
            $slugCandidate .= '-' . uniqid();
        }
        $data['slug'] = $slugCandidate;

        // Upload Gambar (Tetap sama)
        $imagePaths = [];
        if ($request->hasFile('content_images')) {
            foreach ($request->file('content_images') as $image) {
                $path = $image->store('chapters', 'public');
                $imagePaths[] = $path;
            }
        }
        $data['content_images'] = $imagePaths;

        Chapter::create($data);

        return redirect()->route('admin.chapters.index')->with('success', 'Chapter berhasil diupload!');
    }

    public function edit(Chapter $chapter)
    {
        $comics = Comic::orderBy('title')->get();
        return view('admin.chapters.edit', compact('chapter', 'comics'));
    }

    // UPDATE DI SINI: Validasi Title jadi Required
    public function update(Request $request, Chapter $chapter)
    {
        $request->validate([
            'comic_id' => 'required|exists:comics,id',
            'number'   => 'required|numeric',
            'title'    => 'required|string|max:255', // SEKARANG WAJIB
            'slug'     => 'nullable|string|max:255',
            'content_images'   => 'nullable|array',
            'content_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->except(['content_images']);

        if ($request->filled('slug')) {
            $slugCandidate = Str::slug($request->slug);
            if (Chapter::where('slug', $slugCandidate)->where('id', '!=', $chapter->id)->exists()) {
                $slugCandidate .= '-' . uniqid();
            }
            $data['slug'] = $slugCandidate;
        }

        if ($request->hasFile('content_images')) {
            if ($chapter->content_images) {
                foreach ($chapter->content_images as $oldImage) {
                    if(!Str::startsWith($oldImage, 'http')) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
            }
            $imagePaths = [];
            foreach ($request->file('content_images') as $image) {
                $path = $image->store('chapters', 'public');
                $imagePaths[] = $path;
            }
            $data['content_images'] = $imagePaths;
        }

        $chapter->update($data);

        return redirect()->route('admin.chapters.index')->with('success', 'Chapter berhasil diperbarui!');
    }

    public function destroy(Chapter $chapter)
    {
        if ($chapter->content_images) {
            foreach ($chapter->content_images as $image) {
                if(!Str::startsWith($image, 'http')) {
                    Storage::disk('public')->delete($image);
                }
            }
        }
        $chapter->delete();
        return redirect()->route('admin.chapters.index')->with('success', 'Chapter berhasil dihapus!');
    }
}