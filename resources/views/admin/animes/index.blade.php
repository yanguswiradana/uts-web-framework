@extends('layouts.admin')

@section('title', 'Kelola Anime')
@section('header_title', 'Daftar Anime')

@section('content')
<div class="bg-neutral-900 border border-white/5 rounded-2xl p-6 shadow-xl">
    
    <div class="flex justify-between items-center mb-6">
        <input type="text" placeholder="Cari Anime..." class="bg-neutral-950 border border-white/10 rounded-xl px-4 py-2 text-white focus:outline-none focus:border-purple-500">
        <a href="{{ route('admin.animes.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-xl font-bold text-sm transition-colors flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i> Tambah Anime
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-white/5 text-neutral-400 text-sm">
                    <th class="px-4 py-3">Cover</th>
                    <th class="px-4 py-3">Judul Anime</th>
                    <th class="px-4 py-3">Studio</th>
                    <th class="px-4 py-3">Rilis</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($animes as $anime)
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-4 py-3">
                            <img src="{{ asset('storage/'.$anime->cover) }}" class="w-12 h-16 object-cover rounded shadow-md">
                        </td>
                        <td class="px-4 py-3">
                            <p class="font-bold text-white">{{ $anime->title }}</p>
                            <p class="text-xs text-neutral-500">{{ $anime->episodes->count() }} Episode</p>
                        </td>
                        <td class="px-4 py-3 text-neutral-300 text-sm">{{ $anime->studio }}</td>
                        <td class="px-4 py-3 text-neutral-300 text-sm">{{ $anime->release_year }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded text-xs font-bold {{ $anime->status == 'Ongoing' ? 'bg-green-500/20 text-green-400' : 'bg-blue-500/20 text-blue-400' }}">
                                {{ $anime->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.animes.edit', $anime->id) }}" class="p-2 bg-neutral-800 rounded-lg text-yellow-500 hover:text-white hover:bg-yellow-500 transition-colors">
                                    <i data-lucide="edit-2" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.animes.destroy', $anime->id) }}" method="POST" onsubmit="return confirm('Hapus anime ini beserta semua episodenya?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-neutral-800 rounded-lg text-red-500 hover:text-white hover:bg-red-600 transition-colors">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-neutral-500">Belum ada data anime.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $animes->links() }}
    </div>
</div>
@endsection