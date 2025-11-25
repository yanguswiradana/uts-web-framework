<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function index()
    {
        // 1. DATA DUMMY (Dipindahkan dari View)
        // Kita simpan path gambarnya saja (string), nanti 'asset()' dipanggil di View.
        // Ini mensimulasikan data yang biasanya diambil dari Database.
        $favoriteComics = [
            [
                'title' => 'Bones',
                'chapter' => 30,
                'type' => 'Manhwa',
                'image_path' => 'images/bones.jpg' // Ganti key jadi image_path agar jelas
            ],
            [
                'title' => 'Star Ginseng Store',
                'chapter' => 186,
                'type' => 'Manhwa',
                'image_path' => 'images/star_ginseng_store.jpg'
            ],
            [
                'title' => 'My Bias Gets On The Last Train',
                'chapter' => 54,
                'type' => 'Manhwa',
                'image_path' => 'images/mykisah.jpg' // Sesuaikan nama file gambar Anda
            ],
            [
                'title' => 'Pick Me Up',
                'chapter' => 176,
                'type' => 'Manhwa',
                'image_path' => 'images/pick_me_up.jpg'
            ],
            [
                'title' => 'Nano Machine',
                'chapter' => 287,
                'type' => 'Manhwa',
                'image_path' => 'images/nano_machine.jpg'
            ],
            [
                'title' => 'Reality Quest',
                'chapter' => 179,
                'type' => 'Manhwa',
                'image_path' => 'images/reality_quest.jpg'
            ],
        ];

        // 2. Return View dengan membawa data
        return view('pages.library', compact('favoriteComics'));
    }
}