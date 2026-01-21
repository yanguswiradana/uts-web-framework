@extends('layouts.read')

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
            class="fixed top-0 left-0 w-full z-50 bg-gradient-to-b from-black/90 to-transparent pt-4 pb-8 px-4 pointer-events-none">
        
        <div class="max-w-4xl mx-auto flex items-start justify-between pointer-events-auto">
            <div class="bg-black/40 backdrop-blur-md border border-white/5 rounded-full px-4 py-2 flex items-center gap-3 shadow-lg">
                <a href="{{ route('komik.show', $comic->slug) }}" class="text-neutral-400 hover:text-white transition-colors">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <div class="w-px h-4 bg-white/10"></div>
                <div>
                    <h1 class="text-xs font-bold text-white max-w-[120px] sm:max-w-xs truncate">{{ $comic->title }}</h1>
                    <p class="text-[10px] text-purple-400 font-medium">Chapter {{ $chapterNumber }}</p>
                </div>
            </div>

            @auth
                <form action="{{ route('komik.bookmark', $comic->slug) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-black/40 backdrop-blur-md border border-white/5 rounded-full w-10 h-10 flex items-center justify-center transition-colors {{ Auth::user()->hasBookmarked($comic->id) ? 'text-purple-500' : 'text-neutral-400 hover:text-white' }}">
                        <i data-lucide="bookmark" class="w-5 h-5 {{ Auth::user()->hasBookmarked($comic->id) ? 'fill-current' : '' }}"></i>
                    </button>
                </form>
            @endauth
        </div>
    </header>

    <div @click="toggleUI" class="min-h-screen cursor-pointer pb-32">
        <div class="max-w-3xl mx-auto bg-black shadow-2xl min-h-[50vh]">
            @foreach($chapterImages as $image)
                <img src="{{ $image }}" class="w-full h-auto block select-none" loading="lazy">
            @endforeach
        </div>

        <div class="max-w-3xl mx-auto px-6 py-12 flex flex-col gap-6">
            <h3 class="text-center text-white font-bold text-lg opacity-50">Chapter Selesai</h3>
            <div class="flex gap-3">
                @if($prevChapter)
                    <a href="{{ route('komik.read', [$comic->slug, $prevChapter]) }}" class="flex-1 bg-neutral-800 hover:bg-neutral-700 text-white py-3.5 rounded-xl font-bold text-center border border-white/5 transition-colors">Prev Chapter</a>
                @endif
                @if($nextChapter)
                    <a href="{{ route('komik.read', [$comic->slug, $nextChapter]) }}" class="flex-1 bg-purple-600 hover:bg-purple-500 text-white py-3.5 rounded-xl font-bold text-center shadow-lg shadow-purple-900/40 transition-colors">Next Chapter</a>
                @else
                    <a href="{{ route('komik.show', $comic->slug) }}" class="flex-1 bg-neutral-800 hover:bg-neutral-700 text-white py-3.5 rounded-xl font-bold text-center border border-white/5">Selesai</a>
                @endif
            </div>
        </div>

        <div class="max-w-3xl mx-auto px-4 cursor-auto" @click.stop x-data="commentSystem()">
            <div class="border-t border-white/10 pt-10">
                <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-2">
                    <i data-lucide="message-square" class="w-5 h-5 text-purple-500"></i>
                    Komentar <span class="text-neutral-500 text-sm font-normal" x-text="'(' + totalComments + ')'"></span>
                </h3>

                @auth
                    <form @submit.prevent="submitComment($el)" action="{{ route('chapter.comment', $chapter->id) }}" class="mb-10">
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-full bg-purple-600 flex-shrink-0 flex items-center justify-center font-bold text-white">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <textarea name="body" rows="2" placeholder="Tulis komentar..." class="w-full bg-neutral-900 border border-white/10 rounded-xl p-4 text-white focus:outline-none focus:border-purple-500 transition-colors resize-none text-sm" required></textarea>
                                <div class="flex justify-end mt-2 items-center gap-2">
                                    <span x-show="isLoading" class="text-xs text-neutral-500">Mengirim...</span>
                                    <button type="submit" :disabled="isLoading" class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2 rounded-lg font-bold text-xs transition-all disabled:opacity-50">Kirim</button>
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

                <div id="comment-list" class="space-y-8">
                    @forelse($comments as $comment)
                        <div class="comment-item" id="comment-{{ $comment->id }}" x-data="{ openReply: false }">
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
                                    <form @submit.prevent="submitReply($el, {{ $comment->id }})" action="{{ route('chapter.comment', $chapter->id) }}">
                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                        <div class="flex gap-3">
                                            <div class="w-8 h-8 rounded-full bg-purple-600/50 flex-shrink-0 flex items-center justify-center font-bold text-white text-xs">
                                                {{ substr(Auth::user()->name, 0, 1) }}
                                            </div>
                                            <div class="flex-1">
                                                <textarea name="body" rows="1" placeholder="Balas {{ $comment->user->name }}..." class="w-full bg-neutral-900 border border-white/10 rounded-lg p-3 text-white text-xs focus:outline-none focus:border-purple-500 transition-colors resize-none" required></textarea>
                                                <div class="flex justify-end gap-2 mt-2">
                                                    <button type="button" @click="openReply = false" class="text-neutral-500 text-xs hover:text-white">Batal</button>
                                                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-1.5 rounded-md font-bold text-xs transition-all">Kirim</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endauth

                            <div id="replies-{{ $comment->id }}" class="ml-12 mt-4 space-y-4 border-l-2 border-white/5 pl-4">
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
                                            <p class="text-neutral-400 text-xs leading-relaxed">{{ $reply->body }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <p id="no-comment-msg" class="text-center text-neutral-600 text-sm italic py-4">Belum ada komentar.</p>
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
         class="fixed bottom-6 w-full z-40 px-4 pointer-events-none flex justify-center items-end gap-3">
        
        <a href="{{ route('komik.show', $comic->slug) }}" 
           class="pointer-events-auto bg-black/80 backdrop-blur-md border border-white/10 w-12 h-12 rounded-full flex items-center justify-center text-neutral-400 hover:text-white hover:bg-purple-600 transition-all shadow-xl group"
           title="Kembali ke Detail Komik">
            <i data-lucide="layout-grid" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
        </a>

        <div class="pointer-events-auto bg-black/80 backdrop-blur-md border border-white/10 rounded-full h-12 px-2 flex items-center gap-1 shadow-xl">
            
            <a href="{{ $prevChapter ? route('komik.read', [$comic->slug, $prevChapter]) : '#' }}" 
               class="w-10 h-10 rounded-full flex items-center justify-center transition-colors {{ $prevChapter ? 'text-neutral-300 hover:bg-white/10 hover:text-white' : 'text-neutral-700 cursor-not-allowed' }}">
                <i data-lucide="chevron-left" class="w-6 h-6"></i>
            </a>

            <div class="w-px h-6 bg-white/10 mx-1"></div>

            <button @click="openChapterList()" class="w-10 h-10 rounded-full flex items-center justify-center text-neutral-300 hover:bg-white/10 hover:text-white transition-colors" title="Daftar Chapter">
                <i data-lucide="list" class="w-5 h-5"></i>
            </button>
            
            <button @click="toggleAutoScroll()" :class="isAutoScrolling ? 'text-purple-400 bg-purple-500/20' : 'text-neutral-300 hover:bg-white/10'" class="w-10 h-10 rounded-full flex items-center justify-center transition-colors" title="Auto Scroll">
                <i :data-lucide="isAutoScrolling ? 'pause' : 'play'" class="w-5 h-5 fill-current"></i>
            </button>

            <div class="w-px h-6 bg-white/10 mx-1"></div>

            <a href="{{ $nextChapter ? route('komik.read', [$comic->slug, $nextChapter]) : '#' }}" 
               class="w-10 h-10 rounded-full flex items-center justify-center transition-colors {{ $nextChapter ? 'text-white bg-purple-600 hover:bg-purple-500 shadow-lg shadow-purple-900/20' : 'text-neutral-700 cursor-not-allowed' }}">
                <i data-lucide="chevron-right" class="w-6 h-6"></i>
            </a>

        </div>
    </div>

    <div x-show="showChapterList" class="fixed inset-0 z-[60] flex items-end md:items-center justify-center sm:px-4 sm:py-6" style="display: none;">
        <div x-show="showChapterList" @click="showChapterList = false" class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity"></div>
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
                <button @click="showChapterList = false" class="text-neutral-500 hover:text-white"><i data-lucide="x" class="w-6 h-6"></i></button>
            </div>
            <div class="p-4 overflow-y-auto custom-scrollbar flex-1">
                <div class="grid grid-cols-1 gap-2">
                    @foreach($chapters as $ch)
                        <a href="{{ route('komik.read', [$comic->slug, $ch->number]) }}" class="flex items-center justify-between p-3 rounded-xl border border-white/5 hover:border-purple-500/50 hover:bg-white/5 transition-all {{ $ch->number == $chapterNumber ? 'bg-purple-600/10 border-purple-500/50' : 'bg-neutral-950' }}">
                            <span class="text-sm font-medium {{ $ch->number == $chapterNumber ? 'text-purple-400' : 'text-neutral-300' }}">Chapter {{ $ch->number }}</span>
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
            showUI: true, lastScrollTop: 0, isAutoScrolling: false, scrollSpeed: 1, scrollInterval: null, showChapterList: false,
            initReader() { this.$nextTick(() => { lucide.createIcons(); }); },
            handleScroll() {
                let st = window.pageYOffset || document.documentElement.scrollTop;
                if (this.isAutoScrolling) return;
                if (st > this.lastScrollTop && st > 100) { this.showUI = false; } else { this.showUI = true; }
                this.lastScrollTop = st <= 0 ? 0 : st;
            },
            toggleUI() { this.showUI = !this.showUI; if(this.isAutoScrolling) this.toggleAutoScroll(); },
            toggleAutoScroll() {
                this.isAutoScrolling = !this.isAutoScrolling;
                if (this.isAutoScrolling) { this.showUI = false; this.startScroll(); } 
                else { this.showUI = true; this.stopScroll(); }
                this.$nextTick(() => lucide.createIcons());
            },
            startScroll() {
                this.stopScroll();
                let speedMs = 30 / this.scrollSpeed; 
                this.scrollInterval = setInterval(() => {
                    window.scrollBy(0, 1);
                    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) { this.toggleAutoScroll(); this.showUI = true; }
                }, speedMs);
            },
            stopScroll() { if (this.scrollInterval) clearInterval(this.scrollInterval); },
            increaseSpeed() { if (this.scrollSpeed < 5) { this.scrollSpeed += 0.5; this.startScroll(); } },
            decreaseSpeed() { if (this.scrollSpeed > 0.5) { this.scrollSpeed -= 0.5; this.startScroll(); } },
            openChapterList() { this.showChapterList = true; this.showUI = false; this.stopScroll(); }
        }
    }

    function commentSystem() {
        return {
            totalComments: {{ $comments->count() + $comments->pluck('replies')->flatten()->count() }},
            isLoading: false,
            async submitComment(form) {
                this.isLoading = true;
                await this.sendData(form, null);
                this.isLoading = false;
            },
            async submitReply(form, parentId) {
                await this.sendData(form, parentId);
            },
            async sendData(form, parentId) {
                const formData = new FormData(form);
                const url = form.action;
                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: { 
                            'X-Requested-With': 'XMLHttpRequest', 
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json' // <--- INI KUNCI PERBAIKANNYA
                        },
                        body: formData
                    });

                    // Cek jika response bukan JSON (misal error server HTML)
                    if (!response.ok) {
                        throw new Error('Server returned ' + response.status);
                    }

                    const data = await response.json();
                    
                    if (data.status === 'success') {
                        form.querySelector('textarea').value = '';
                        this.totalComments++;
                        const html = this.createCommentHTML(data.comment, data.user_initial, data.time_ago, parentId);
                        
                        if (parentId) {
                            const container = document.getElementById(`replies-${parentId}`);
                            // Tutup form reply dengan mencari parent x-show
                            const wrapper = form.closest('[x-show]');
                            if(wrapper) wrapper.style.display = 'none';
                            
                            // Reset state alpine di parent jika perlu (opsional)
                            // container.innerHTML += html; // Cara kasar
                            container.insertAdjacentHTML('beforeend', html);
                        } else {
                            const list = document.getElementById('comment-list');
                            const noMsg = document.getElementById('no-comment-msg');
                            if(noMsg) noMsg.remove();
                            list.insertAdjacentHTML('afterbegin', this.createParentHTML(data.comment, data.user_initial, data.time_ago));
                        }
                        
                        // Re-init icons untuk elemen baru
                        this.$nextTick(() => lucide.createIcons());
                    }
                } catch (error) { 
                    console.error('Error Details:', error); 
                    // Jangan alert jika sukses tapi parsing error kecil, tapi di sini kita alert untuk debug
                    // alert('Gagal mengirim komentar. Cek console.'); 
                }
            },
            createCommentHTML(comment, initial, time, isReply) {
                return `<div class="flex gap-3 animate-pulse-once mt-3"><div class="w-8 h-8 rounded-full bg-neutral-800 flex-shrink-0 flex items-center justify-center font-bold text-neutral-500 text-xs border border-white/5">${initial}</div><div class="flex-1"><div class="flex items-center gap-2 mb-1"><span class="font-bold text-white text-xs">${comment.user.name}</span><span class="text-[10px] text-neutral-600">${time}</span></div><p class="text-neutral-400 text-xs leading-relaxed">${comment.body}</p></div></div>`;
            },
            createParentHTML(comment, initial, time) {
                // Catatan: Tombol balas di elemen baru mungkin belum interaktif sampai refresh, 
                // karena Alpine perlu re-init. Untuk sekarang ini cukup visual saja.
                return `<div class="comment-item animate-pulse-once" id="comment-${comment.id}"><div class="flex gap-3 group"><div class="w-10 h-10 rounded-full bg-neutral-800 flex-shrink-0 flex items-center justify-center font-bold text-neutral-400 text-sm border border-white/5">${initial}</div><div class="flex-1"><div class="flex items-center gap-2 mb-1"><span class="font-bold text-white text-sm">${comment.user.name}</span><span class="text-[10px] text-neutral-500">${time}</span></div><p class="text-neutral-300 text-sm leading-relaxed mb-2">${comment.body}</p><span class="text-[10px] text-neutral-600 italic">(Refresh untuk membalas)</span></div></div><div id="replies-${comment.id}" class="ml-12 mt-4 space-y-4 border-l-2 border-white/5 pl-4"></div></div>`;
            }
        }
    }
</script>

<style>
    @keyframes highlight { 0% { background-color: rgba(147, 51, 234, 0.2); } 100% { background-color: transparent; } }
    .animate-pulse-once { animation: highlight 1s ease-out; }
</style>
@endsection