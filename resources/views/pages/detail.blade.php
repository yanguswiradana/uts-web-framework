@extends('layouts.app')

@section('title', $comic->title)

@section('content')

    <div class="relative bg-neutral-900 border border-white/5 rounded-3xl p-6 md:p-10 mb-10 overflow-hidden shadow-2xl">
        
        <div class="absolute top-0 right-0 w-96 h-96 bg-purple-600/20 rounded-full blur-[100px] -mr-20 -mt-20 pointer-events-none"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row gap-8 md:gap-12">
            
            <div class="w-full md:w-72 shrink-0 group">
                <div class="aspect-[2/3] rounded-2xl overflow-hidden shadow-2xl border border-white/10 relative">
                    <img src="{{ Str::startsWith($comic->cover, 'http') ? $comic->cover : asset('storage/' . $comic->cover) }}" 
                         alt="{{ $comic->title }}" 
                         class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                    
                    <div class="absolute top-3 right-3 px-3 py-1 rounded-full text-xs font-bold backdrop-blur-md border border-white/20 
                        {{ $comic->status == 'Ongoing' ? 'bg-green-500/80 text-white' : 'bg-blue-500/80 text-white' }}">
                        {{ $comic->status }}
                    </div>
                </div>
            </div>

            <div class="flex-1 flex flex-col">
                <div class="mb-4">
                    <span class="text-purple-400 font-bold tracking-wider text-xs uppercase mb-2 block">{{ $comic->type }}</span>
                    
                    <h1 class="text-3xl md:text-5xl font-bold text-white leading-tight mb-2">{{ $comic->title }}</h1>
                    
                    <div class="flex items-center gap-2 text-neutral-400 text-sm mb-4">
                        <i data-lucide="pen-tool" class="w-4 h-4 text-neutral-500"></i>
                        <span class="font-medium">Author: <span class="text-white">{{ $comic->author }}</span></span>
                    </div>

                    <div class="flex flex-wrap gap-2 mb-6">
                        @foreach($comic->genres as $genre)
                            <a href="{{ route('explore.index', ['genre[]' => $genre->name]) }}" class="px-3 py-1 rounded-lg bg-white/5 hover:bg-white/10 border border-white/5 text-xs text-neutral-300 hover:text-white transition-colors">
                                {{ $genre->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 border-y border-white/5 py-6 mb-6">
                    <div>
                        <p class="text-neutral-500 text-xs uppercase font-bold mb-1">Total Chapter</p>
                        <p class="text-white font-bold text-lg">{{ $comic->chapters_count }}</p>
                    </div>
                    
                    <div>
                        <p class="text-neutral-500 text-xs uppercase font-bold mb-1">Rilis</p>
                        <p class="text-white font-bold text-lg">
                            {{ $comic->release_year ?? $comic->created_at->format('Y') }}
                        </p>
                    </div>
                    
                    <div x-data="{ openRating: false }" class="relative">
                        <p class="text-neutral-500 text-xs uppercase font-bold mb-1">Rating</p>
                        <div class="flex items-center gap-1 text-yellow-500 font-bold text-lg cursor-pointer hover:opacity-80 transition-opacity" @click="openRating = !openRating">
                            <i data-lucide="star" class="w-5 h-5 fill-current"></i> 
                            <span>{{ number_format($comic->ratings_avg_stars ?? 0, 1) }}</span>
                            @if(isset($comic->ratings_count))
                                <span class="text-xs text-neutral-500 font-normal ml-1">({{ $comic->ratings_count }})</span>
                            @endif
                        </div>

                        <div x-show="openRating" @click.outside="openRating = false" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="absolute mt-2 left-0 bg-neutral-900 border border-white/10 rounded-xl p-4 shadow-2xl z-50 w-64 md:w-72"
                             style="display: none;">
                             
                            @auth
                                <form action="{{ route('komik.rate', $comic->slug) }}" method="POST">
                                    @csrf
                                    <div class="text-center mb-3">
                                        <p class="text-sm text-white font-bold">Beri Penilaian</p>
                                        <p class="text-xs text-neutral-400">Bagaimana menurutmu komik ini?</p>
                                    </div>
                                    
                                    <div class="flex flex-row-reverse justify-center gap-2 mb-4 group">
                                        @for($i = 5; $i >= 1; $i--)
                                            <input type="radio" id="star{{$i}}" name="stars" value="{{$i}}" 
                                                   class="peer hidden" 
                                                   {{ (Auth::user()->user_rating && Auth::user()->user_rating->stars == $i) ? 'checked' : '' }} />
                                            <label for="star{{$i}}" class="cursor-pointer text-neutral-700 peer-checked:text-yellow-500 hover:text-yellow-400 peer-hover:text-yellow-400 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 fill-current" viewBox="0 0 24 24">
                                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-5.82 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                                </svg>
                                            </label>
                                        @endfor
                                    </div>

                                    <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold py-2.5 rounded-lg transition-colors shadow-lg shadow-purple-900/20">
                                        Kirim Rating
                                    </button>
                                </form>
                            @else
                                <div class="text-center py-2">
                                    <div class="w-10 h-10 bg-neutral-800 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <i data-lucide="lock" class="w-4 h-4 text-neutral-400"></i>
                                    </div>
                                    <p class="text-xs text-neutral-400 mb-3">Silakan login untuk memberi rating.</p>
                                    <a href="{{ route('login') }}" class="block w-full bg-white text-neutral-950 hover:bg-neutral-200 text-xs font-bold py-2 rounded-lg transition-colors">
                                        Masuk Akun
                                    </a>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>

                <div class="mb-8 flex-1">
                    <h3 class="text-white font-bold mb-2">Sinopsis</h3>
                    <p class="text-neutral-400 text-sm leading-relaxed whitespace-pre-line">
                        {{ $comic->description ?? 'Belum ada deskripsi untuk komik ini.' }}
                    </p>
                </div>

                <div class="flex gap-3 mt-auto">
                    @if($chapters->count() > 0)
                        <a href="{{ route('komik.read', [$comic->slug, $chapters->last()->number]) }}" 
                           class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-bold py-3.5 px-6 rounded-xl shadow-lg shadow-purple-900/40 transition-all flex items-center justify-center gap-2 hover:-translate-y-0.5">
                            <i data-lucide="book-open" class="w-5 h-5"></i>
                            <span>Mulai Baca</span>
                        </a>
                    @else
                        <button disabled class="flex-1 bg-neutral-800 text-neutral-500 font-bold py-3.5 px-6 rounded-xl cursor-not-allowed flex items-center justify-center gap-2">
                            <i data-lucide="clock" class="w-5 h-5"></i>
                            <span>Coming Soon</span>
                        </button>
                    @endif

                    @auth
                        <form action="{{ route('komik.bookmark', $comic->slug) }}" method="POST">
                            @csrf
                            @if(Auth::user()->hasBookmarked($comic->id))
                                <button type="submit" class="h-14 w-14 rounded-xl border border-red-500/30 bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white flex items-center justify-center transition-all shadow-lg shadow-red-900/10" title="Hapus dari Library">
                                    <i data-lucide="bookmark-minus" class="w-6 h-6 fill-current"></i>
                                </button>
                            @else
                                <button type="submit" class="h-14 w-14 rounded-xl border border-white/10 bg-neutral-800 text-neutral-400 hover:border-purple-500 hover:text-purple-400 hover:bg-white/5 flex items-center justify-center transition-all" title="Simpan ke Library">
                                    <i data-lucide="bookmark-plus" class="w-6 h-6"></i>
                                </button>
                            @endif
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="h-14 w-14 rounded-xl border border-white/10 bg-neutral-800 text-neutral-400 hover:bg-neutral-700 hover:text-white flex items-center justify-center transition-all" title="Login untuk Bookmark">
                            <i data-lucide="bookmark" class="w-6 h-6"></i>
                        </a>
                    @endauth
                </div>

            </div>
        </div>
    </div>

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-white flex items-center gap-2">
            <i data-lucide="layers" class="w-6 h-6 text-purple-500"></i> Daftar Chapter
        </h2>
        
        <div class="relative hidden sm:block">
            <input type="text" placeholder="Cari chapter..." class="bg-neutral-900 border border-white/10 rounded-full py-2 pl-9 pr-4 text-sm focus:outline-none focus:border-purple-500 w-48 transition-all focus:w-64 text-white">
            <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-neutral-500"></i>
        </div>
    </div>

    <div class="bg-neutral-900 border border-white/5 rounded-2xl overflow-hidden shadow-xl">
        <div class="max-h-[600px] overflow-y-auto custom-scrollbar p-2">
            @if($chapters->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    @foreach($chapters as $chapter)
                        <a href="{{ route('komik.read', [$comic->slug, $chapter->number]) }}" 
                           class="group flex items-center justify-between p-4 rounded-xl bg-neutral-950 border border-white/5 hover:border-purple-500/50 hover:bg-white/5 transition-all">
                            
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-lg bg-neutral-800 flex items-center justify-center text-neutral-500 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                                    <span class="font-bold text-sm">{{ $chapter->number }}</span>
                                </div>
                                <div>
                                    <h4 class="text-white font-medium text-sm group-hover:text-purple-400 transition-colors">
                                        {{ $chapter->title ? 'Ch. '.$chapter->number.' - '.$chapter->title : 'Chapter ' . $chapter->number }}
                                    </h4>
                                    <p class="text-xs text-neutral-500 mt-0.5">{{ $chapter->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                            <i data-lucide="chevron-right" class="w-5 h-5 text-neutral-600 group-hover:text-white transition-colors"></i>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="py-12 text-center">
                    <div class="w-16 h-16 bg-neutral-800 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="file-x" class="w-8 h-8 text-neutral-600"></i>
                    </div>
                    <p class="text-neutral-500">Belum ada chapter yang diupload.</p>
                </div>
            @endif
        </div>
    </div>

    <div class="mb-20"></div>

@endsection