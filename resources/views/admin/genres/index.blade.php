@extends('layouts.admin')

@section('title', 'Data Genre')
@section('header_title', 'Manajemen Genre')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-white">Daftar Genre</h2>
            <p class="text-neutral-400 text-sm">Kategori atau tag untuk komik.</p>
        </div>
        <a href="{{ route('admin.genres.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl font-medium transition-colors flex items-center gap-2 shadow-lg shadow-emerald-900/20">
            <i data-lucide="plus" class="w-4 h-4"></i> Tambah Genre
        </a>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 p-4 rounded-xl flex items-center gap-3">
        <i data-lucide="check-circle" class="w-5 h-5"></i> {{ session('success') }}
    </div>
    @endif

    <div class="bg-neutral-900 border border-white/5 rounded-2xl overflow-hidden shadow-xl">
        <table class="w-full text-left text-sm text-neutral-400">
            <thead class="bg-white/[0.02] text-neutral-300 font-medium uppercase text-xs border-b border-white/5">
                <tr>
                    <th class="px-6 py-4">Nama Genre</th>
                    <th class="px-6 py-4">Slug</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($genres as $genre)
                <tr class="hover:bg-white/[0.02] transition-colors">
                    <td class="px-6 py-4 font-bold text-white">{{ $genre->name }}</td>
                    <td class="px-6 py-4 font-mono text-xs text-emerald-400">{{ $genre->slug }}</td>
                    <td class="px-6 py-4 text-right flex justify-end gap-2">
                        <a href="{{ route('admin.genres.edit', $genre->id) }}" class="p-2 bg-neutral-800 hover:text-yellow-500 rounded-lg transition-colors">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                        </a>
                        <form action="{{ route('admin.genres.destroy', $genre->id) }}" method="POST" onsubmit="return confirm('Hapus genre ini?')">
                            @csrf @method('DELETE')
                            <button class="p-2 bg-neutral-800 hover:text-red-500 rounded-lg transition-colors">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="px-6 py-10 text-center text-neutral-500">Belum ada data genre.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-white/5">{{ $genres->links('pagination::tailwind') }}</div>
    </div>
@endsection