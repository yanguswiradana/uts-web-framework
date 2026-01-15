@extends('layouts.app')

@section('title', 'Masuk - KOMIKIN')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center relative">
    
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-lg h-full max-h-[500px] pointer-events-none">
        <div class="absolute top-0 right-0 w-64 h-64 bg-purple-600/20 rounded-full blur-3xl mix-blend-screen animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-indigo-600/20 rounded-full blur-3xl mix-blend-screen animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="w-full max-w-md relative z-10">
        <div class="bg-neutral-900/80 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-2xl">
            
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-gradient-to-br from-purple-600 to-indigo-600 shadow-lg shadow-purple-500/30 mb-4">
                    <i data-lucide="log-in" class="w-6 h-6 text-white"></i>
                </div>
                <h2 class="text-2xl font-bold text-white">Selamat Datang Kembali</h2>
                <p class="text-neutral-400 text-sm mt-2">Masuk untuk melanjutkan bacaanmu.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 bg-red-500/10 border border-red-500/20 rounded-xl p-4 flex gap-3 items-start">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-red-500 shrink-0 mt-0.5"></i>
                    <div class="text-sm text-red-400">
                        {{ $errors->first() }}
                    </div>
                </div>
            @endif

            <form action="{{ route('login.submit') }}" method="POST" class="space-y-5">
                @csrf
                
                <div class="space-y-2">
                    <label class="text-xs font-bold text-neutral-400 uppercase tracking-wider">Email Address</label>
                    <div class="relative group">
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com"
                               class="w-full bg-neutral-950 border border-white/10 rounded-xl py-3 pl-10 pr-4 text-white placeholder:text-neutral-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 focus:outline-none transition-all group-hover:border-white/20">
                        <i data-lucide="mail" class="absolute left-3.5 top-3.5 w-4 h-4 text-neutral-500 group-focus-within:text-purple-500 transition-colors"></i>
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <label class="text-xs font-bold text-neutral-400 uppercase tracking-wider">Password</label>
                        <a href="#" class="text-xs text-purple-400 hover:text-white transition-colors">Lupa Password?</a>
                    </div>
                    <div class="relative group">
                        <input type="password" name="password" required placeholder="••••••••"
                               class="w-full bg-neutral-950 border border-white/10 rounded-xl py-3 pl-10 pr-4 text-white placeholder:text-neutral-600 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 focus:outline-none transition-all group-hover:border-white/20">
                        <i data-lucide="lock" class="absolute left-3.5 top-3.5 w-4 h-4 text-neutral-500 group-focus-within:text-purple-500 transition-colors"></i>
                    </div>
                </div>

                <div class="flex items-center">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="checkbox" name="remember" class="peer appearance-none w-4 h-4 border border-white/20 rounded bg-neutral-950 checked:bg-purple-600 checked:border-purple-600 transition-all">
                        <span class="text-sm text-neutral-400 group-hover:text-white transition-colors">Ingat Saya</span>
                    </label>
                </div>

                <button type="submit" class="w-full bg-purple-600 hover:bg-purple-500 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-purple-900/20 hover:shadow-purple-900/40 hover:-translate-y-0.5 transition-all flex justify-center items-center gap-2">
                    Masuk Sekarang <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-white/5 text-center">
                <p class="text-neutral-400 text-sm">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-purple-400 font-bold hover:text-white transition-colors">Daftar Gratis</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection