@props(['comic'])

<div class="group relative flex flex-col h-full bg-neutral-900 rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-purple-900/40">
    
    <a href="{{ route('komik.show', $comic->slug) }}" class="absolute inset-0 z-30" aria-label="Baca {{ $comic->title }}"></a>

    <div class="relative aspect-[2/3] overflow-hidden w-full">
        <img src="{{ Str::startsWith($comic->cover, 'http') ? $comic->cover : asset('storage/' . $comic->cover) }}" 
             alt="{{ $comic->title }}" 
             loading="lazy"
             class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-105">
        
        <div class="absolute inset-0 bg-gradient-to-t from-neutral-900 via-transparent to-black/40 opacity-80 group-hover:opacity-60 transition-opacity z-10"></div>

        <div class="absolute top-3 left-3 z-20">
            <span class="px-2.5 py-1 text-[10px] font-bold text-white uppercase tracking-wider bg-white/10 backdrop-blur-md rounded-md shadow-lg">
                {{ $comic->type }}
            </span>
        </div>

        <div class="absolute top-3 right-3 z-20 flex items-center gap-1 px-2.5 py-1 bg-black/50 backdrop-blur-md rounded-md shadow-lg">
            <i data-lucide="star" class="w-3.5 h-3.5 text-yellow-400 fill-yellow-400"></i>
            <span class="text-xs font-bold text-white pt-0.5">
                {{ number_format($comic->ratings_avg_stars ?? 0, 1) }}
            </span>
        </div>
    </div>

    <div class="flex-1 p-5 flex flex-col bg-neutral-900 relative -mt-12 z-20 mask-gradient">
        <div class="absolute top-0 left-0 right-0 h-12 bg-gradient-to-b from-transparent to-neutral-900 -z-10 translate-y-[-100%]"></div>

        <div class="text-[10px] font-bold text-purple-400 mb-1.5 uppercase tracking-wide truncate opacity-90">
            @foreach($comic->genres->take(2) as $genre)
                {{ $genre->name }}{{ !$loop->last ? ' • ' : '' }}
            @endforeach
        </div>

        <h3 class="text-white font-bold text-lg leading-snug line-clamp-2 mb-3 group-hover:text-purple-400 transition-colors">
            {{ $comic->title }}
        </h3>

        <div class="mt-auto flex items-center justify-between pt-3 border-t border-white/5">
            <div class="flex items-center gap-1.5 text-neutral-400">
                <i data-lucide="layers" class="w-4 h-4"></i>
                <span class="text-xs font-medium">{{ $comic->chapters_count }} Ch</span>
            </div>

            <div class="flex items-center gap-1.5">
                <span class="relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75 {{ $comic->status == 'Ongoing' ? 'bg-green-400' : 'bg-blue-400' }}"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 {{ $comic->status == 'Ongoing' ? 'bg-green-500' : 'bg-blue-500' }}"></span>
                </span>
                <span class="text-[10px] font-bold text-neutral-500 uppercase">
                    {{ $comic->status == 'Ongoing' ? 'ON' : 'END' }}
                </span>
            </div>
        </div>
    </div>
</div>