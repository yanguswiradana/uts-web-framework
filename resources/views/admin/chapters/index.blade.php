@extends('layouts.admin')

@section('title', 'Data Chapter')
@section('header_title', 'Manajemen Chapter')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-white">Daftar Chapter</h2>
            <p class="text-neutral-400 text-sm">Kelola chapter berdasarkan komik.</p>
        </div>
        <a href="{{ route('admin.chapters.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium transition-colors flex items-center gap-2 shadow-lg shadow-blue-900/20">
            <i data-lucide="upload-cloud" class="w-4 h-4"></i> Upload Chapter
        </a>
    </div>

    <div class="flex flex-col md:flex-row gap-4 mb-6 justify-between items-end md:items-center">
        
        <div class="flex bg-neutral-900 p-1 rounded-xl border border-white/5 overflow-x-auto max-w-full">
            <a href="{{ route('admin.chapters.index', array_merge(request()->all(), ['type' => null, 'page' => null])) }}" 
               class="px-4 py-2 rounded-lg text-xs font-bold whitespace-nowrap transition-all {{ !request('type') ? 'bg-blue-600 text-white shadow-lg' : 'text-neutral-400 hover:text-white hover:bg-white/5' }}">
               Semua
            </a>
            <a href="{{ route('admin.chapters.index', array_merge(request()->all(), ['type' => 'Manga', 'page' => null])) }}" 
               class="px-4 py-2 rounded-lg text-xs font-bold whitespace-nowrap transition-all {{ request('type') == 'Manga' ? 'bg-blue-600 text-white shadow-lg' : 'text-neutral-400 hover:text-white hover:bg-white/5' }}">
               Manga
            </a>
            <a href="{{ route('admin.chapters.index', array_merge(request()->all(), ['type' => 'Manhwa', 'page' => null])) }}" 
               class="px-4 py-2 rounded-lg text-xs font-bold whitespace-nowrap transition-all {{ request('type') == 'Manhwa' ? 'bg-blue-600 text-white shadow-lg' : 'text-neutral-400 hover:text-white hover:bg-white/5' }}">
               Manhwa
            </a>
            <a href="{{ route('admin.chapters.index', array_merge(request()->all(), ['type' => 'Manhua', 'page' => null])) }}" 
               class="px-4 py-2 rounded-lg text-xs font-bold whitespace-nowrap transition-all {{ request('type') == 'Manhua' ? 'bg-blue-600 text-white shadow-lg' : 'text-neutral-400 hover:text-white hover:bg-white/5' }}">
               Manhua
            </a>
        </div>

        <div class="w-full md:w-72">
            <form action="{{ route('admin.chapters.index') }}" method="GET">
                @if(request('type'))
                    <input type="hidden" name="type" value="{{ request('type') }}">
                @endif
                
                <div class="relative">
                    <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-500"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul komik..." class="w-full bg-neutral-900 border border-white/5 rounded-xl py-2.5 pl-10 pr-4 text-sm text-white placeholder-neutral-500 focus:outline-none focus:border-blue-500/50 transition-colors">
                </div>
            </form>
        </div>
    </div>

    <div class="space-y-4" x-data="{ activeAccordion: null }">
        @forelse($comics as $comic)
            <div class="bg-neutral-900 border border-white/5 rounded-2xl overflow-hidden transition-all duration-300"
                 :class="activeAccordion === {{ $comic->id }} ? 'border-blue-500/30 shadow-lg shadow-blue-900/10' : 'hover:border-white/10'">
                
                <button @click="activeAccordion = activeAccordion === {{ $comic->id }} ? null : {{ $comic->id }}" 
                        class="w-full px-6 py-4 flex items-center justify-between bg-white/[0.02] hover:bg-white/[0.04] transition-colors text-left group">
                    <div class="flex items-center gap-4 overflow-hidden">
                        <div class="w-10 h-14 bg-neutral-800 rounded-md overflow-hidden shrink-0 border border-white/5 relative">
                            @if($comic->cover)
                                <img src="{{ str_starts_with($comic->cover, 'http') ? $comic->cover : asset('storage/' . $comic->cover) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-xs text-neutral-500">No img</div>
                            @endif
                            <div class="absolute bottom-0 left-0 w-full text-[8px] font-bold text-center py-0.5 
                                {{ $comic->type == 'Manga' ? 'bg-red-600 text-white' : ($comic->type == 'Manhwa' ? 'bg-green-600 text-white' : 'bg-purple-600 text-white') }}">
                                {{ strtoupper($comic->type) }}
                            </div>
                        </div>
                        
                        <div class="min-w-0">
                            <h3 class="text-white font-bold text-lg truncate pr-4 group-hover:text-blue-400 transition-colors">{{ $comic->title }}</h3>
                            <p class="text-neutral-400 text-xs mt-0.5 truncate">
                                Total: <span class="text-blue-400 font-bold">{{ $comic->chapters_count }}</span> Chapter
                                @if($comic->chapters->isNotEmpty())
                                    • Update: {{ $comic->chapters->first()->created_at->diffForHumans() }}
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="text-neutral-500 transition-transform duration-300 shrink-0" 
                         :class="activeAccordion === {{ $comic->id }} ? 'rotate-180 text-blue-400' : ''">
                        <i data-lucide="chevron-down" class="w-5 h-5"></i>
                    </div>
                </button>

                <div x-show="activeAccordion === {{ $comic->id }}" 
                     x-collapse
                     style="display: none;"
                     class="border-t border-white/5 bg-black/20">
                    
                    @if($comic->chapters->isEmpty())
                        <div class="p-6 text-center text-neutral-500 text-sm">
                            Belum ada chapter yang diupload.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm text-neutral-400">
                                <thead class="bg-white/[0.02] text-neutral-500 uppercase text-[10px] tracking-wider">
                                    <tr>
                                        <th class="px-6 py-2">No</th>
                                        <th class="px-6 py-2">Judul Chapter</th>
                                        <th class="px-6 py-2">Halaman</th>
                                        <th class="px-6 py-2">Dibuat</th>
                                        <th class="px-6 py-2 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/5">
                                    @foreach($comic->chapters as $chapter)
                                    <tr class="hover:bg-white/[0.02] transition-colors group">
                                        <td class="px-6 py-3 font-bold text-white">
                                            Ch. {{ $chapter->number }}
                                        </td>
                                        <td class="px-6 py-3">
                                            {{ $chapter->title ?? '-' }}
                                        </td>
                                        <td class="px-6 py-3">
                                            {{ $chapter->total_pages }} Gambar
                                        </td>
                                        <td class="px-6 py-3 text-xs">
                                            {{ $chapter->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-3 text-right flex justify-end gap-2 opacity-60 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('admin.chapters.edit', $chapter->id) }}" class="text-yellow-500 hover:text-yellow-400 p-1">
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </a>
                                            <form action="{{ route('admin.chapters.destroy', $chapter->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus chapter ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-400 p-1">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    
                    <div class="p-3 border-t border-white/5 bg-white/[0.01] text-center">
                        <a href="{{ route('admin.chapters.create', ['comic_id' => $comic->id]) }}" class="text-xs font-bold text-blue-400 hover:text-blue-300 hover:underline">
                            + Tambah Chapter Baru untuk {{ $comic->title }}
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-16 text-neutral-500 bg-neutral-900 border border-white/5 rounded-2xl">
                <i data-lucide="folder-open" class="w-12 h-12 mx-auto mb-4 opacity-50"></i>
                <p class="text-lg font-medium text-neutral-400">Data tidak ditemukan</p>
                <p class="text-sm">Coba ubah filter atau kata kunci pencarian.</p>
                @if(request('type') || request('search'))
                    <a href="{{ route('admin.chapters.index') }}" class="inline-block mt-4 text-blue-400 hover:underline text-sm font-bold">Reset Filter</a>
                @endif
            </div>
        @endforelse

        <div class="mt-6">
            {{ $comics->links('pagination::tailwind') }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
@endsection