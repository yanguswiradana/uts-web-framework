@extends('layouts.admin')

@section('title', 'Data Chapter')
@section('header_title', 'Manajemen Chapter')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div class="relative w-full md:w-64">
            <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-neutral-500"></i>
            <input type="text" placeholder="Cari chapter..." class="w-full bg-neutral-900 border border-white/10 rounded-lg pl-10 pr-4 py-2 text-sm focus:outline-none focus:border-purple-500 transition-colors">
        </div>
        <a href="#" class="bg-white text-neutral-900 hover:bg-neutral-200 px-5 py-2 rounded-lg text-sm font-bold transition-all flex items-center gap-2">
            <i data-lucide="plus-square" class="w-4 h-4"></i> Upload Chapter
        </a>
    </div>

    <div class="bg-neutral-900 border border-white/5 rounded-2xl overflow-hidden shadow-xl">
        <table class="w-full text-left text-sm text-neutral-400">
            <thead class="bg-white/[0.02] text-neutral-300 font-medium uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-6 py-4">Komik Induk</th>
                    <th class="px-6 py-4">Judul Chapter</th>
                    <th class="px-6 py-4">Tanggal Upload</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($chapters as $chapter)
                <tr class="hover:bg-white/[0.02] transition-colors">
                    <td class="px-6 py-4 font-medium text-white">
                        {{ $chapter->comic->title }}
                    </td>
                    <td class="px-6 py-4 text-purple-400">
                        {{ $chapter->title }}
                    </td>
                    <td class="px-6 py-4 text-xs font-mono">
                        {{ $chapter->created_at->format('d M Y, H:i') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="text-neutral-400 hover:text-red-500 transition-colors">
                            <i data-lucide="trash" class="w-4 h-4"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-neutral-500">Belum ada chapter.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t border-white/5">
            {{ $chapters->links() }}
        </div>
    </div>
@endsection