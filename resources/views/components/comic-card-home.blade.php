@props(['comic', 'flag' => ''])

<a href="{{ route('komik.show', $comic->slug) }}" class="group cursor-pointer block h-full relative">
    <div class="relative aspect-[3/4] rounded-xl overflow-hidden bg-neutral-900 border border-white/5 shadow-lg transition-all duration-300 group-hover:shadow-purple-500/30 group-hover:-translate-y-1 group-hover:border-purple-500/50">

        <div class="absolute top-2 left-2 z-10 flex flex-col items-start gap-1">
            <span class="px-1.5 py-0.5 text-[10px] font-bold text-white rounded-md shadow-sm backdrop-blur-md border border-white/10
                {{ $comic->type == 'Manhwa' ? 'bg-purple-600/80' : 
                  ($comic->type == 'Manga' ? 'bg-red-600/80' : 'bg-blue-600/80') }}">
                {{ $comic->type }}
            </span>
            
            @if(($comic->rating ?? 0) >= 9.0)
                <span class="bg-amber-500/90 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-md shadow-sm flex items-center gap-1">
                    🔥 HOT
                </span>
            @endif
        </div>

        <img src="{{ Str::startsWith($comic->cover, 'http') ? $comic->cover : asset('storage/' . $comic->cover) }}"
             alt="{{ $comic->title }}"
             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
             loading="lazy">

        <div class="absolute inset-x-0 bottom-0 h-1/3 bg-gradient-to-t from-neutral-950/90 via-neutral-950/40 to-transparent pointer-events-none"></div>

        @if($flag)
        <div class="absolute bottom-2 right-2 z-10">
            <span class="text-xl drop-shadow-md filter">{{ $flag }}</span>
        </div>
        @endif
    </div>

    <div class="mt-3 px-1">
        <h3 class="text-gray-100 font-bold text-[15px] leading-tight line-clamp-2 group-hover:text-purple-400 transition-colors" title="{{ $comic->title }}">
            {{ $comic->title }}
        </h3>

        <div class="flex justify-between items-center mt-2 text-xs text-neutral-400">
            <span class="flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                {{-- Gunakan chapters_count jika dari backend withCount, atau fallback ke 0 --}}
                Ch. {{ $comic->chapters_count ?? 0 }}
            </span>
            <span class="flex items-center gap-1 text-yellow-500 font-bold">
                <i data-lucide="star" class="w-3 h-3 fill-yellow-500"></i> {{ $comic->rating ?? 'N/A' }}
            </span>
        </div>
    </div>
</a>