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

    // ==========================================
    // STORE (SIMPAN DATA BARU)
    // ==========================================
    public function store(Request $request)
    {
        $request->validate([
            'comic_id' => 'required',
            'number'   => 'required|numeric',
            'slug'     => 'nullable|string|max:255', // Validasi string biasa
            'content_images'   => 'required',
            'content_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->except(['content_images']);

        // --- 1. LOGIKA HYBRID SLUG ---
        if ($request->filled('slug')) {
            // Jika admin isi manual
            $slugCandidate = Str::slug($request->slug);
        } else {
            // Jika kosong, generate otomatis: "chapter-{nomor}"
            $slugCandidate = 'chapter-' . $request->number;
            // Jika ada judul tambahan, tempel di belakang: "chapter-1-prologue"
            if ($request->filled('title')) {
                $slugCandidate .= '-' . $request->title;
            }
            $slugCandidate = Str::slug($slugCandidate);
        }

        // Cek Duplikat: Jika slug sudah ada di database, tambahkan uniqid
        if (Chapter::where('slug', $slugCandidate)->exists()) {
            $slugCandidate .= '-' . uniqid();
        }
        
        $data['slug'] = $slugCandidate;

        // --- 2. UPLOAD GAMBAR (MULTIPLE) ---
        $imagePaths = [];
        if ($request->hasFile('content_images')) {
            foreach ($request->file('content_images') as $image) {
                // Simpan ke storage/app/public/chapters
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

    // ==========================================
    // UPDATE (EDIT DATA)
    // ==========================================
    public function update(Request $request, Chapter $chapter)
    {
        $request->validate([
            'comic_id' => 'required',
            'number'   => 'required|numeric',
            'slug'     => 'nullable|string|max:255',
            'content_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = $request->except(['content_images']);

        // --- 1. LOGIKA SLUG SAAT EDIT ---
        // Kita hanya ubah slug jika Admin MENGETIK sesuatu di input slug.
        // Jika dikosongkan, biarkan slug lama (agar link SEO tidak mati).
        if ($request->filled('slug')) {
            $slugCandidate = Str::slug($request->slug);
            
            // Cek duplikat (kecuali punya diri sendiri)
            if (Chapter::where('slug', $slugCandidate)->where('id', '!=', $chapter->id)->exists()) {
                $slugCandidate .= '-' . uniqid();
            }
            $data['slug'] = $slugCandidate;
        }

        // --- 2. UPDATE GAMBAR (REPLACE) ---
        if ($request->hasFile('content_images')) {
            // Hapus gambar lama
            if ($chapter->content_images) {
                foreach ($chapter->content_images as $oldImage) {
                    if(!Str::startsWith($oldImage, 'http')) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
            }
            // Upload gambar baru
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
        // Hapus file fisik
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