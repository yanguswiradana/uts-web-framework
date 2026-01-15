<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KOMIKIN - Baca Komik Online')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        /* Custom Scrollbar Dark */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0a0a0a; }
        ::-webkit-scrollbar-thumb { background: #262626; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #9333ea; }
    </style>
</head>
<body class="bg-neutral-950 text-white min-h-screen flex flex-col selection:bg-purple-500 selection:text-white">

    <header x-data="{ mobileMenu: false }" class="fixed top-0 w-full z-50 bg-neutral-950/80 backdrop-blur-xl border-b border-white/5 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-purple-900/20 group-hover:scale-105 transition-transform">
                        <i data-lucide="zap" class="w-6 h-6 text-white fill-white"></i>
                    </div>
                    <span class="text-xl font-bold tracking-tight">Komik<span class="text-purple-500">in</span></span>
                </a>

                <nav class="hidden md:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="text-sm font-medium hover:text-purple-400 transition-colors {{ request()->routeIs('home') ? 'text-purple-500' : 'text-neutral-400' }}">Home</a>
                    <a href="{{ route('explore.index') }}" class="text-sm font-medium hover:text-purple-400 transition-colors {{ request()->routeIs('explore.*') ? 'text-purple-500' : 'text-neutral-400' }}">Explore</a>
                    <a href="{{ route('library.index') }}" class="text-sm font-medium hover:text-purple-400 transition-colors {{ request()->routeIs('library.*') ? 'text-purple-500' : 'text-neutral-400' }}">Library</a>
                </nav>

                <div class="hidden md:flex items-center gap-4">
                    <form action="{{ route('explore.index') }}" class="relative group">
                        <input type="text" name="search" placeholder="Cari komik..." 
                               class="bg-neutral-900 border border-white/10 text-sm rounded-full pl-10 pr-4 py-2 w-64 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-all placeholder:text-neutral-600 group-hover:border-white/20">
                        <i data-lucide="search" class="absolute left-3.5 top-2.5 w-4 h-4 text-neutral-500 group-hover:text-purple-400 transition-colors"></i>
                    </form>

                    @guest
                        <a href="{{ route('login') }}" class="text-sm font-bold text-white bg-purple-600 hover:bg-purple-700 px-5 py-2 rounded-full transition-all shadow-lg shadow-purple-900/20">
                            Masuk
                        </a>
                    @else
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-3 hover:bg-white/5 p-1 pr-3 rounded-full transition-colors border border-transparent hover:border-white/5">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center text-xs font-bold shadow-inner">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span class="text-sm font-medium text-neutral-300">{{ Str::limit(Auth::user()->name, 10) }}</span>
                                <i data-lucide="chevron-down" class="w-4 h-4 text-neutral-500"></i>
                            </button>

                            <div x-show="open" @click.away="open = false" 
                                 class="absolute right-0 mt-2 w-48 bg-neutral-900 border border-white/10 rounded-xl shadow-2xl py-2 z-50 origin-top-right"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 style="display: none;">
                                
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-purple-400 hover:bg-white/5">
                                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
                                    </a>
                                @endif
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-400 hover:bg-white/5 text-left">
                                        <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>

                <button @click="mobileMenu = !mobileMenu" class="md:hidden text-neutral-400 hover:text-white">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
            </div>
        </div>

        <div x-show="mobileMenu" class="md:hidden bg-neutral-900 border-t border-white/10 p-4 space-y-4" style="display: none;">
            <a href="{{ route('home') }}" class="block text-neutral-300 hover:text-white">Home</a>
            <a href="{{ route('explore.index') }}" class="block text-neutral-300 hover:text-white">Explore</a>
            <a href="{{ route('library.index') }}" class="block text-neutral-300 hover:text-white">Library</a>
            @guest
                <a href="{{ route('login') }}" class="block text-center bg-purple-600 text-white py-2 rounded-lg">Masuk</a>
            @endguest
        </div>
    </header>

    <main class="flex-1 pt-24 pb-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
        @yield('content')
    </main>

    <footer class="border-t border-white/5 bg-neutral-950 py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-neutral-500 text-sm">&copy; {{ date('Y') }} Komikin. Created with Laravel & Tailwind.</p>
        </div>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>