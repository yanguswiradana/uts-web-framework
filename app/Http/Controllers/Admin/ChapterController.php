<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Comic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Penting untuk hapus gambar

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

    // ==========================================
    // FUNGSI UTAMA UPLOAD (STORE)
    // ==========================================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'comic_id' => 'required|exists:comics,id',
            'number' => 'required|numeric',
            'title' => 'required|max:255',
            'slug' => 'required|unique:chapters',
            // Validasi Array Gambar (Maks 2MB per file)
            'content_images' => 'required|array',
            'content_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        // 1. Siapkan Array Penampung Path
        $imagePaths = [];

        // 2. Loop setiap file yang diupload
        if ($request->hasFile('content_images')) {
            foreach ($request->file('content_images') as $image) {
                // Simpan ke folder: storage/app/public/chapter-images
                $path = $image->store('chapter-images', 'public');
                $imagePaths[] = $path;
            }
        }

        // 3. Simpan ke Database
        Chapter::create([
            'comic_id' => $request->comic_id,
            'number' => $request->number,
            'title' => $request->title,
            'slug' => $request->slug,
            'content_images' => $imagePaths, // Laravel otomatis ubah jadi JSON
        ]);

        return redirect()->route('admin.chapters.index')->with('success', 'Chapter berhasil diupload beserta gambarnya!');
    }

    public function edit(Chapter $chapter)
    {
        $comics = Comic::orderBy('title', 'asc')->get();
        return view('admin.chapters.edit', compact('chapter', 'comics'));
    }

    // FUNGSI UPDATE (Simpel: Timpa gambar lama jika ada upload baru)
    public function update(Request $request, Chapter $chapter)
    {
        $validated = $request->validate([
            'comic_id' => 'required|exists:comics,id',
            'number' => 'required|numeric',
            'title' => 'required|max:255',
            'slug' => 'required|unique:chapters,slug,' . $chapter->id,
            'content_images' => 'nullable|array',
            'content_images.*' => 'image|max:2048'
        ]);

        // Ambil data lama dulu
        $dataToUpdate = [
            'comic_id' => $request->comic_id,
            'number' => $request->number,
            'title' => $request->title,
            'slug' => $request->slug,
        ];

        // Jika user upload gambar baru, hapus yang lama, simpan yang baru
        if ($request->hasFile('content_images')) {
            
            // Hapus file lama dari storage (Opsional, biar hemat memori)
            if ($chapter->content_images) {
                foreach ($chapter->content_images as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            // Upload baru
            $newImages = [];
            foreach ($request->file('content_images') as $image) {
                $newImages[] = $image->store('chapter-images', 'public');
            }
            $dataToUpdate['content_images'] = $newImages;
        }

        $chapter->update($dataToUpdate);

        return redirect()->route('admin.chapters.index')->with('success', 'Chapter berhasil diupdate!');
    }

    public function destroy(Chapter $chapter)
    {
        // Hapus fisik gambar saat data dihapus
        if ($chapter->content_images) {
            foreach ($chapter->content_images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $chapter->delete();
        return redirect()->route('admin.chapters.index')->with('success', 'Chapter dihapus!');
    }
}