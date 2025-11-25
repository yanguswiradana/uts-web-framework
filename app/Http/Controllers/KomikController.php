<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class KomikController extends Controller
{
    /**
     * PRIVATE METHOD: PUSAT DATA (SINGLE SOURCE OF TRUTH)
     */
    private function getComicData()
    {
        $rawComics = [
            // --- DATA DARI HOME/EXPLORE ---
            [
                'title' => 'Omniscient Reader’s Viewpoint',
                'type' => 'Manhwa',
                'chapters' => 289,
                'genre' => 'Fantasy, System, Adventure',
                'status' => 'Ongoing',
                'rating' => 9.8,
                'cover' => 'images/orv.jpg',
                // CONTOH 1: Sinopsis Manual
                'synopsis' => 'Kim Dokja hanyalah seorang karyawan biasa yang hobinya membaca novel web favoritnya, "Tiga Cara Bertahan Hidup di Dunia yang Hancur". Namun, saat novel itu tamat, dunia nyata tiba-tiba berubah menjadi skenario mematikan persis seperti di dalam cerita.'
            ],
            [
                'title' => 'Infinite Mage',
                'type' => 'Manhwa',
                'chapters' => 145,
                'genre' => 'Action, Fantasy, Magic',
                'status' => 'Ongoing',
                'rating' => 9.2,
                'cover' => 'images/infinite_mage.jpg',
                'synopsis' => 'Seorang anak laki-laki biasa yang bercita-cita menjadi penyihir terhebat. Dia menemukan bahwa dia memiliki bakat luar biasa dalam sihir yang melampaui akal sehat.'
            ],
            [
                'title' => 'Nano Machine',
                'type' => 'Manhwa',
                'chapters' => 287,
                'genre' => 'Murim, System, Supernatural',
                'status' => 'Ongoing',
                'rating' => 9.5,
                'cover' => 'images/nano_machine.jpg',
                'synopsis' => 'Cheon Yeo-Woon, seorang anak haram dari Sekte Iblis yang dihina, tiba-tiba didatangi oleh keturunannya dari masa depan yang memasukkan Nano Machine ke dalam tubuhnya, mengubah nasibnya selamanya.'
            ],
            [
                'title' => 'Pick Me Up',
                'type' => 'Manhwa',
                'chapters' => 176,
                'genre' => 'Comedy, Action, Adventure',
                'status' => 'Ongoing',
                'rating' => 9.7,
                'cover' => 'images/pick_me_up.jpg',
                'synopsis' => 'Dalam game gacha yang terkenal dengan kesulitannya yang mengerikan Master peringkat ke5 di dunia Loki kehilangan kesadaran saat menyerbu Dungeon
                                Apa Aku karakter game sekarang
                                Setelah bangun Loki menyadari bahwa dia telah berubah menjadi Pahlawan Level 1 Bintang 1Han Yslat Untuk kembali ke Bumi dia harus memimpin para master dan hero pemula dan membersihkan lantai 100 Dungeon
                                Kau macammacam dengan orang yang salah
                                Ini adalah kisah perjuangan keras Master Loki yang belum pernah mengalami satu kekalahan pun'
                // Jika tidak ada 'synopsis', akan pakai default
            ],
            [
                'title' => 'Reality Quest',
                'type' => 'Manhwa',
                'chapters' => 179,
                'genre' => 'Action, Fantasy, System',
                'status' => 'Ongoing',
                'rating' => 9.1,
                'cover' => 'images/reality_quest.jpg',
                'synopsis' => 'Karena ancaman pengganggu sekolah untuk memberinya item game Ha Dowan shuttle game yang tidak beruntung meninggal setelah bermain game sepanjang malam selama seminggu Saat dia meninggal dia dibangkitkan kembali ke ruang kelas satu minggu sebelum dia meninggal Semuanya sama seperti hari itu Satusatunya hal yang berubah adalah mengambang di depannya Apa Gunakan keterampilan permainan yang saya mainkan sejauh ini untuk mengalahkan pengganggu'
            ],
            [
                'title' => 'The World After The Fall',
                'type' => 'Manhwa',
                'chapters' => 209,
                'genre' => 'Adventure, Fantasy, Action',
                'status' => 'Ongoing',
                'rating' => 9.2,
                'cover' => 'images/World_after_the_fall.jpg',
                'synopsis' => 'Manusia tibatiba dipanggil untuk menjadi Walkers dan mereka perlu menyelesaikan menara untuk menyelamatkan dunia
                            Kemudian Regression Stone ditemukan sekarang Walkers bisa kembali ke masa lalu
                            Dan perlahanlahan semua orang pergi Jika aku pergi ke masa lalu lalu bagaimana dengan nasib orangorang di dunia ini
                            Siapa yang akan menyelamatkan mereka
                            Harapan terakhir umat manusia kelompok Carpe Diem
                            dibentuk oleh orangorang yang menolak untuk meninggalkan dunia
                            Tapi begitu Walker terakhir mencapai lantai 100 dia tidak tahu lagi apa yg harus dia percayai
                            Ini adalah kisah tentang satusatunya pria yang pantang mundur untuk meninggalkan dunianya meskipun semua walker yang lain kembali ke masa lalu'
            ],
            [
                'title' => 'Return of the Mount Hua Sect',
                'type' => 'Manhwa',
                'chapters' => 152,
                'genre' => 'Murim, Action, Comedy',
                'status' => 'Ongoing',
                'rating' => 9.9,
                'cover' => 'images/return_of_the_mount_hua_sect.jpg',
                'synopsis' => 'Chung Myung, Sang Saint Pedang Bunga Plum, mengalahkan Cheon Ma namun tewas. Dia terbangun 100 tahun kemudian dalam tubuh anak pengemis, dan mendapati sekte Mount Hua telah runtuh.'
            ],

            // --- DATA TAMBAHAN DARI LIBRARY KAMU ---
            [
                'title' => 'Bones',
                'type' => 'Manhwa',
                'chapters' => 30,
                'genre' => 'Action, Gore, Thriller',
                'status' => 'Ongoing',
                'rating' => 8.8,
                'cover' => 'images/bones.jpg',
                'synopsis' => 'Jihyun, seorang Hunter yang ingin melindungi ibunya, tewas dalam Dungeon. Namun dia bangkit kembali sebagai tengkorak (Skeleton) dan memulai evolusinya untuk menjadi yang terkuat.'
            ],
            [
                'title' => 'Star Ginseng Store',
                'type' => 'Manhwa',
                'chapters' => 186,
                'genre' => 'Drama, Slice of Life, Romance',
                'status' => 'Ongoing',
                'rating' => 8.5,
                'cover' => 'images/star_ginseng_store.jpg',
                'synopsis' => ' Menceritakan tentang Ji Suwon, seorang siswa baru SMA biasa yang memiliki bakat menggambar. Ia jatuh cinta pada seorang gadis yang sudah punya pacar, tetapi kemudian bertemu Seol Hyorim, gadis tercantik di sekolah, dan langsung jatuh cinta padanya. Ia menggambar gadis itu secara diam-diam, tetapi gambarnya ditemukan oleh Yang Jinsu dan diperlihatkan kepada Seol Hyorim. Apakah cinta pertama Suwon yang kedua dapat dipertahankan?'
            ],
            [
                'title' => 'My Bias Gets On The Last Train',
                'type' => 'Manhwa',
                'chapters' => 54,
                'genre' => 'Romance, Fantasy',
                'status' => 'Ongoing',
                'rating' => 8.7,
                'cover' => 'images/mykisah.jpg',
                'synopsis' =>'“Lagi-lagi aku bertemu dengannya di kereta terakhir. Andai saja aku bisa berbicara dengannya!” Yeo-un, seorang mahasiswa yang bekerja hingga larut malam dan naik kereta terakhir setiap malamnya.
                                Ia setiap saat selalu bertemu dengan Shin Haein, seorang wanita yang membawa gitar di sana.
                                Seolah untaian benang takdir bermain, keduanya terus bertemu dan pada akhirnya menyadari artis favorit mereka sama, musisi indie “Long Afternoon.” Lambat laun, mereka menjadi lebih dekat dan dimulailah kisah ini.'
            ],
            [
                'title'=> 'One Piece',
                'type'=> 'Manga',
                'chapters'=> '1166',
                'genre'=> 'Adventure, Action',
                'status'=> 'Ongoing',
                'rating'=> '9.9',
                'cover'=> 'images/one_piece.jpg',
                'synopsis'=> 'Bercerita tentang seorang lakilaki bernama Monkey D Luffy yang menentang arti dari gelar bajak laut Daripada kesannama besar kejahatan kekerasan dia lebih terlihat seperti bajak laut rendahan yang suka bersenangsenang alasanLuffy menjadi bajak laut adalah tekadnya untuk berpetualang di lautan yang menyenangkan dan bertemu orangorangbaru dan menarik sertabersamasama mencari One Piece'
            ],
            [
                'title' => 'Jujutsu Kaisen',
                'type' => 'Manga',
                'chapters' => 271,
                'genre' => 'Action, Supernatural',
                'status' => 'Completed',
                'rating' => 9.4,
                'cover' => 'images/jjk.jpg',
                'synopsis'=> 'Yuuji adalah seorang jenius di jalur dan lapangan Tapi dia memiliki minat nol dia senang sebagai clam di Klub Penelitian Ilmu Ghaib Meskipun Dia di Klub hanya untuk Iseng Halhal menjadi serius ketika semangat nyata muncul di sekolah Hidup akan menjadi sangat aneh Di SMA Sugisawa 3'
            ],
            [
                'title' => 'Magic Emperor',
                'type' => 'Manhua',
                'chapters' => 783, 
                'genre' => 'Cultivation, Action', 
                'status' => 'Ongoing', 'rating' => 9.5, 
                'cover' => 'images/magic_emperor.jpg',
                'synopsis'=> 'Karena dia memiliki warisan Ancient Demonic emperor Demonic Emperor Zhuo Yifan menemui nasib sial karena dikhianati dan dibunuh oleh murid kepercayaannya Setelah terlahir kembali kultivasinya kembali ke nol dan dia terjebak oleh heart demon tidak diberi pilihan selain menjadi pengurus rumah tangga dari satusatunya nona tertua Keluarga Luo Dari menjadi Demonic Emperor menjadi pengurus rumah tangga yang tidak penting bagaimana dia bisa bergaul dengan eart demon eldest miss dan kekuatan apa yang akan dia peroleh untuk memimpin dirinya sendiri dan keluarga yang menurun untuk bangkit kembali ke puncak benua'
            ],
            [
                'title' => 'Tales of Demons and Gods', 
                'type' => 'Manhua', 
                'chapters' => 506, 
                'genre' => 'Cultivation, Fantasy', 
                'status' => 'Ongoing', 
                'rating' => 9.0,
                'cover' => 'images/demons_and_god.jpg',
                'synopsis'=> 'Nie Lie Demon Spiritist yang terkuat dikehidupan masa lalunya yang berdiri di puncak dunia persilatan namun dia kehilangan nyawanya saat pertarungan dengan Sage Emperor dan keenam dewa berperingkat binatang jiwanya kemudian terlahir kembali saat dia masih berumur 13 tahun Meskipun dia yang paling lemah di kelasnya dengan bakat terendah hanya diranah Red soul tapi dengan bantuan pengetahuan yang luas yang dia akumulasi dari kehidupan sebelumnya dia terlatih begitu cepat dari pada siapapun Mencoba untuk melindungi kota di masa mendatang sedang diserang oleh binatang dan akhirnya hancur serta melindungi kekasihnya temantemannya dan keluarganya yang meninggal karena serangan binatang Dan untuk menghancurkan keluarga Sacred yang meninggalkan tugas mereka dan kota yang dikhianati dalam kehidupan masa lalunya'
            ],
        ];

        return collect($rawComics)->map(function ($data) {
            $slug = Str::slug($data['title']);

            // Pastikan cover ada
            if (!isset($data['cover']) || empty($data['cover'])) {
                $data['cover'] = 'https://via.placeholder.com/300x400/1f2937/FFFFFF?text=No+Cover';
            }

            // --- LOGIKA SINOPSIS (MODIFIKASI DI SINI) ---
            // Gunakan operator '??' (Null Coalescing)
            // Jika key 'synopsis' ada di array data, pakai itu.
            // Jika tidak ada, pakai kalimat default.
            $finalSynopsis = $data['synopsis'] ?? "Sinopsis default untuk komik " . $data['title'] . ". Cerita seru yang wajib kamu baca! Ikuti petualangan karakter utama dalam menghadapi berbagai rintangan.";

            return array_merge($data, [
                'slug' => $slug,
                'synopsis' => $finalSynopsis // Masukkan hasil seleksi sinopsis ke data akhir
            ]);
        });
    }

    // --- 1. HALAMAN HOME ---
    public function home()
    {
        $allComics = $this->getComicData();

        $manga = $allComics->where('type', 'Manga')->values()->take(6);
        $manhwa = $allComics->where('type', 'Manhwa')->values()->take(6);
        $manhua = $allComics->where('type', 'Manhua')->values()->take(6);
        $latestUpdates = $allComics->shuffle()->take(12);

        return view('home', compact('manga', 'manhwa', 'manhua', 'latestUpdates'));
    }

    // --- 2. HALAMAN EXPLORE ---
    public function index(Request $request)
    {
        $allComics = $this->getComicData();

        // Parameter Filter
        $selectedGenres = (array) $request->input('genre', []);
        $selectedStatus = $request->input('status', 'Semua');
        $searchTerm = $request->input('search', '');
        $sortBy = $request->input('sort', 'Terbaru');

        // Logic Filter
        $filteredComics = $allComics->filter(function ($comic) use ($selectedGenres, $selectedStatus, $searchTerm) {
            $comicGenresStr = is_array($comic['genre']) ? implode(',', $comic['genre']) : $comic['genre'];
            $comicGenres = array_map('trim', explode(',', $comicGenresStr));
            $comicGenresLower = array_map('mb_strtolower', $comicGenres);
            $selectedLower = array_map('mb_strtolower', $selectedGenres);

            $genreMatch = empty($selectedGenres) || count(array_intersect($comicGenresLower, $selectedLower)) > 0;
            $statusMatch = ($selectedStatus == 'Semua') || ($comic['status'] == $selectedStatus);
            $searchMatch = empty($searchTerm) || (stripos($comic['title'], $searchTerm) !== false);

            return $genreMatch && $statusMatch && $searchMatch;
        });

        // Logic Sort
        switch ($sortBy) {
            case 'Populer (All Time)': $filteredComics = $filteredComics->sortByDesc('chapters'); break;
            case 'Terbanyak Dibaca': $filteredComics = $filteredComics->sortByDesc('rating'); break;
            case 'A-Z': $filteredComics = $filteredComics->sortBy('title'); break;
            case 'Terbaru': default: $filteredComics = $filteredComics->reverse(); break;
        }

        // Pagination
        $currentPage = Paginator::resolveCurrentPage();
        $perPage = 12;
        $currentPageItems = $filteredComics->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $paginatedComics = new LengthAwarePaginator(
            $currentPageItems, $filteredComics->count(), $perPage, $currentPage,
            ['path' => Paginator::resolveCurrentPath(), 'query' => $request->query()]
        );

        $allGenres = ['Action', 'Fantasy', 'Romance', 'Comedy', 'Horror', 'Slice of Life', 'Sci-Fi', 'Drama', 'Adventure', 'Cultivation', 'Gore', 'System', 'Magic', 'Murim', 'Supernatural'];

        return view('pages.explore', compact('paginatedComics', 'allGenres', 'selectedGenres', 'selectedStatus', 'searchTerm', 'sortBy'));
    }

    // --- 3. HALAMAN LIBRARY ---
    public function library(Request $request)
    {
        $allComics = $this->getComicData();
        $searchTerm = $request->input('search');

        // DAFTAR JUDUL FAVORIT (Simulasi Database User Favorites)
        $myFavoriteTitles = [
            'Bones',
            'Star Ginseng Store',
            'My Bias Gets On The Last Train',
            'Pick Me Up',
            'Nano Machine',
            'Reality Quest'
        ];

        // 1. Ambil komik yang sesuai dengan daftar favorit
        $favoriteComics = $allComics->filter(function($comic) use ($myFavoriteTitles) {
            return in_array($comic['title'], $myFavoriteTitles);
        });

        // 2. Jika ada pencarian di dalam Library
        if ($searchTerm) {
            $favoriteComics = $favoriteComics->filter(function($comic) use ($searchTerm) {
                return stripos($comic['title'], $searchTerm) !== false;
            });
        }

        return view('pages.library', compact('favoriteComics'));
    }

    // --- 4. HALAMAN DETAIL ---
    public function show($slug)
    {
        $allComics = $this->getComicData();
        $comic = $allComics->firstWhere('slug', $slug);

        if (!$comic) {
            abort(404);
        }

        // Dummy Chapters (List)
        $chapters = [];
        $totalChapters = $comic['chapters'];
        for ($i = $totalChapters; $i >= 1; $i--) {
            $daysAgo = ($totalChapters - $i) * 2;
            $chapters[] = [
                'number' => $i,
                'title' => null,
                'date' => now()->subDays($daysAgo)->diffForHumans(),
                'image' => $comic['cover'],
                'is_new' => $i > ($totalChapters - 3)
            ];
        }
        $latestChapters = array_slice($chapters, 0, 12);

        return view('pages.detail', compact('comic', 'chapters', 'latestChapters'));
    }

    // --- 5. HALAMAN BACA CHAPTER (VIEWER) ---
    public function read($slug, $chapterNumber)
    {
        $allComics = $this->getComicData();
        $comic = $allComics->firstWhere('slug', $slug);

        if (!$comic) {
            abort(404);
        }

        // Dummy Images untuk Reader
        $chapterImages = [];
        $totalImages = rand(10, 15);
        for ($i = 1; $i <= $totalImages; $i++) {
            $bgColor = dechex(rand(0x1f1f1f, 0x3f3f3f));
            $chapterImages[] = "https://via.placeholder.com/800x1200/{$bgColor}/FFFFFF?text=Chapter+{$chapterNumber}+-+Image+{$i}";
        }

        $prevChapter = ($chapterNumber > 1) ? $chapterNumber - 1 : null;
        $nextChapter = ($chapterNumber < $comic['chapters']) ? $chapterNumber + 1 : null;

        return view('pages.read', compact('comic', 'chapterNumber', 'chapterImages', 'prevChapter', 'nextChapter'));
    }
}
