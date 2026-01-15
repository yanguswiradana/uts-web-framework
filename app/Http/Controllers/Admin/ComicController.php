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

    public function store(Request $request)
    {
        // VALIDASI KETAT
        $request->validate([
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'description' => 'required|string',
            'type'        => 'required|in:Manga,Manhwa,Manhua',
            'status'      => 'required|in:Ongoing,Completed',
            // Wajib Gambar (jpeg, png, jpg, webp) maks 2MB
            'cover'       => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', 
            'genres'      => 'required|array|min:1', // Wajib pilih minimal 1 genre
        ], [
            // Custom Error Message (Opsional, biar bahasa Indonesia)
            'title.required' => 'Judul komik wajib diisi.',
            'cover.required' => 'Cover komik wajib diupload.',
            'cover.image'    => 'File harus berupa gambar.',
            'cover.mimes'    => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'genres.required'=> 'Pilih minimal satu genre.'
        ]);

        $data = $request->except(['cover', 'genres']);
        $data['slug'] = Str::slug($request->title . '-' . Str::random(5));

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('comics', 'public');
        }

        $comic = Comic::create($data);
        $comic->genres()->attach($request->genres);

        return redirect()->route('admin.comics.index')->with('success', 'Komik berhasil ditambahkan!');
    }

    public function edit(Comic $comic)
    {
        $genres = Genre::all();
        return view('admin.comics.edit', compact('comic', 'genres'));
    }

    public function update(Request $request, Comic $comic)
    {
        // VALIDASI UPDATE
        $request->validate([
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'description' => 'required|string',
            'type'        => 'required|in:Manga,Manhwa,Manhua',
            'status'      => 'required|in:Ongoing,Completed',
            // Cover boleh kosong saat update (nullable), tapi KALO diisi harus gambar
            'cover'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'genres'      => 'required|array|min:1',
        ]);

        $data = $request->except(['cover', 'genres']);
        
        // Update slug jika judul berubah (opsional, tapi lebih baik jangan biar link SEO gak mati)
        // $data['slug'] = Str::slug($request->title . '-' . Str::random(5)); 

        if ($request->hasFile('cover')) {
            // Hapus gambar lama
            if ($comic->cover && !Str::startsWith($comic->cover, 'http')) {
                Storage::disk('public')->delete($comic->cover);
            }
            $data['cover'] = $request->file('cover')->store('comics', 'public');
        }

        $comic->update($data);
        $comic->genres()->sync($request->genres);

        return redirect()->route('admin.comics.index')->with('success', 'Komik berhasil diperbarui!');
    }

    public function destroy(Comic $comic)
    {
        if ($comic->cover && !Str::startsWith($comic->cover, 'http')) {
            Storage::disk('public')->delete($comic->cover);
        }
        $comic->genres()->detach();
        $comic->delete();

        return redirect()->route('admin.comics.index')->with('success', 'Komik berhasil dihapus!');
    }
}