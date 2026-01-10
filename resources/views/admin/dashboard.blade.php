@extends('layouts.admin')

@section('title', 'Dashboard - Komikin')
@section('header_title', 'Dashboard Overview')

@section('content')
    <div class="mb-8 flex flex-col md:flex-row justify-between items-end gap-4">
        <div>
            <h2 class="text-2xl md:text-3xl font-bold tracking-tight text-white">
                Dashboard <span class="text-purple-500">Komikin</span>
            </h2>
            <p class="text-neutral-400 mt-1">Halo Admin, berikut perkembangan website hari ini.</p>
        </div>
        <div class="hidden md:block text-right bg-neutral-900 border border-white/5 px-4 py-2 rounded-xl">
            <p class="text-sm font-medium text-white">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
            <div class="flex items-center justify-end gap-2 mt-1">
                <span class="relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                </span>
                <p class="text-xs text-neutral-500">Server Online</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-neutral-900/60 backdrop-blur border border-white/5 p-5 rounded-2xl relative overflow-hidden group hover:border-purple-500/30 transition-all">
            <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                <i data-lucide="book" class="w-20 h-20 transform rotate-12 translate-x-4 -translate-y-4"></i>
            </div>
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div class="p-2.5 bg-purple-500/10 rounded-lg text-purple-400 border border-purple-500/10 group-hover:bg-purple-500 group-hover:text-white transition-all">
                    <i data-lucide="book-open" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="relative z-10">
                <div class="text-3xl font-bold text-white tracking-tight">{{ $stats['total_comics'] }}</div>
                <div class="text-sm text-neutral-500 mt-1">Judul Komik</div>
            </div>
        </div>

        <div class="bg-neutral-900/60 backdrop-blur border border-white/5 p-5 rounded-2xl relative overflow-hidden group hover:border-blue-500/30 transition-all">
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div class="p-2.5 bg-blue-500/10 rounded-lg text-blue-400 border border-blue-500/10 group-hover:bg-blue-500 group-hover:text-white transition-all">
                    <i data-lucide="file-stack" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="relative z-10">
                <div class="text-3xl font-bold text-white tracking-tight">{{ number_format($stats['total_chapters']) }}</div>
                <div class="text-sm text-neutral-500 mt-1">Total Chapter</div>
            </div>
        </div>

        <div class="bg-neutral-900/60 backdrop-blur border border-white/5 p-5 rounded-2xl relative overflow-hidden group hover:border-pink-500/30 transition-all">
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div class="p-2.5 bg-pink-500/10 rounded-lg text-pink-400 border border-pink-500/10 group-hover:bg-pink-500 group-hover:text-white transition-all">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="relative z-10">
                <div class="text-3xl font-bold text-white tracking-tight">{{ number_format($stats['total_users']) }}</div>
                <div class="text-sm text-neutral-500 mt-1">User Terdaftar</div>
            </div>
        </div>

        <div class="bg-neutral-900/60 backdrop-blur border border-white/5 p-5 rounded-2xl relative overflow-hidden group hover:border-orange-500/30 transition-all">
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div class="p-2.5 bg-orange-500/10 rounded-lg text-orange-400 border border-orange-500/10 group-hover:bg-orange-500 group-hover:text-white transition-all">
                    <i data-lucide="eye" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="relative z-10">
                <div class="text-3xl font-bold text-white tracking-tight">{{ $stats['total_views'] }}</div>
                <div class="text-sm text-neutral-500 mt-1">Total Pembaca</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        
        <div class="xl:col-span-2 flex flex-col gap-6">
            <div class="bg-neutral-900 border border-white/5 rounded-2xl overflow-hidden shadow-xl">
                <div class="p-6 border-b border-white/5 flex justify-between items-center bg-neutral-900/50">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <i data-lucide="zap" class="w-5 h-5 text-yellow-500 fill-yellow-500"></i> Update Terakhir
                    </h3>
                    <a href="{{ route('admin.chapters.index') }}" class="text-xs text-neutral-400 hover:text-white border border-white/10 px-3 py-1.5 rounded-lg transition-colors">
                        Lihat Semua
                    </a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-neutral-400">
                        <thead class="bg-white/[0.02] text-neutral-300 font-medium uppercase text-xs tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Info Komik</th>
                                <th class="px-6 py-4">Tipe</th>
                                <th class="px-6 py-4">Waktu</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($recentUpdates as $chapter)
                            <tr class="hover:bg-white/[0.02] transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-9 h-12 bg-neutral-800 rounded shadow-inner overflow-hidden relative shrink-0">
                                            <img src="{{ $chapter->comic->cover ?? 'https://via.placeholder.com/150x200?text=No+Img' }}" 
                                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                                 alt="{{ $chapter->comic->title }}">
                                        </div>
                                        <div>
                                            <div class="font-bold text-white line-clamp-1 group-hover:text-purple-400 transition-colors">
                                                {{ $chapter->comic->title }}
                                            </div>
                                            <div class="text-xs text-purple-400 mt-0.5 font-medium">
                                                {{ $chapter->title }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $typeClass = match($chapter->comic->type) {
                                            'Manhwa' => 'text-purple-400 border-purple-500/20 bg-purple-500/5',
                                            'Manga' => 'text-blue-400 border-blue-500/20 bg-blue-500/5',
                                            'Manhua' => 'text-pink-400 border-pink-500/20 bg-pink-500/5',
                                            default => 'text-gray-400'
                                        };
                                    @endphp
                                    <span class="px-2 py-0.5 text-[10px] uppercase font-bold border rounded {{ $typeClass }}">
                                        {{ $chapter->comic->type }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-xs font-mono">
                                    {{ $chapter->created_at->diffForHumans(null, true) }} ago
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColor = match($chapter->comic->status) {
                                            'Ongoing' => 'bg-green-500',
                                            'Hiatus' => 'bg-yellow-500',
                                            'Finished' => 'bg-blue-500',
                                            default => 'bg-gray-500'
                                        };
                                    @endphp
                                    <div class="flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $statusColor }} shadow-[0_0_8px_rgba(0,0,0,0.5)]"></span>
                                        <span class="text-xs">{{ $chapter->comic->status }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button class="p-2 text-neutral-500 hover:text-white hover:bg-white/10 rounded-lg transition-all" title="Edit Chapter">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-neutral-500">
                                    <div class="flex flex-col items-center justify-center opacity-50">
                                        <i data-lucide="inbox" class="w-8 h-8 mb-2"></i>
                                        <p>Belum ada chapter terbaru.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-6">
            
            <div class="bg-gradient-to-b from-neutral-800 to-neutral-900 border border-white/10 rounded-2xl p-6 relative overflow-hidden group shadow-lg">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-purple-600/30 rounded-full blur-3xl group-hover:bg-purple-600/40 transition-all"></div>
                
                <h3 class="text-lg font-bold text-white mb-1 relative z-10">Aksi Cepat</h3>
                <p class="text-sm text-neutral-400 mb-6 relative z-10">Kelola konten Komikin dengan cepat.</p>
                
                <div class="space-y-3 relative z-10">
                    <a href="#" class="block w-full text-center bg-white hover:bg-neutral-200 text-black font-bold py-3 px-4 rounded-xl transition-colors shadow-lg flex items-center justify-center gap-2">
                        <i data-lucide="plus-square" class="w-4 h-4"></i> 
                        Upload Chapter
                    </a>
                    <a href="{{ route('admin.comics.index') }}" class="block w-full text-center bg-neutral-800 hover:bg-neutral-700 text-white border border-white/10 font-medium py-3 px-4 rounded-xl transition-colors flex items-center justify-center gap-2">
                        <i data-lucide="book-plus" class="w-4 h-4"></i> 
                        Tambah Komik
                    </a>
                </div>
            </div>

            <div class="bg-neutral-900 border border-white/5 rounded-2xl p-0 overflow-hidden flex-1 shadow-lg">
                <div class="p-5 border-b border-white/5 bg-neutral-800/30">
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2">
                        <i data-lucide="activity" class="w-4 h-4 text-red-500"></i> Laporan Masalah
                    </h3>
                </div>
                
                <div class="p-5 space-y-5">
                    <div class="flex gap-3">
                        <div class="mt-1">
                            <div class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-white hover:text-red-400 cursor-pointer transition-colors">Gambar Broken Link</p>
                            <p class="text-xs text-neutral-500 mt-0.5">One Piece - Ch. 1100</p>
                        </div>
                        <span class="text-[10px] text-neutral-600 ml-auto whitespace-nowrap">2m lalu</span>
                    </div>

                    <div class="flex gap-3">
                        <div class="mt-1">
                            <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-white hover:text-blue-400 cursor-pointer transition-colors">Backup Database</p>
                            <p class="text-xs text-neutral-500 mt-0.5">Komikin DB Selesai</p>
                        </div>
                        <span class="text-[10px] text-neutral-600 ml-auto whitespace-nowrap">1j lalu</span>
                    </div>
                </div>
                
                <div class="p-3 bg-neutral-800/20 text-center border-t border-white/5">
                    <button class="text-xs text-neutral-500 hover:text-neutral-300">Lihat Log Aktivitas</button>
                </div>
            </div>
        </div>
    </div>
@endsection