@extends('layouts.admin')

@section('title', 'Data Komik')
@section('header_title', 'Manajemen Komik')

@section('content')
    @if(session('success'))
    <div class="mb-6 bg-green-500/10 border border-green-500/20 text-green-400 p-4 rounded-xl flex items-center gap-3">
        <i data-lucide="check-circle" class="w-5 h-5"></i>
        {{ session('success') }}
    </div>
    @endif

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
                        <th class="px-6 py-4">Judul Komik</th>
                        <th class="px-6 py-4">Tipe</th>
                        <th class="px-6 py-4">Genre</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($comics as $comic)
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-14 bg-neutral-800 rounded shadow-inner overflow-hidden relative shrink-0 border border-white/5">
                                    <div class="flex items-center justify-center h-full text-xs font-bold text-neutral-600">
                                        {{ substr($comic->title, 0, 1) }}
                                    </div>
                                </div>
                                <div>
                                    <div class="font-bold text-white text-base group-hover:text-purple-400 transition-colors">
                                        {{ $comic->title }}
                                    </div>
                                    <div class="text-xs text-neutral-500 mt-0.5">
                                        {{ $comic->slug }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-medium bg-neutral-800 border border-white/10 text-white">
                                {{ $comic->type }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach($comic->genres as $genre)
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-purple-500/10 text-purple-400 border border-purple-500/20">
                                        {{ $genre->name }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($comic->status == 'Ongoing')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-green-500/10 text-green-400 text-xs font-medium border border-green-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span> Ongoing
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-blue-500/10 text-blue-400 text-xs font-medium border border-blue-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Finished
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end items-center gap-2">
                                <a href="{{ route('admin.comics.edit', $comic->id) }}" class="p-2 bg-neutral-800 hover:bg-yellow-500/10 hover:text-yellow-500 text-neutral-400 rounded-lg transition-all border border-transparent hover:border-yellow-500/20" title="Edit">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>
                                
                                <form action="{{ route('admin.comics.destroy', $comic->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komik ini? Data chapter juga akan hilang.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-neutral-800 hover:bg-red-500/10 hover:text-red-500 text-neutral-400 rounded-lg transition-all border border-transparent hover:border-red-500/20" title="Hapus">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center text-neutral-500">
                            <div class="flex flex-col items-center justify-center opacity-50">
                                <i data-lucide="folder-open" class="w-12 h-12 mb-4 text-neutral-600"></i>
                                <p class="text-lg font-medium">Belum ada data komik</p>
                                <p class="text-sm">Silakan tambahkan komik baru terlebih dahulu.</p>
                            </div>
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