<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminComicController extends Controller
{
    // 1. Halaman Dashboard (List Komik)
    public function index()
    {
        $comics = Comic::latest()->get();
        return view('admin.index', compact('comics'));
    }

    // 2. Halaman Tambah Komik
    public function create()
    {
        return view('admin.create');
    }

    // 3. Proses Simpan ke Database & Upload Gambar
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:4096', // Validasi gambar
        ]);

        // UPLOAD GAMBAR OTOMATIS
        // File akan masuk ke folder: storage/app/public/comics
        $path = $request->file('image')->store('comics', 'public');

        // SIMPAN DATA KE DB
        Comic::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'image_path' => $path, // Simpan alamat gambarnya saja
            'description' => $request->description,
            'author' => $request->author,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Berhasil upload!');
    }

    // 4. Hapus Komik
    public function destroy($id)
    {
        $comic = Comic::findOrFail($id);
        // Hapus file gambar dari folder biar bersih
        Storage::disk('public')->delete($comic->image_path);
        $comic->delete();
        return back();
    }
}
