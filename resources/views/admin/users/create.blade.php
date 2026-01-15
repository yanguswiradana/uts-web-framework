@extends('layouts.admin')

@section('title', 'Tambah User')
@section('header_title', 'Tambah Pengguna Baru')

@section('content')
<div class="max-w-xl mx-auto">
    <a href="{{ route('admin.users.index') }}" class="text-neutral-400 hover:text-white mb-6 inline-flex items-center gap-2 text-sm">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
    </a>

    <div class="bg-neutral-900 border border-white/5 rounded-2xl p-8 shadow-xl">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf 
            
            {{-- Nama --}}
            <div class="mb-4">
                <label class="block text-sm font-bold text-neutral-300 mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-pink-500 focus:outline-none placeholder-neutral-600" placeholder="John Doe" required>
                @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label class="block text-sm font-bold text-neutral-300 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-pink-500 focus:outline-none placeholder-neutral-600" placeholder="nama@email.com" required>
                @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Role --}}
            <div class="mb-4">
                <label class="block text-sm font-bold text-neutral-300 mb-2">Role</label>
                <div class="relative">
                    <select name="role" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-pink-500 appearance-none cursor-pointer">
                        <option value="user">User Biasa</option>
                        <option value="admin">Administrator</option>
                    </select>
                    <i data-lucide="chevron-down" class="absolute right-4 top-3.5 w-5 h-5 text-neutral-500 pointer-events-none"></i>
                </div>
            </div>

            <div class="mb-4 pt-4 border-t border-white/5">
                <label class="block text-sm font-bold text-neutral-300 mb-2">Password</label>
                <input type="password" name="password" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-pink-500 focus:outline-none" placeholder="Minimal 8 karakter" required>
                @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-neutral-300 mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-pink-500 focus:outline-none" placeholder="Ulangi password" required>
            </div>

            <button type="submit" class="w-full bg-pink-600 hover:bg-pink-500 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-pink-900/30">Simpan User Baru</button>
        </form>
    </div>
</div>
@endsection