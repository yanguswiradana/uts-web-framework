@extends('layouts.admin')

@section('title', 'Data Pengguna')
@section('header_title', 'Manajemen User')

@section('content')
    <div class="bg-neutral-900 border border-white/5 rounded-2xl overflow-hidden shadow-xl mt-4">
        <table class="w-full text-left text-sm text-neutral-400">
            <thead class="bg-white/[0.02] text-neutral-300 font-medium uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-6 py-4">Nama User</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Role</th>
                    <th class="px-6 py-4">Bergabung</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($users as $user)
                <tr class="hover:bg-white/[0.02] transition-colors">
                    <td class="px-6 py-4 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-purple-500 to-blue-500 flex items-center justify-center text-white font-bold text-xs">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <span class="text-white font-medium">{{ $user->name }}</span>
                    </td>
                    <td class="px-6 py-4">{{ $user->email }}</td>
                    <td class="px-6 py-4">
                        @if($user->role === 'admin')
                            <span class="bg-purple-500/10 text-purple-400 border border-purple-500/20 px-2 py-1 rounded-full text-xs font-bold">Admin</span>
                        @else
                            <span class="bg-neutral-800 text-neutral-400 border border-white/5 px-2 py-1 rounded-full text-xs">User</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-xs font-mono">{{ $user->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4 border-t border-white/5">
            {{ $users->links() }}
        </div>
    </div>
@endsection