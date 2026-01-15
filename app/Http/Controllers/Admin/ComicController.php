<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comic;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ComicController extends Controller
{
    public function index()
    {
        $comics = Comic::with('genres')->latest()->paginate(10);
        return view('admin.comics.index', compact('comics'));
    }

    public function create()
    {
        $genres = Genre::all();
        return view('admin.comics.create', compact('genres'));
    }

    // ==========================================
    // STORE (SIMPAN BARU)
    // ==========================================
    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'description' => 'required|string',
            'type'        => 'required|in:Manga,Manhwa,Manhua',
            'status'      => 'required|in:Ongoing,Completed',
            'cover'       => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'genres'      => 'required|array|min:1', // Wajib pilih minimal 1
        ]);

        // 2. Pisahkan data 'cover' dan 'genres' dari data utama
        // Agar tidak error "Column genres not found"
        $data = $request->except(['cover', 'genres']);
        
        // 3. Buat Slug Otomatis
        $data['slug'] = Str::slug($request->title . '-' . Str::random(5));

        // 4. Upload Cover
        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('comics', 'public');
        }

        // 5. Simpan Data Komik Dulu
        $comic = Comic::create($data);

        // 6. Baru Simpan Genre (Relasi Many-to-Many)
        // Kita gunakan attach() untuk data baru
        $comic->genres()->attach($request->genres);

        return redirect()->route('admin.comics.index')->with('success', 'Komik berhasil ditambahkan!');
    }

    public function edit(Comic $comic)
    {
        $genres = Genre::all();
        return view('admin.comics.edit', compact('comic', 'genres'));
    }

    // ==========================================
    // UPDATE (EDIT DATA)
    // ==========================================
    public function update(Request $request, Comic $comic)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'description' => 'required|string',
            'type'        => 'required|in:Manga,Manhwa,Manhua',
            'status'      => 'required|in:Ongoing,Completed',
            'cover'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'genres'      => 'required|array|min:1',
        ]);

        // Pisahkan data lagi
        $data = $request->except(['cover', 'genres']);
        
        // Update Gambar jika ada upload baru
        if ($request->hasFile('cover')) {
            // Hapus gambar lama
            if ($comic->cover && !Str::startsWith($comic->cover, 'http')) {
                Storage::disk('public')->delete($comic->cover);
            }
            $data['cover'] = $request->file('cover')->store('comics', 'public');
        }

        // Update Tabel Komik
        $comic->update($data);

        // Update Genre (Pakai sync untuk menimpa genre lama dengan yang baru)
        $comic->genres()->sync($request->genres);

        return redirect()->route('admin.comics.index')->with('success', 'Komik berhasil diperbarui!');
    }

    public function destroy(Comic $comic)
    {
        if ($comic->cover && !Str::startsWith($comic->cover, 'http')) {
            Storage::disk('public')->delete($comic->cover);
        }
        // Hapus relasi genre dulu sebelum hapus komik
        $comic->genres()->detach();
        $comic->delete();

        return redirect()->route('admin.comics.index')->with('success', 'Komik berhasil dihapus!');
    }
}