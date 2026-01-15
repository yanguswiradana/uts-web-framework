@extends('layouts.admin')

@section('title', 'Data User')
@section('header_title', 'Manajemen Pengguna')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-white">Daftar Pengguna</h2>
            <p class="text-neutral-400 text-sm">Kelola akses dan data user.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="bg-pink-600 hover:bg-pink-700 text-white px-5 py-2.5 rounded-xl font-medium transition-colors flex items-center gap-2 shadow-lg shadow-pink-900/20">
            <i data-lucide="user-plus" class="w-4 h-4"></i> Tambah User
        </a>
    </div>

    <div class="bg-neutral-900 border border-white/5 rounded-2xl overflow-hidden shadow-xl">
        <table class="w-full text-left text-sm text-neutral-400">
            <thead class="bg-white/[0.02] text-neutral-300 font-medium uppercase text-xs border-b border-white/5">
                <tr>
                    <th class="px-6 py-4">Nama User</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Role</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($users as $user)
                <tr class="hover:bg-white/[0.02] transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-pink-600 flex items-center justify-center text-white font-bold text-xs">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <span class="text-white font-medium">{{ $user->name }}</span>
                            
                            {{-- Tanda (You) jika ini user yang sedang login --}}
                            @if(auth()->id() === $user->id)
                                <span class="text-[10px] bg-neutral-700 text-white px-1.5 rounded">You</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">{{ $user->email }}</td>
                    <td class="px-6 py-4">
                        @if($user->role === 'admin')
                            <span class="bg-purple-500/10 text-purple-400 border border-purple-500/20 px-2 py-1 rounded text-xs font-bold uppercase">Admin</span>
                        @else
                            <span class="bg-neutral-800 text-neutral-400 border border-white/5 px-2 py-1 rounded text-xs">User</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right flex justify-end gap-2">
                        {{-- TOMBOL EDIT --}}
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="p-2 bg-neutral-800 hover:text-yellow-500 rounded-lg transition-colors" title="Edit User">
                            <i data-lucide="user-cog" class="w-4 h-4"></i>
                        </a>
                        
                        {{-- TOMBOL HAPUS (Hanya muncul jika BUKAN user yang sedang login) --}}
                        @if(auth()->id() !== $user->id)
                            <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block">
                                @csrf 
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete('{{ $user->id }}')" class="p-2 bg-neutral-800 hover:text-red-500 rounded-lg transition-colors" title="Hapus User">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-neutral-500">
                        Tidak ada data user lain.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-white/5 bg-neutral-900">
            {{ $users->links('pagination::tailwind') }}
        </div>
    </div>
@endsection