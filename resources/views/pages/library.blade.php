@extends('layouts.app')

@section('title', 'Library Saya - KOMIKIN')

@section('content')

    <div class="relative bg-neutral-900 border border-white/5 rounded-3xl p-8 mb-10 overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-purple-600/10 rounded-full blur-3xl pointer-events-none -mr-16 -mt-16"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2 flex items-center gap-3">
                    <span class="w-10 h-10 bg-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-purple-600/20">
                        <i data-lucide="heart" class="w-5 h-5 text-white fill-white"></i>
                    </span>
                    Library Saya
                </h1>
                <p class="text-neutral-400 text-sm max-w-md">
                    Simpan komik favoritmu disini agar tidak ketinggalan update chapter terbaru.
                </p>
            </div>

            <form action="{{ route('library.index') }}" method="GET" class="w-full md:w-auto">
                <div class="relative group">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari di library..." 
                           class="w-full md:w-72 bg-neutral-950 border border-white/10 rounded-full py-3 pl-10 pr-4 text-sm text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500 focus:outline-none transition-all placeholder:text-neutral-600">
                    <i data-lucide="search" class="absolute left-3.5 top-3 w-4 h-4 text-neutral-500 group-hover:text-purple-400 transition-colors"></i>
                </div>
            </form>
        </div>
    </div>

    @if($favoriteComics->count() > 0)
        <div class="flex items-center gap-2 mb-6">
            <span class="w-2 h-2 rounded-full bg-purple-500"></span>
            <h2 class="text-white font-bold">Daftar Favorit <span class="text-neutral-500 text-sm font-normal">({{ $favoriteComics->count() }})</span></h2>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-5">
            @foreach($favoriteComics as $comic)
                <x-comic-card-home :comic="$comic" />
            @endforeach
        </div>
    @else
        <div class="py-24 text-center">
            <div class="w-24 h-24 bg-neutral-900 rounded-full flex items-center justify-center mx-auto mb-6 border border-white/5 shadow-inner">
                <i data-lucide="bookmark-minus" class="w-10 h-10 text-neutral-600"></i>
            </div>
            
            @if(request('search'))
                <h3 class="text-xl font-bold text-white mb-2">Tidak Ditemukan</h3>
                <p class="text-neutral-400 max-w-sm mx-auto mb-6">
                    Komik dengan judul "<span class="text-purple-400">{{ request('search') }}</span>" tidak ada di library kamu.
                </p>
                <a href="{{ route('library.index') }}" class="text-sm font-bold text-white hover:text-purple-400 transition-colors">
                    Hapus Pencarian
                </a>
            @else
                <h3 class="text-xl font-bold text-white mb-2">Library Masih Kosong</h3>
                <p class="text-neutral-400 max-w-sm mx-auto mb-8">
                    Kamu belum menambahkan komik ke daftar favorit. Yuk cari komik seru di halaman Explore!
                </p>
                <a href="{{ route('explore.index') }}" class="inline-flex items-center gap-2 bg-white text-neutral-950 px-6 py-3 rounded-full font-bold hover:bg-neutral-200 transition-colors">
                    <i data-lucide="compass" class="w-4 h-4"></i> Mulai Jelajah
                </a>
            @endif
        </div>
    @endif

    <div class="mb-20"></div>
@endsection