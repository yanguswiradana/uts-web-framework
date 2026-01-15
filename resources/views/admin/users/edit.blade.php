@extends('layouts.admin')
@section('title', 'Edit User')
@section('header_title', 'Edit Pengguna')

@section('content')
<div class="max-w-xl mx-auto">
    <a href="{{ route('admin.users.index') }}" class="text-neutral-400 hover:text-white mb-6 inline-flex items-center gap-2 text-sm"><i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali</a>

    <div class="bg-neutral-900 border border-white/5 rounded-2xl p-8 shadow-xl">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf @method('PUT')
            
            <div class="mb-4">
                <label class="block text-sm font-bold text-neutral-300 mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ $user->name }}" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-pink-500 focus:outline-none" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold text-neutral-300 mb-2">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-pink-500 focus:outline-none" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold text-neutral-300 mb-2">Role</label>
                <div class="relative">
                    <select name="role" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-pink-500 appearance-none">
                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User Biasa</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrator</option>
                    </select>
                    <i data-lucide="chevron-down" class="absolute right-4 top-3.5 w-5 h-5 text-neutral-500 pointer-events-none"></i>
                </div>
            </div>

            <div class="mb-6 pt-4 border-t border-white/5">
                <label class="block text-sm font-bold text-neutral-300 mb-2">Password Baru (Opsional)</label>
                <input type="password" name="password" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-pink-500 focus:outline-none" placeholder="Isi hanya jika ingin ganti password">
            </div>

            <button type="submit" class="w-full bg-pink-600 hover:bg-pink-500 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-pink-900/30">Update User</button>
        </form>
    </div>
</div>
@endsection