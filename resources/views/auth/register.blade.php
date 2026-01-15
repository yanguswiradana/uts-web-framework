@extends('layouts.app')

@section('title', 'Daftar Akun - KOMIKIN')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 -mt-20">
    <div class="max-w-md w-full space-y-8 bg-[#1f1f1f] p-10 rounded-2xl shadow-2xl border border-gray-800">
        
        <div class="text-center">
            <h2 class="mt-4 text-3xl font-extrabold text-white">Buat Akun Baru</h2>
            <p class="mt-2 text-sm text-gray-400">Sudah punya akun? <a href="{{ route('login') }}" class="font-medium text-purple-500 hover:text-purple-400 transition">Masuk disini</a></p>
        </div>

        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500 text-red-500 px-4 py-2 rounded-lg text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM REGISTER --}}
        <form class="mt-8 space-y-6" action="{{ route('register.submit') }}" method="POST">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Nama Lengkap</label>
                    <input name="name" type="text" value="{{ old('name') }}" required class="block w-full px-3 py-3 border border-gray-700 bg-gray-900 rounded-lg text-white focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Email</label>
                    <input name="email" type="email" value="{{ old('email') }}" required class="block w-full px-3 py-3 border border-gray-700 bg-gray-900 rounded-lg text-white focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Password</label>
                    <input name="password" type="password" required class="block w-full px-3 py-3 border border-gray-700 bg-gray-900 rounded-lg text-white focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Konfirmasi Password</label>
                    <input name="password_confirmation" type="password" required class="block w-full px-3 py-3 border border-gray-700 bg-gray-900 rounded-lg text-white focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                </div>
            </div>

            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-purple-600 hover:bg-purple-700 transition shadow-lg shadow-purple-500/30">
                Daftar Sekarang
            </button>
        </form>
    </div>
</div>
@endsection