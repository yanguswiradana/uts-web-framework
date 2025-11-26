@extends('layouts.app')

@section('title', 'Daftar Akun - KOMIKIN')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 -mt-20">
    <div class="max-w-md w-full space-y-8 bg-[#1f1f1f] p-10 rounded-2xl shadow-2xl border border-gray-800">

        <div class="text-center">
            <img class="mx-auto h-24 w-auto" src="{{ asset('images/komikin-logo.png') }}" alt="Komikin">
            <h2 class="mt-4 text-3xl font-extrabold text-white">
                Buat Akun Baru
            </h2>
            <p class="mt-2 text-sm text-gray-400">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-medium text-purple-500 hover:text-purple-400 transition">
                    Masuk disini
                </a>
            </p>
        </div>

        <form class="mt-8 space-y-6" action="#" method="POST" onsubmit="event.preventDefault(); window.location='{{ route('login') }}'">
            <div class="space-y-4">

                {{-- Nama Lengkap --}}
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Nama Lengkap</label>
                    <input type="text" required class="appearance-none block w-full px-3 py-3 border border-gray-700 placeholder-gray-500 text-white bg-gray-900 rounded-lg focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm transition" placeholder="Jhon Doe">
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Email Address</label>
                    <input type="email" required class="appearance-none block w-full px-3 py-3 border border-gray-700 placeholder-gray-500 text-white bg-gray-900 rounded-lg focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm transition" placeholder="nama@email.com">
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Password</label>
                    <input type="password" required class="appearance-none block w-full px-3 py-3 border border-gray-700 placeholder-gray-500 text-white bg-gray-900 rounded-lg focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm transition" placeholder="••••••••">
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1">Konfirmasi Password</label>
                    <input type="password" required class="appearance-none block w-full px-3 py-3 border border-gray-700 placeholder-gray-500 text-white bg-gray-900 rounded-lg focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm transition" placeholder="••••••••">
                </div>
            </div>

            <div class="flex items-center">
                <input id="terms" name="terms" type="checkbox" required class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-600 rounded bg-gray-800">
                <label for="terms" class="ml-2 block text-sm text-gray-400">
                    Saya setuju dengan <a href="#" class="text-purple-500 hover:underline">Syarat & Ketentuan</a>
                </label>
            </div>

            <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition shadow-lg shadow-purple-500/30">
                Daftar Sekarang
            </button>
        </form>
    </div>
</div>
@endsection
