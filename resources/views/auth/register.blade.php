@extends('layouts.app')

@section('title', 'Daftar Akun - KOMIKIN')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center relative py-10">
    
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-lg h-full pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-purple-600/10 rounded-full blur-3xl mix-blend-screen"></div>
        <div class="absolute bottom-20 right-10 w-72 h-72 bg-pink-600/10 rounded-full blur-3xl mix-blend-screen"></div>
    </div>

    <div class="w-full max-w-md relative z-10">
        <div class="bg-neutral-900/80 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-2xl">
            
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-white">Buat Akun Baru</h2>
                <p class="text-neutral-400 text-sm mt-2">Gabung komunitas pembaca komik terbesar.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 bg-red-500/10 border border-red-500/20 rounded-xl p-4">
                    <ul class="list-disc list-inside text-sm text-red-400">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.submit') }}" method="POST" class="space-y-4">
                @csrf
                
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-neutral-500 uppercase">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="John Doe"
                           class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500 focus:outline-none transition-all placeholder:text-neutral-700">
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-neutral-500 uppercase">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com"
                           class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500 focus:outline-none transition-all placeholder:text-neutral-700">
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-neutral-500 uppercase">Password</label>
                    <input type="password" name="password" required placeholder="Minimal 8 karakter"
                           class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500 focus:outline-none transition-all placeholder:text-neutral-700">
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-neutral-500 uppercase">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required placeholder="Ulangi password"
                           class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:ring-1 focus:ring-purple-500 focus:outline-none transition-all placeholder:text-neutral-700">
                </div>

                <div class="pt-2">
                    <label class="flex items-start gap-2 cursor-pointer group">
                        <input type="checkbox" required class="mt-1 peer appearance-none w-4 h-4 border border-white/20 rounded bg-neutral-950 checked:bg-purple-600 checked:border-purple-600 transition-all shrink-0">
                        <span class="text-xs text-neutral-400 group-hover:text-white transition-colors leading-relaxed">
                            Saya setuju dengan <a href="#" class="text-purple-400 hover:underline">Syarat & Ketentuan</a> serta <a href="#" class="text-purple-400 hover:underline">Kebijakan Privasi</a>.
                        </span>
                    </label>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-purple-900/20 hover:shadow-purple-900/40 hover:-translate-y-0.5 transition-all mt-2">
                    Daftar Sekarang
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-white/5 text-center">
                <p class="text-neutral-400 text-sm">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-purple-400 font-bold hover:text-white transition-colors">Masuk disini</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection