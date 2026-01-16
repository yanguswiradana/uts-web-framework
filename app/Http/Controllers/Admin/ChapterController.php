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
    /**
     * Tampilkan semua chapter
     */
    public function index()
    {
        $chapters = Chapter::with('comic')->latest()->paginate(10);
        return view('admin.chapters.index', compact('chapters'));
    }

    /**
     * Form tambah chapter
     */
    public function create()
    {
        $comics = Comic::orderBy('title')->get();
        return view('admin.chapters.create', compact('comics'));
    }

    /**
     * Simpan chapter baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'comic_id' => 'required|exists:comics,id',
            'title' => 'nullable|string|max:255',
            'number' => 'required|numeric',
            'content_images' => 'required',
            'content_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $images = [];
        if ($request->hasFile('content_images')) {
            foreach ($request->file('content_images') as $file) {
                $path = $file->store('chapters', 'public');
                $images[] = $path;
            }
        }

        Chapter::create([
            'comic_id' => $request->comic_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title ? $request->title : 'chapter-' . $request->number),
            'number' => $request->number,
            'content_images' => json_encode($images), // Simpan sebagai JSON String
        ]);

        return redirect()->route('admin.chapters.index')->with('success', 'Chapter berhasil ditambahkan');
    }

    /**
     * Form edit chapter
     */
    public function edit(Chapter $chapter)
    {
        $comics = Comic::orderBy('title')->get();
        return view('admin.chapters.edit', compact('chapter', 'comics'));
    }

    /**
     * Update chapter
     */
    public function update(Request $request, Chapter $chapter)
    {
        $request->validate([
            'comic_id' => 'required|exists:comics,id',
            'title' => 'nullable|string|max:255',
            'number' => 'required|numeric',
            'content_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        // AMBIL DATA LAMA & NORMALISASI
        $currentImages = $chapter->content_images;
        
        // Cek 1: Jika String, decode jadi Array
        if (is_string($currentImages)) {
            $decoded = json_decode($currentImages, true);
            // Cek 2: Jika hasil decode masih String (Double Encoded), decode lagi
            if (is_string($decoded)) {
                $decoded = json_decode($decoded, true);
            }
            $currentImages = is_array($decoded) ? $decoded : [];
        } elseif (!is_array($currentImages)) {
            $currentImages = [];
        }

        // Tambah gambar baru jika ada
        if ($request->hasFile('content_images')) {
            foreach ($request->file('content_images') as $file) {
                $path = $file->store('chapters', 'public');
                $currentImages[] = $path;
            }
        }

        // Update DB
        $chapter->update([
            'comic_id' => $request->comic_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title ? $request->title : 'chapter-' . $request->number),
            'number' => $request->number,
            'content_images' => json_encode($currentImages),
        ]);

        return redirect()->route('admin.chapters.index')->with('success', 'Chapter berhasil diperbarui');
    }

    /**
     * Hapus chapter (FULL FIX)
     */
    public function destroy(Chapter $chapter)
    {
        $images = $chapter->content_images;

        // --- LOGIKA PENANGANAN FORMAT GAMBAR ---
        
        // 1. Jika data adalah String, coba Decode
        if (is_string($images)) {
            $decoded = json_decode($images, true);
            
            // 2. Handle Double Encoding (Kasus khusus Seeder/String dalam String)
            if (is_string($decoded)) {
                $decoded = json_decode($decoded, true);
            }
            
            // 3. Pastikan hasil akhir adalah Array
            $images = is_array($decoded) ? $decoded : [];
        } 
        
        // 4. Jika aslinya bukan string & bukan array (misal null), jadikan array kosong
        if (!is_array($images)) {
            $images = [];
        }

        // --- EKSEKUSI HAPUS FILE ---
        foreach ($images as $image) {
            // Hapus hanya jika BUKAN link URL (http/https)
            if (!Str::startsWith($image, ['http://', 'https://'])) {
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
            }
        }

        $chapter->delete();

        return back()->with('success', 'Chapter berhasil dihapus');
    }
}