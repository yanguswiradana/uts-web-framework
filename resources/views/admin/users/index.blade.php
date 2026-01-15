@extends('layouts.admin')

@section('title', 'Data User')
@section('header_title', 'Manajemen Pengguna')

@section('content')
    @if(session('success'))
    <div class="mb-6 bg-pink-500/10 border border-pink-500/20 text-pink-400 p-4 rounded-xl flex items-center gap-3">
        <i data-lucide="check-circle" class="w-5 h-5"></i> {{ session('success') }}
    </div>
    @endif

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
                @foreach($users as $user)
                <tr class="hover:bg-white/[0.02] transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-pink-600 flex items-center justify-center text-white font-bold text-xs">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <span class="text-white font-medium">{{ $user->name }}</span>
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
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="p-2 bg-neutral-800 hover:text-yellow-500 rounded-lg"><i data-lucide="user-cog" class="w-4 h-4"></i></a>
                        @if(auth()->id() !== $user->id) <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user ini?')">
                                @csrf @method('DELETE')
                                <button class="p-2 bg-neutral-800 hover:text-red-500 rounded-lg"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-white/5">{{ $users->links('pagination::tailwind') }}</div>
    </div>
@endsection