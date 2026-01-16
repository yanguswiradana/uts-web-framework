@extends('layouts.admin')

@section('title', 'Kelola Episode')
@section('header_title', 'Daftar Episode Anime')

@section('content')
<div class="bg-neutral-900 border border-white/5 rounded-2xl p-6 shadow-xl">
    
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-bold text-white">List Semua Episode</h3>
        <a href="{{ route('admin.anime_episodes.create') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl font-bold text-sm transition-colors flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i> Upload Episode
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-white/5 text-neutral-400 text-sm">
                    <th class="px-4 py-3">Anime</th>
                    <th class="px-4 py-3">Episode</th>
                    <th class="px-4 py-3">Link Youtube</th>
                    <th class="px-4 py-3">Tanggal Upload</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($episodes as $ep)
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-4 py-3 flex items-center gap-3">
                            <img src="{{ asset('storage/'.$ep->anime->cover) }}" class="w-8 h-10 object-cover rounded">
                            <span class="font-bold text-white text-sm">{{ $ep->anime->title }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="bg-neutral-800 px-2 py-1 rounded text-xs font-bold text-white">Ep {{ $ep->episode_number }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ $ep->youtube_link }}" target="_blank" class="text-red-400 hover:text-red-300 text-xs flex items-center gap-1 underline">
                                <i data-lucide="youtube" class="w-3 h-3"></i> Tonton
                            </a>
                        </td>
                        <td class="px-4 py-3 text-neutral-500 text-xs">
                            {{ $ep->created_at->format('d M Y') }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.anime_episodes.edit', $ep->id) }}" class="p-2 bg-neutral-800 rounded-lg text-yellow-500 hover:text-white hover:bg-yellow-500 transition-colors">
                                    <i data-lucide="edit-2" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('admin.anime_episodes.destroy', $ep->id) }}" method="POST" onsubmit="return confirm('Hapus episode ini?');">
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
                        <td colspan="5" class="px-4 py-8 text-center text-neutral-500">Belum ada episode diupload.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $episodes->links() }}
    </div>
</div>
@endsection