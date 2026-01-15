@extends('layouts.admin')

@section('title', 'Data Komik')
@section('header_title', 'Manajemen Komik')

@section('content')

    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-white">Daftar Komik</h2>
            <p class="text-neutral-400 text-sm">Kelola semua judul komik yang tersedia.</p>
        </div>
        <a href="{{ route('admin.comics.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2.5 rounded-xl font-medium transition-colors flex items-center gap-2 shadow-lg shadow-purple-900/20">
            <i data-lucide="plus" class="w-4 h-4"></i> Tambah Baru
        </a>
    </div>

    <div class="bg-neutral-900 border border-white/5 rounded-2xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-neutral-400">
                <thead class="bg-white/[0.02] text-neutral-300 font-medium uppercase text-xs tracking-wider border-b border-white/5">
                    <tr>
                        <th class="px-6 py-4">Cover & Info</th>
                        <th class="px-6 py-4">Slug (URL)</th> <th class="px-6 py-4">Genre</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($comics as $comic)
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-16 bg-neutral-800 rounded-lg shadow-inner overflow-hidden relative shrink-0 border border-white/5">
                                    @if($comic->cover)
                                        <img src="{{ Str::startsWith($comic->cover, 'http') ? $comic->cover : asset('storage/' . $comic->cover) }}" 
                                             alt="{{ $comic->title }}" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="flex items-center justify-center h-full text-xs font-bold text-neutral-600">
                                            No IMG
                                        </div>
                                    @endif
                                </div>
                                
                                <div>
                                    <div class="font-bold text-white text-base group-hover:text-purple-400 transition-colors">
                                        {{ $comic->title }}
                                    </div>
                                    <div class="text-xs text-neutral-500 mt-1">
                                        {{ $comic->type }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4">
                            <code class="text-xs font-mono text-purple-400 bg-purple-500/10 px-2 py-1 rounded select-all">
                                {{ $comic->slug }}
                            </code>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach($comic->genres as $genre)
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-neutral-800 border border-white/10 text-neutral-400">
                                        {{ $genre->name }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($comic->status == 'Ongoing')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-green-500/10 text-green-400 text-xs font-medium border border-green-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span> On
                                </span>
                            @elseif($comic->status == 'Finished')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-blue-500/10 text-blue-400 text-xs font-medium border border-blue-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> End
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-yellow-500/10 text-yellow-400 text-xs font-medium border border-yellow-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> Hiatus
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end items-center gap-2">
                                <a href="{{ route('admin.comics.edit', $comic->id) }}" class="p-2 bg-neutral-800 hover:text-yellow-500 rounded-lg transition-colors border border-transparent hover:border-yellow-500/20">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>
                                
                                <form id="delete-form-{{ $comic->id }}" action="{{ route('admin.comics.destroy', $comic->id) }}" method="POST" class="inline-block">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete('{{ $comic->id }}')" class="p-2 bg-neutral-800 hover:text-red-500 rounded-lg transition-colors border border-transparent hover:border-red-500/20">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center text-neutral-500">
                            Belum ada data komik.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-white/5 bg-neutral-900">
            {{ $comics->links('pagination::tailwind') }}
        </div>
    </div>
@endsection