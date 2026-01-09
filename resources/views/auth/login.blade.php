<!-- <!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; padding-top: 50px; }
        form { border: 1px solid #ccc; padding: 20px; border-radius: 5px; width: 300px; }
        input { width: 100%; margin-bottom: 10px; padding: 8px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: blue; color: white; border: none; cursor: pointer; }
        .error { color: red; font-size: 0.9em; margin-bottom: 10px; }
    </style>
</head>
<body>

    <form action="{{ url('/login') }}" method="POST">
        @csrf
        <h2 style="text-align: center">Login</h2>

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <label>Email</label>
        <input type="email" name="email" required placeholder="admin@gmail.com">

        <label>Password</label>
        <input type="password" name="password" required placeholder="password123">

        <button type="submit">Masuk</button>
    </form>

</body>
</html> -->

@extends('layouts.app')

@section('title', 'Masuk - KOMIKIN')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    
    <div class="max-w-md w-full space-y-8 bg-[#1f1f1f] p-10 rounded-2xl shadow-2xl border border-gray-800">

        {{-- Header Login --}}
        <div class="text-center">
            {{-- Pastikan kamu punya file logo, atau pakai teks dulu --}}
            {{-- <img class="mx-auto h-24 w-auto" src="{{ asset('images/logo.png') }}" alt="Komikin"> --}}
            <h1 class="text-4xl font-bold text-purple-500">KOMIKIN</h1>
            <h2 class="mt-4 text-3xl font-extrabold text-white">
                Selamat Datang Kembali
            </h2>
            <p class="mt-2 text-sm text-gray-400">
                Silakan masuk ke akun admin anda
            </p>
        </div>

        {{-- TAMPILKAN ERROR JIKA LOGIN GAGAL --}}
        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ $errors->first() }}</span>
            </div>
        @endif

        {{-- Form Login REAL (Sudah diperbaiki) --}}
        <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
            @csrf {{-- Wajib ada --}}
            
            <div class="rounded-md shadow-sm space-y-4">
                {{-- Input Email --}}
                <div>
                    <label for="email-address" class="block text-sm font-medium text-gray-400 mb-1">Email Address</label>
                    <input id="email-address" name="email" type="email" required
                           class="appearance-none relative block w-full px-3 py-3 border border-gray-700 placeholder-gray-500 text-white bg-gray-900 rounded-lg focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm transition"
                           placeholder="admin@gmail.com">
                </div>

                {{-- Input Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-400 mb-1">Password</label>
                    <input id="password" name="password" type="password" required
                           class="appearance-none relative block w-full px-3 py-3 border border-gray-700 placeholder-gray-500 text-white bg-gray-900 rounded-lg focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm transition"
                           placeholder="••••••••">
                </div>
            </div>

            {{-- Submit Button --}}
            <div>
                <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition shadow-lg shadow-purple-500/30">
                    Masuk Dashboard
                </button>
            </div>
        </form>
    </div>
</div>
@endsection