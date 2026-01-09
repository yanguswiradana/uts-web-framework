@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
{{-- Navbar Admin --}}
<nav class="bg-[#1f1f1f] border-b border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <span class="text-purple-500 font-bold text-xl">ADMIN KOMIKIN</span>
            </div>
            <div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

{{-- Main Content --}}
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    
    {{-- Header Content --}}
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-white">Daftar Komik</h1>
        <a href="{{ route('admin.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded-lg shadow-lg shadow-purple-500/30 transition">
            + Tambah Komik
        </a>
    </div>

    {{-- Pesan Sukses --}}
    @if(session('success'))
        <div class="bg-green-500/20 border border-green-500 text-green-400 px-4 py-3 rounded relative mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabel Data --}}
    <div class="bg-[#1f1f1f] shadow-xl rounded-xl overflow-hidden border border-gray-800">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-900 text-gray-400 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-4">Cover</th>
                        <th class="px-6 py-4">Judul</th>
                        <th class="px-6 py-4">Penulis</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800 text-gray-300">
                    @forelse($comics as $comic)
                    <tr class="hover:bg-gray-800/50 transition">
                        <td class="px-6 py-4">
                            <div class="h-16 w-12 rounded bg-gray-700 overflow-hidden">
                                <img src="{{ asset('storage/' . $comic->image_path) }}" class="h-full w-full object-cover">
                            </div>
                        </td>
                        <td class="px-6 py-4 font-medium text-white">{{ $comic->title }}</td>
                        <td class="px-6 py-4">{{ $comic->author ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('admin.destroy', $comic->id) }}" method="POST" onsubmit="return confirm('Yakin hapus komik ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300 transition text-sm font-semibold">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                            Belum ada data komik. Silakan tambah baru.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection