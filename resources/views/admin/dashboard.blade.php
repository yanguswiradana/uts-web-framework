@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header_title', 'Dashboard Overview')

@section('content')
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <a href="{{ route('admin.comics.index') }}" class="group bg-neutral-900 border border-white/5 p-6 rounded-2xl shadow-lg hover:border-purple-500/50 transition-all hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-purple-500/10 rounded-xl text-purple-400 group-hover:bg-purple-500 group-hover:text-white transition-colors">
                    <i data-lucide="book-open" class="w-6 h-6"></i>
                </div>
                <span class="text-xs font-bold text-neutral-500 uppercase tracking-wider group-hover:text-purple-400">Total Komik</span>
            </div>
            <h3 class="text-3xl font-bold text-white mb-1">{{ $totalComics }}</h3>
            <p class="text-xs text-neutral-500">Judul komik tersedia</p>
        </a>

        <a href="{{ route('admin.chapters.index') }}" class="group bg-neutral-900 border border-white/5 p-6 rounded-2xl shadow-lg hover:border-blue-500/50 transition-all hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-500/10 rounded-xl text-blue-400 group-hover:bg-blue-500 group-hover:text-white transition-colors">
                    <i data-lucide="file-text" class="w-6 h-6"></i>
                </div>
                <span class="text-xs font-bold text-neutral-500 uppercase tracking-wider group-hover:text-blue-400">Total Chapter</span>
            </div>
            <h3 class="text-3xl font-bold text-white mb-1">{{ $totalChapters }}</h3>
            <p class="text-xs text-neutral-500">Episode siap baca</p>
        </a>

        <a href="{{ route('admin.genres.index') }}" class="group bg-neutral-900 border border-white/5 p-6 rounded-2xl shadow-lg hover:border-emerald-500/50 transition-all hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-emerald-500/10 rounded-xl text-emerald-400 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                    <i data-lucide="tags" class="w-6 h-6"></i>
                </div>
                <span class="text-xs font-bold text-neutral-500 uppercase tracking-wider group-hover:text-emerald-400">Total Genre</span>
            </div>
            <h3 class="text-3xl font-bold text-white mb-1">{{ $totalGenres }}</h3>
            <p class="text-xs text-neutral-500">Kategori terdaftar</p>
        </a>

        <a href="{{ route('admin.users.index') }}" class="group bg-neutral-900 border border-white/5 p-6 rounded-2xl shadow-lg hover:border-pink-500/50 transition-all hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-pink-500/10 rounded-xl text-pink-400 group-hover:bg-pink-500 group-hover:text-white transition-colors">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                <span class="text-xs font-bold text-neutral-500 uppercase tracking-wider group-hover:text-pink-400">Total Member</span>
            </div>
            <h3 class="text-3xl font-bold text-white mb-1">{{ $totalUsers }}</h3>
            <p class="text-xs text-neutral-500">User aktif terdaftar</p>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 bg-neutral-900 border border-white/5 rounded-2xl p-6 shadow-xl">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <i data-lucide="clock" class="w-5 h-5 text-purple-500"></i> Komik Terbaru
                </h3>
                <a href="{{ route('admin.comics.index') }}" class="text-xs font-bold text-purple-400 hover:text-white transition-colors">Lihat Semua</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-neutral-400">
                    <thead class="bg-white/[0.02] text-neutral-500 font-medium uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 rounded-l-lg">Judul Komik</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 rounded-r-lg text-right">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($latestComics as $comic)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    @if($comic->cover)
                                        <img src="{{ Str::startsWith($comic->cover, 'http') ? $comic->cover : asset('storage/' . $comic->cover) }}" class="w-8 h-10 object-cover rounded shadow-sm">
                                    @else
                                        <div class="w-8 h-10 bg-neutral-800 rounded flex items-center justify-center text-xs font-bold text-neutral-600">?</div>
                                    @endif
                                    <div>
                                        <div class="font-bold text-white truncate max-w-[150px]">{{ $comic->title }}</div>
                                        <div class="text-[10px] text-neutral-500">{{ $comic->type }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                @if($comic->status == 'Ongoing')
                                    <span class="text-[10px] bg-green-500/10 text-green-400 px-2 py-0.5 rounded border border-green-500/20">Ongoing</span>
                                @else
                                    <span class="text-[10px] bg-blue-500/10 text-blue-400 px-2 py-0.5 rounded border border-blue-500/20">Finished</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right text-xs">
                                {{ $comic->created_at->diffForHumans() }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-neutral-500 text-xs">Belum ada data komik.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-neutral-900 border border-white/5 rounded-2xl p-6 shadow-xl">
            <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                <i data-lucide="trending-up" class="w-5 h-5 text-yellow-500"></i> Paling Aktif
            </h3>

            <div class="space-y-4">
                @forelse($topComics as $index => $comic)
                <div class="flex items-center gap-4 group">
                    <div class="w-8 h-8 rounded-full bg-neutral-800 border border-white/5 flex items-center justify-center text-sm font-bold text-neutral-500 group-hover:bg-purple-600 group-hover:text-white transition-colors shadow-inner">
                        #{{ $index + 1 }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-bold text-white truncate group-hover:text-purple-400 transition-colors">{{ $comic->title }}</h4>
                        <p class="text-xs text-neutral-500">{{ $comic->chapters_count }} Chapter Uploaded</p>
                    </div>
                    <a href="{{ route('admin.chapters.create', ['comic_id' => $comic->id]) }}" class="p-2 rounded-lg bg-neutral-800 text-neutral-400 hover:text-white hover:bg-white/10 transition-colors" title="Tambah Chapter">
                        <i data-lucide="plus" class="w-4 h-4"></i>
                    </a>
                </div>
                @empty
                <div class="text-center text-neutral-500 text-xs py-8">Belum ada data statistik.</div>
                @endforelse
            </div>
            
            <div class="mt-8 pt-6 border-t border-white/5">
                <a href="{{ route('admin.chapters.create') }}" class="block w-full bg-neutral-800 hover:bg-neutral-700 text-white text-center text-sm font-bold py-3 rounded-xl transition-colors border border-white/5">
                    Upload Chapter Baru
                </a>
            </div>
        </div>
    </div>

@endsection