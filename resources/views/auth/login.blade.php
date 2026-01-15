@extends('layouts.app')

@section('title', 'Masuk - KOMIKIN')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 -mt-20">
    <div class="max-w-md w-full space-y-8 bg-[#1f1f1f] p-10 rounded-2xl shadow-2xl border border-gray-800">

        <div class="text-center">
            <img class="mx-auto h-24 w-auto" src="{{ asset('images/komikin-logo.png') }}" alt="Komikin">
            <h2 class="mt-4 text-3xl font-extrabold text-white">Selamat Datang Kembali</h2>
            <p class="mt-2 text-sm text-gray-400">
                Belum punya akun? <a href="{{ route('register') }}" class="font-medium text-purple-500 hover:text-purple-400 transition">Daftar sekarang</a>
            </p>
        </div>

        {{-- TAMPILKAN ERROR LOGIN --}}
        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500 text-red-500 px-4 py-2 rounded-lg text-sm mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- FORM LOGIN --}}
        <form class="mt-8 space-y-6" action="{{ route('login.submit') }}" method="POST">
            @csrf
            
            <div class="rounded-md shadow-sm space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-400 mb-1">Email Address</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required 
                           class="appearance-none block w-full px-3 py-3 border border-gray-700 placeholder-gray-500 text-white bg-gray-900 rounded-lg focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm transition">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-400 mb-1">Password</label>
                    <input id="password" name="password" type="password" required 
                           class="appearance-none block w-full px-3 py-3 border border-gray-700 placeholder-gray-500 text-white bg-gray-900 rounded-lg focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm transition">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-600 rounded bg-gray-800">
                    <label for="remember" class="ml-2 block text-sm text-gray-400">Ingat saya</label>
                </div>
            </div>

            <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-purple-600 hover:bg-purple-700 transition shadow-lg shadow-purple-500/30">
                Masuk
            </button>
        </form>
    </div>
</div>
@endsection