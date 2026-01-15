@extends('layouts.admin')

@section('title', 'Data Chapter')
@section('header_title', 'Manajemen Chapter')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-white">Daftar Chapter</h2>
            <p class="text-neutral-400 text-sm">Update episode terbaru untuk komik.</p>
        </div>
        <a href="{{ route('admin.chapters.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium transition-colors flex items-center gap-2 shadow-lg shadow-blue-900/20">
            <i data-lucide="upload-cloud" class="w-4 h-4"></i> Upload Chapter
        </a>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-blue-500/10 border border-blue-500/20 text-blue-400 p-4 rounded-xl flex items-center gap-3">
        <i data-lucide="check-circle" class="w-5 h-5"></i> {{ session('success') }}
    </div>
    @endif

    <div class="bg-neutral-900 border border-white/5 rounded-2xl overflow-hidden shadow-xl">
        <table class="w-full text-left text-sm text-neutral-400">
            <thead class="bg-white/[0.02] text-neutral-300 font-medium uppercase text-xs border-b border-white/5">
                <tr>
                    <th class="px-6 py-4">Komik & Chapter</th>
                    <th class="px-6 py-4">Nomor</th>
                    <th class="px-6 py-4">Tanggal Rilis</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($chapters as $chapter)
                <tr class="hover:bg-white/[0.02] transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-bold text-white">{{ $chapter->comic->title ?? 'Komik Terhapus' }}</div>
                        <div class="text-xs text-blue-400">{{ $chapter->title }}</div>
                    </td>
                    <td class="px-6 py-4"><span class="bg-neutral-800 px-2 py-1 rounded text-xs font-mono">Ch. {{ $chapter->number }}</span></td>
                    <td class="px-6 py-4 text-xs">{{ $chapter->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-right flex justify-end gap-2">
                        <a href="{{ route('admin.chapters.edit', $chapter->id) }}" class="p-2 bg-neutral-800 hover:text-yellow-500 rounded-lg"><i data-lucide="pencil" class="w-4 h-4"></i></a>
                        <form action="{{ route('admin.chapters.destroy', $chapter->id) }}" method="POST" onsubmit="return confirm('Hapus chapter ini?')">
                            @csrf @method('DELETE')
                            <button class="p-2 bg-neutral-800 hover:text-red-500 rounded-lg"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-6 py-10 text-center text-neutral-500">Belum ada chapter.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-white/5">{{ $chapters->links('pagination::tailwind') }}</div>
    </div>
@endsection