@extends('layouts.admin')

@section('title', 'Data Komik')
@section('header_title', 'Manajemen Komik')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div class="relative w-full md:w-64">
            <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-neutral-500"></i>
            <input type="text" placeholder="Cari judul komik..." class="w-full bg-neutral-900 border border-white/10 rounded-lg pl-10 pr-4 py-2 text-sm focus:outline-none focus:border-purple-500 transition-colors text-white placeholder-neutral-600">
        </div>

        <a href="#" class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2 rounded-lg text-sm font-bold transition-all shadow-lg shadow-purple-600/20 flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i> Tambah Komik
        </a>
    </div>

    <div class="bg-neutral-900 border border-white/5 rounded-2xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-neutral-400">
                <thead class="bg-white/[0.02] text-neutral-300 font-medium uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Cover & Judul</th>
                        <th class="px-6 py-4">Tipe</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Genre</th> <th class="px-6 py-4">Author</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($comics as $comic)
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-14 bg-neutral-800 rounded overflow-hidden shrink-0 shadow-sm relative border border-white/5">
                                    <img src="{{ $comic->cover ?? 'https://via.placeholder.com/150x200?text=No+Img' }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                         alt="{{ $comic->title }}">
                                </div>
                                <div>
                                    <div class="font-bold text-white text-base group-hover:text-purple-400 transition-colors">
                                        {{ $comic->title }}
                                    </div>
                                    <div class="text-xs text-neutral-500 mt-0.5 font-mono">
                                        /{{ $comic->slug }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            @php
                                $typeClass = match($comic->type) {
                                    'Manhwa' => 'text-purple-400 border-purple-500/20 bg-purple-500/5',
                                    'Manga' => 'text-blue-400 border-blue-500/20 bg-blue-500/5',
                                    'Manhua' => 'text-pink-400 border-pink-500/20 bg-pink-500/5',
                                    default => 'text-gray-400'
                                };
                            @endphp
                            <span class="px-2 py-1 text-[10px] uppercase font-bold border rounded {{ $typeClass }}">
                                {{ $comic->type }}
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            @php
                                $statusClass = match($comic->status) {
                                    'Ongoing' => 'bg-green-500/10 text-green-400 border-green-500/20',
                                    'Finished' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                                    'Hiatus' => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20',
                                    default => 'text-gray-400'
                                };
                            @endphp
                            <span class="px-2 py-1 rounded text-xs font-medium border {{ $statusClass }}">
                                {{ $comic->status }}
                            </span>
                        </td>

                        <td class="px-6 py-4 max-w-xs">
                            <div class="flex flex-wrap gap-1.5">
                                @forelse($comic->genres as $genre)
                                    <span class="px-2 py-0.5 rounded text-[10px] bg-neutral-800 border border-white/10 text-neutral-300 hover:border-purple-500/50 transition-colors cursor-default">
                                        {{ $genre->name }}
                                    </span>
                                @empty
                                    <span class="text-xs text-neutral-600 italic">-</span>
                                @endforelse
                            </div>
                        </td>

                        <td class="px-6 py-4 text-neutral-300 text-sm">
                            {{ $comic->author ?? '-' }}
                        </td>

                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button class="p-2 bg-neutral-800 hover:bg-blue-600 text-neutral-400 hover:text-white rounded-lg transition-all" title="Edit">
                                    <i data-lucide="edit-2" class="w-4 h-4"></i>
                                </button>
                                <button class="p-2 bg-neutral-800 hover:bg-red-600 text-neutral-400 hover:text-white rounded-lg transition-all" title="Hapus">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-neutral-500">
                            <div class="flex flex-col items-center justify-center opacity-40">
                                <i data-lucide="book-open" class="w-12 h-12 mb-3"></i>
                                <p>Belum ada data komik tersedia.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-white/5">
            {{ $comics->links() }}
        </div>
    </div>
@endsection