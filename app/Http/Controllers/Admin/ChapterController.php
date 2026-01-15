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

    // SIMPAN CHAPTER BARU
    public function store(Request $request)
    {
        // VALIDASI KETAT & FORMAT IMAGE ONLY
        $request->validate([
            'comic_id' => 'required|exists:comics,id',
            'number'   => 'required|numeric',
            'slug'     => 'nullable|string|max:255',
            // WAJIB ADA IMAGE, HARUS ARRAY, ISI ARRAY HARUS GAMBAR
            'content_images'   => 'required|array|min:1',
            'content_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048' 
        ], [
            'comic_id.required' => 'Silakan pilih komik terlebih dahulu.',
            'number.required'   => 'Nomor chapter wajib diisi.',
            'content_images.required' => 'Wajib upload minimal satu gambar chapter.',
            'content_images.*.image'  => 'File harus berupa gambar.',
            'content_images.*.mimes'  => 'Format harus jpg, jpeg, png, atau webp.',
        ]);

        $data = $request->except(['content_images']);

        // LOGIKA SLUG
        if ($request->filled('slug')) {
            $slugCandidate = Str::slug($request->slug);
        } else {
            $slugCandidate = 'chapter-' . $request->number;
            if ($request->filled('title')) {
                $slugCandidate .= '-' . $request->title;
            }
            $slugCandidate = Str::slug($slugCandidate);
        }

        if (Chapter::where('slug', $slugCandidate)->exists()) {
            $slugCandidate .= '-' . uniqid();
        }
        $data['slug'] = $slugCandidate;

        // UPLOAD GAMBAR
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

    // UPDATE CHAPTER
    public function update(Request $request, Chapter $chapter)
    {
        $request->validate([
            'comic_id' => 'required|exists:comics,id',
            'number'   => 'required|numeric',
            'slug'     => 'nullable|string|max:255',
            // Validasi gambar jika ada yang diupload (nullable saat edit)
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

        // Jika upload baru, replace yang lama
        if ($request->hasFile('content_images')) {
            // Hapus file lama fisik
            if ($chapter->content_images) {
                foreach ($chapter->content_images as $oldImage) {
                    if(!Str::startsWith($oldImage, 'http')) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
            }
            // Simpan baru
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