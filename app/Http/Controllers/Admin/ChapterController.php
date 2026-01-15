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

    public function store(Request $request)
    {
        $request->validate([
            'comic_id' => 'required',
            'number'   => 'required|numeric',
            'title'    => 'nullable|string',
            'content_images'   => 'required', // Wajib ada gambar
            'content_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048' // Validasi tiap file
        ]);

        $data = $request->except(['content_images']);
        $data['slug'] = Str::slug('chapter-' . $request->number . '-' . uniqid()); // Slug unik

        // --- 1. PROSES MULTIPLE UPLOAD ---
        $imagePaths = [];
        if ($request->hasFile('content_images')) {
            foreach ($request->file('content_images') as $image) {
                // Simpan tiap gambar ke folder 'chapters'
                $path = $image->store('chapters', 'public');
                $imagePaths[] = $path;
            }
        }
        
        // Simpan array path ke database (Otomatis jadi JSON berkat Casts di Model)
        $data['content_images'] = $imagePaths;

        Chapter::create($data);

        return redirect()->route('admin.chapters.index')->with('success', 'Chapter berhasil diupload!');
    }

    public function edit(Chapter $chapter)
    {
        $comics = Comic::orderBy('title')->get();
        return view('admin.chapters.edit', compact('chapter', 'comics'));
    }

    public function update(Request $request, Chapter $chapter)
    {
        $request->validate([
            'comic_id' => 'required',
            'number'   => 'required|numeric',
            'content_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->except(['content_images']);

        // --- 2. PROSES UPDATE (TIMPA GAMBAR LAMA) ---
        // Logika: Jika admin upload gambar baru, semua gambar lama dihapus & diganti baru
        if ($request->hasFile('content_images')) {
            
            // Hapus semua file lama dari penyimpanan
            if ($chapter->content_images) {
                foreach ($chapter->content_images as $oldImage) {
                    if(!Str::startsWith($oldImage, 'http')) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
            }

            // Upload file baru
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
        // --- 3. HAPUS SEMUA FILE GAMBAR SAAT CHAPTER DIHAPUS ---
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