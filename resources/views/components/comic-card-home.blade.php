@props(['comic', 'flag'])

<a href="{{ route('komik.show', $comic['slug']) }}" class="group cursor-pointer">
    <div class="relative aspect-[3/4] rounded-xl overflow-hidden shadow-lg transition-all duration-300 group-hover:shadow-purple-500/30 group-hover:-translate-y-1">

        <div class="absolute top-2 left-2 z-10 flex flex-col items-start gap-1">
            <span class="bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded shadow-sm">UP</span>
            @if($comic['rating'] >= 9.5)
                <span class="bg-amber-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded shadow-sm">🔥 HOT</span>
            @endif
        </div>

        <img src="{{ Str::startsWith($comic['cover'], 'http') ? $comic['cover'] : asset($comic['cover']) }}"
             alt="{{ $comic['title'] }}"
             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">

        <div class="absolute inset-x-0 bottom-0 h-1/4 bg-gradient-to-t from-black/60 to-transparent"></div>

        <div class="absolute bottom-2 right-2 z-10">
            <span class="text-xl drop-shadow-md">{{ $flag }}</span>
        </div>
    </div>

    <div class="mt-3">
        <h3 class="text-gray-100 font-bold text-[15px] leading-tight line-clamp-2 group-hover:text-purple-400 transition-colors">
            {{ $comic['title'] }}
        </h3>

        <div class="flex justify-between items-center mt-2 text-xs text-gray-400">
            <span class="flex items-center gap-1">
                <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                Ch. {{ $comic['chapters'] }}
            </span>
            <span class="flex items-center gap-1 text-yellow-500/90">
                ★ {{ $comic['rating'] }}
            </span>
        </div>
    </div>
</a>
