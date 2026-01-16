@extends('layouts.app')

@section('title', 'Baca ' . $comic->title . ' Ch. ' . $chapterNumber)

@section('content')
<div x-data="readerApp()" 
     x-init="initReader()"
     @scroll.window="handleScroll()"
     class="bg-neutral-950 min-h-screen relative selection:bg-purple-500/30">

    <header x-show="showUI"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="-translate-y-full opacity-0"
            x-transition:enter-end="translate-y-0 opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-y-0 opacity-100"
            x-transition:leave-end="-translate-y-full opacity-0"
            class="fixed top-0 left-0 w-full z-50 bg-neutral-900/90 backdrop-blur-md border-b border-white/5 shadow-lg">
        
        <div class="max-w-4xl mx-auto px-4 h-16 flex items-center justify-between">
            <div class="flex items-center gap-4 overflow-hidden">
                <a href="{{ route('komik.show', $comic->slug) }}" class="p-2 -ml-2 hover:bg-white/10 rounded-full transition-colors text-neutral-400 hover:text-white">
                    <i data-lucide="arrow-left" class="w-6 h-6"></i>
                </a>
                <div class="min-w-0">
                    <h1 class="text-sm md:text-base font-bold text-white truncate max-w-[150px] md:max-w-xs">{{ $comic->title }}</h1>
                    <p class="text-xs text-purple-400 font-medium">Chapter {{ $chapterNumber }}</p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button @click="openChapterList()" class="p-2 hover:bg-white/10 rounded-lg text-neutral-400 hover:text-white transition-colors" title="Daftar Chapter">
                    <i data-lucide="list" class="w-5 h-5"></i>
                </button>
                
                @auth
                    <form action="{{ route('komik.bookmark', $comic->slug) }}" method="POST" class="hidden md:block">
                        @csrf
                        <button type="submit" class="p-2 hover:bg-white/10 rounded-lg transition-colors {{ Auth::user()->hasBookmarked($comic->id) ? 'text-purple-500' : 'text-neutral-400 hover:text-white' }}" 
                                title="{{ Auth::user()->hasBookmarked($comic->id) ? 'Hapus dari Library' : 'Simpan ke Library' }}">
                            <i data-lucide="bookmark" class="w-5 h-5 {{ Auth::user()->hasBookmarked($comic->id) ? 'fill-current' : '' }}"></i>
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </header>

    <div @click="toggleUI" class="min-h-screen cursor-pointer pt-0 md:pt-16 pb-20">
        
        <div class="max-w-3xl mx-auto bg-black shadow-2xl min-h-[50vh]">
            @foreach($chapterImages as $image)
                <img src="{{ $image }}" class="w-full h-auto block select-none" loading="lazy">
            @endforeach
        </div>

        <div class="max-w-3xl mx-auto px-6 py-12 flex flex-col gap-6">
            <h3 class="text-center text-white font-bold text-lg opacity-50">Chapter Selesai</h3>
            <div class="flex gap-3">
                @if($prevChapter)
                    <a href="{{ route('komik.read', [$comic->slug, $prevChapter]) }}" class="flex-1 bg-neutral-800 hover:bg-neutral-700 text-white py-3.5 rounded-xl font-bold text-center border border-white/5 transition-colors">
                        Prev Chapter
                    </a>
                @endif
                @if($nextChapter)
                    <a href="{{ route('komik.read', [$comic->slug, $nextChapter]) }}" class="flex-1 bg-purple-600 hover:bg-purple-500 text-white py-3.5 rounded-xl font-bold text-center shadow-lg shadow-purple-900/40 transition-colors">
                        Next Chapter
                    </a>
                @else
                    <a href="{{ route('komik.show', $comic->slug) }}" class="flex-1 bg-neutral-800 hover:bg-neutral-700 text-white py-3.5 rounded-xl font-bold text-center border border-white/5">
                        Selesai
                    </a>
                @endif
            </div>
        </div>

        <div class="max-w-3xl mx-auto px-4 pb-32 cursor-auto" @click.stop>
            <div class="border-t border-white/10 pt-10">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                    <i data-lucide="message-square" class="w-5 h-5 text-purple-500"></i>
                    Komentar <span class="text-neutral-500 text-sm font-normal">({{ $comments->count() }})</span>
                </h3>

                @auth
                    <form action="{{ route('chapter.comment', $chapter->id) }}" method="POST" class="mb-10">
                        @csrf
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-full bg-purple-600 flex-shrink-0 flex items-center justify-center font-bold text-white">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <textarea name="body" rows="2" placeholder="Tulis komentar..." class="w-full bg-neutral-900 border border-white/10 rounded-xl p-4 text-white focus:outline-none focus:border-purple-500 transition-colors resize-none text-sm" required></textarea>
                                <div class="flex justify-end mt-2">
                                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2 rounded-lg font-bold text-xs transition-all">Kirim</button>
                                </div>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="bg-neutral-900/50 rounded-xl p-4 text-center border border-white/5 mb-8">
                        <p class="text-neutral-400 text-sm">Login untuk berkomentar.</p>
                        <a href="{{ route('login') }}" class="text-purple-400 font-bold text-sm hover:underline">Login disini</a>
                    </div>
                @endauth

                <div class="space-y-8">
                    @forelse($comments as $comment)
                        
                        <div x-data="{ openReply: false }">
                            
                            <div class="flex gap-3 group">
                                <div class="w-10 h-10 rounded-full bg-neutral-800 flex-shrink-0 flex items-center justify-center font-bold text-neutral-400 text-sm border border-white/5">
                                    {{ substr($comment->user->name, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="font-bold text-white text-sm">{{ $comment->user->name }}</span>
                                        <span class="text-[10px] text-neutral-500">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-neutral-300 text-sm leading-relaxed mb-2">{{ $comment->body }}</p>
                                    
                                    @auth
                                        <button @click="openReply = !openReply" class="text-xs text-purple-400 font-bold hover:text-purple-300 transition-colors flex items-center gap-1 opacity-60 hover:opacity-100">
                                            <i data-lucide="reply" class="w-3 h-3"></i> Balas
                                        </button>
                                    @endauth
                                </div>
                            </div>

                            @auth
                                <div x-show="openReply" class="ml-12 mt-3" style="display: none;" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 -translate-y-2"
                                     x-transition:enter-end="opacity-100 translate-y-0">
                                    
                                    <form action="{{ route('chapter.comment', $chapter->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                        <div class="flex gap-3">
                                            <div class="w-8 h-8 rounded-full bg-purple-600/50 flex-shrink-0 flex items-center justify-center font-bold text-white text-xs">
                                                {{ substr(Auth::user()->name, 0, 1) }}
                                            </div>
                                            <div class="flex-1">
                                                <textarea name="body" rows="1" placeholder="Balas komentar {{ $comment->user->name }}..." class="w-full bg-neutral-900 border border-white/10 rounded-lg p-3 text-white text-xs focus:outline-none focus:border-purple-500 transition-colors resize-none" required></textarea>
                                                <div class="flex justify-end gap-2 mt-2">
                                                    <button type="button" @click="openReply = false" class="text-neutral-500 text-xs hover:text-white">Batal</button>
                                                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-1.5 rounded-md font-bold text-xs transition-all">Kirim</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endauth

                            @if($comment->replies->count() > 0)
                                <div class="ml-12 mt-4 space-y-4 border-l-2 border-white/5 pl-4">
                                    @foreach($comment->replies as $reply)
                                        <div class="flex gap-3">
                                            <div class="w-8 h-8 rounded-full bg-neutral-800 flex-shrink-0 flex items-center justify-center font-bold text-neutral-500 text-xs border border-white/5">
                                                {{ substr($reply->user->name, 0, 1) }}
                                            </div>
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <span class="font-bold text-white text-xs">{{ $reply->user->name }}</span>
                                                    <span class="text-[10px] text-neutral-600">{{ $reply->created_at->diffForHumans() }}</span>
                                                </div>
                                                <p class="text-neutral-400 text-xs leading-relaxed">
                                                    <span class="text-purple-500/50 mr-1 font-bold">@</span>{{ $reply->body }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                        </div>
                    @empty
                        <p class="text-center text-neutral-600 text-sm italic py-4">Belum ada komentar.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div x-show="showUI"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-full opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-y-0 opacity-100"
         x-transition:leave-end="translate-y-full opacity-0"
         class="fixed bottom-6 left-0 w-full z-40 px-4 pointer-events-none">
        
        <div class="max-w-md mx-auto bg-neutral-900/90 backdrop-blur-xl border border-white/10 rounded-2xl p-2 shadow-2xl pointer-events-auto flex items-center justify-between gap-2">
            
            @if($prevChapter)
                <a href="{{ route('komik.read', [$comic->slug, $prevChapter]) }}" class="p-3 rounded-xl text-neutral-400 hover:text-white hover:bg-white/10 transition-colors">
                    <i data-lucide="chevron-left" class="w-6 h-6"></i>
                </a>
            @else
                <button disabled class="p-3 rounded-xl text-neutral-700 cursor-not-allowed">
                    <i data-lucide="chevron-left" class="w-6 h-6"></i>
                </button>
            @endif

            <div class="flex items-center gap-2 bg-black/50 rounded-xl px-2 py-1">
                <button @click="toggleAutoScroll()" 
                        :class="isAutoScrolling ? 'text-purple-400 bg-purple-500/10' : 'text-neutral-400 hover:text-white'"
                        class="p-2 rounded-lg transition-colors relative group">
                    <i :data-lucide="isAutoScrolling ? 'pause' : 'play'" class="w-5 h-5 fill-current"></i>
                </button>
                
                <div x-show="isAutoScrolling" class="flex items-center gap-1">
                    <button @click="decreaseSpeed()" class="text-neutral-500 hover:text-white text-xs px-1 font-bold">-</button>
                    <span class="text-xs font-mono text-purple-400 w-8 text-center" x-text="scrollSpeed + 'x'"></span>
                    <button @click="increaseSpeed()" class="text-neutral-500 hover:text-white text-xs px-1 font-bold">+</button>
                </div>
            </div>

            @if($nextChapter)
                <a href="{{ route('komik.read', [$comic->slug, $nextChapter]) }}" class="p-3 rounded-xl text-white bg-purple-600 hover:bg-purple-500 shadow-lg shadow-purple-900/20 transition-colors">
                    <i data-lucide="chevron-right" class="w-6 h-6"></i>
                </a>
            @else
                <a href="{{ route('komik.show', $comic->slug) }}" class="p-3 rounded-xl text-neutral-400 hover:text-white hover:bg-white/10 transition-colors">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </a>
            @endif

        </div>
    </div>

    <div x-show="showChapterList" 
         class="fixed inset-0 z-[60] flex items-end md:items-center justify-center sm:px-4 sm:py-6"
         style="display: none;">
        
        <div x-show="showChapterList"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="showChapterList = false"
             class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity"></div>

        <div x-show="showChapterList"
             x-transition:enter="transform transition ease-in-out duration-300"
             x-transition:enter-start="translate-y-full md:scale-95 md:opacity-0"
             x-transition:enter-end="translate-y-0 md:scale-100 md:opacity-100"
             x-transition:leave="transform transition ease-in-out duration-200"
             x-transition:leave-start="translate-y-0 md:scale-100 md:opacity-100"
             x-transition:leave-end="translate-y-full md:scale-95 md:opacity-0"
             class="relative w-full max-w-md bg-neutral-900 border-t md:border border-white/10 rounded-t-3xl md:rounded-2xl shadow-2xl max-h-[80vh] flex flex-col">
            
            <div class="flex items-center justify-between p-4 border-b border-white/5">
                <h3 class="text-lg font-bold text-white">Daftar Chapter</h3>
                <button @click="showChapterList = false" class="text-neutral-500 hover:text-white">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <div class="p-4 overflow-y-auto custom-scrollbar flex-1">
                <div class="grid grid-cols-1 gap-2">
                    @foreach($chapters as $ch)
                        <a href="{{ route('komik.read', [$comic->slug, $ch->number]) }}" 
                           class="flex items-center justify-between p-3 rounded-xl border border-white/5 hover:border-purple-500/50 hover:bg-white/5 transition-all {{ $ch->number == $chapterNumber ? 'bg-purple-600/10 border-purple-500/50' : 'bg-neutral-950' }}">
                            <span class="text-sm font-medium {{ $ch->number == $chapterNumber ? 'text-purple-400' : 'text-neutral-300' }}">
                                Chapter {{ $ch->number }}
                            </span>
                            <span class="text-xs text-neutral-600">{{ $ch->created_at->format('d M') }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    function readerApp() {
        return {
            showUI: true,
            lastScrollTop: 0,
            isAutoScrolling: false,
            scrollSpeed: 1, // 1x Speed
            scrollInterval: null,
            showChapterList: false,

            initReader() {
                this.$nextTick(() => {
                    lucide.createIcons();
                });
            },

            handleScroll() {
                let st = window.pageYOffset || document.documentElement.scrollTop;
                if (this.isAutoScrolling) return;

                if (st > this.lastScrollTop && st > 100) {
                    this.showUI = false;
                } else {
                    this.showUI = true;
                }
                this.lastScrollTop = st <= 0 ? 0 : st;
            },

            toggleUI() {
                this.showUI = !this.showUI;
                if(this.isAutoScrolling) this.toggleAutoScroll();
            },

            toggleAutoScroll() {
                this.isAutoScrolling = !this.isAutoScrolling;
                if (this.isAutoScrolling) {
                    this.showUI = false;
                    this.startScroll();
                } else {
                    this.showUI = true;
                    this.stopScroll();
                }
                this.$nextTick(() => lucide.createIcons());
            },

            startScroll() {
                this.stopScroll();
                let speedMs = 30 / this.scrollSpeed; 
                this.scrollInterval = setInterval(() => {
                    window.scrollBy(0, 1);
                    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
                        this.toggleAutoScroll();
                        this.showUI = true;
                    }
                }, speedMs);
            },

            stopScroll() {
                if (this.scrollInterval) clearInterval(this.scrollInterval);
            },

            increaseSpeed() {
                if (this.scrollSpeed < 5) {
                    this.scrollSpeed += 0.5;
                    this.startScroll();
                }
            },

            decreaseSpeed() {
                if (this.scrollSpeed > 0.5) {
                    this.scrollSpeed -= 0.5;
                    this.startScroll();
                }
            },

            openChapterList() {
                this.showChapterList = true;
                this.showUI = false;
                this.stopScroll();
            }
        }
    }
</script>
@endsection