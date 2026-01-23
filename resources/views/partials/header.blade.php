{{-- ==================================================================== --}}
{{-- 1. DESKTOP HEADER (Visible >= md)                                    --}}
{{-- ==================================================================== --}}
<header x-data="{ profileDropdownOpen: false }" class="hidden md:block bg-black shadow-2xl sticky top-0 z-50 border-b border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">

            {{-- LOGO --}}
            <div class="flex items-center flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    @if(isset($web_config['app_logo']) && $web_config['app_logo'])
                        <img src="{{ asset('storage/' . $web_config['app_logo']) }}" alt="Logo" class="w-16 h-16 md:w-20 md:h-20 object-contain group-hover:scale-110 transition-transform duration-300">
                    @else
                        <img src="{{ asset('images/komikin-logo.png') }}" alt="Logo" class="w-16 h-16 md:w-20 md:h-20 object-contain group-hover:scale-110 transition-transform duration-300" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="hidden w-16 h-16 md:w-20 md:h-20 items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="zap" class="w-10 h-10 md:w-12 md:h-12 text-purple-500 fill-purple-500"></i>
                        </div>
                    @endif
                </a>
            </div>

            {{-- NAVIGASI --}}
            <nav class="hidden md:flex space-x-8 lg:space-x-12">
                <a href="{{ route('home') }}" class="text-white hover:text-purple-500 font-medium text-lg transition duration-200 border-b-2 pb-1 {{ request()->routeIs('home') ? 'border-purple-500 text-purple-500' : 'border-transparent text-gray-400' }}">Home</a>
                <a href="{{ route('explore.index') }}" class="text-white hover:text-purple-500 font-medium text-lg transition duration-200 border-b-2 pb-1 {{ request()->routeIs('explore.index') ? 'border-purple-500 text-purple-500' : 'border-transparent text-gray-400' }}">Explore</a>
                @auth
                <a href="{{ route('library.index') }}" class="text-white hover:text-purple-500 font-medium text-lg transition duration-200 border-b-2 pb-1 {{ request()->routeIs('library.index') ? 'border-purple-500 text-purple-500' : 'border-transparent text-gray-400' }}">Library</a>
                @endauth
            </nav>

            {{-- KANAN (Search & Profile) --}}
            <div class="flex items-center space-x-4">
                <form action="{{ route('explore.index') }}" method="GET" class="hidden lg:block">
                    <div class="relative w-64">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="w-full py-2 pl-10 pr-4 border border-gray-700 bg-gray-900 text-white rounded-full focus:ring-purple-500 focus:border-purple-500 text-sm transition duration-150" />
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                        </div>
                    </div>
                </form>

                @guest
                    <a href="{{ route('login') }}" class="hidden md:flex items-center space-x-2 bg-purple-600 text-white py-2 px-4 rounded-full hover:bg-purple-700 transition duration-200 text-sm font-semibold shadow-lg shadow-purple-500/30">
                        <i data-lucide="log-in" class="w-4 h-4"></i> <span>Masuk</span>
                    </a>
                @else
                    <div class="hidden md:relative md:block">
                        <button @click="profileDropdownOpen = !profileDropdownOpen" @click.away="profileDropdownOpen = false" class="flex items-center space-x-2 text-white hover:text-purple-400 focus:outline-none">
                            <div class="h-9 w-9 rounded-full bg-gradient-to-tr from-purple-500 to-indigo-500 flex items-center justify-center font-bold shadow-lg text-white">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="text-sm font-medium">{{ Str::limit(Auth::user()->name, 10) }}</span>
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </button>
                        <div x-show="profileDropdownOpen" style="display: none;" class="absolute right-0 mt-2 w-48 bg-gray-900 border border-gray-700 rounded-xl shadow-xl py-1 z-50">
                             <div class="px-4 py-3 border-b border-gray-800">
                                <p class="text-sm text-white">Signed in as</p>
                                <p class="text-sm font-medium text-purple-400 truncate">{{ Auth::user()->email }}</p>
                             </div>
                             @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white">Dashboard Admin</a>
                             @endif
                             <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-gray-800 hover:text-red-300">Keluar</button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</header>


{{-- ==================================================================== --}}
{{-- 2. MOBILE TOP HEADER (Visible < md)                                  --}}
{{-- ==================================================================== --}}
<header class="md:hidden bg-black shadow-lg sticky top-0 z-50 border-b border-gray-800 h-16 px-4 flex items-center justify-between">
    <a href="{{ route('explore.index') }}" class="p-2 -ml-2 text-gray-400 hover:text-white">
        <i data-lucide="search" class="w-6 h-6"></i>
    </a>

    <a href="{{ route('home') }}" class="absolute left-1/2 -translate-x-1/2 flex items-center">
        @if(isset($web_config['app_logo']) && $web_config['app_logo'])
            <img src="{{ asset('storage/' . $web_config['app_logo']) }}" alt="Logo" class="h-10 w-auto object-contain">
        @else
            <div class="flex items-center gap-2">
                <i data-lucide="zap" class="w-6 h-6 text-purple-500 fill-purple-500"></i>
                <span class="font-bold text-lg tracking-tight text-white">{{ $web_config['app_name'] ?? 'KOMIKIN' }}</span>
            </div>
        @endif
    </a>

    @auth
    <a href="{{ route('library.index') }}" class="p-2 -mr-2 text-purple-400 hover:text-white relative">
        <i data-lucide="bookmark" class="w-6 h-6 fill-current"></i>
    </a>
    @else
    {{-- Jika belum login, tampilkan tombol masuk kecil --}}
    <a href="{{ route('login') }}" class="p-2 -mr-2 text-gray-400 hover:text-white">
        <i data-lucide="log-in" class="w-6 h-6"></i>
    </a>
    @endauth
</header>


{{-- ==================================================================== --}}
{{-- 3. MOBILE BOTTOM NAVIGATION (Visible < md)                           --}}
{{-- ==================================================================== --}}
<nav class="md:hidden fixed bottom-0 left-0 w-full z-[60] bg-black/95 backdrop-blur-xl border-t border-gray-800 pb-safe shadow-[0_-10px_40px_rgba(0,0,0,0.5)]">
    <div class="grid grid-cols-4 h-16 items-center">
        
        <a href="{{ route('home') }}" class="flex flex-col items-center justify-center gap-1 group">
            <div class="{{ request()->routeIs('home') ? 'text-purple-500' : 'text-gray-500 group-hover:text-gray-300' }} transition-colors">
                <i data-lucide="home" class="w-6 h-6 {{ request()->routeIs('home') ? 'fill-current' : '' }}"></i>
            </div>
            <span class="text-[10px] font-medium {{ request()->routeIs('home') ? 'text-purple-500' : 'text-gray-500' }}">Home</span>
        </a>

        <a href="{{ route('explore.index') }}" class="flex flex-col items-center justify-center gap-1 group">
            <div class="{{ request()->routeIs('explore.*') ? 'text-purple-500' : 'text-gray-500 group-hover:text-gray-300' }} transition-colors">
                <i data-lucide="compass" class="w-6 h-6 {{ request()->routeIs('explore.*') ? 'fill-current' : '' }}"></i>
            </div>
            <span class="text-[10px] font-medium {{ request()->routeIs('explore.*') ? 'text-purple-500' : 'text-gray-500' }}">Explore</span>
        </a>

        {{-- Karena Library sudah pindah ke Header Atas, slot ini jadi Anime --}}
        <a href="{{ route('anime.index') }}" class="flex flex-col items-center justify-center gap-1 group">
            <div class="{{ request()->routeIs('anime.*') ? 'text-purple-500' : 'text-gray-500 group-hover:text-gray-300' }} transition-colors">
                <i data-lucide="tv" class="w-6 h-6"></i>
            </div>
            <span class="text-[10px] font-medium {{ request()->routeIs('anime.*') ? 'text-purple-500' : 'text-gray-500' }}">Anime</span>
        </a>

        <div class="relative flex flex-col items-center justify-center gap-1 group" x-data="{ open: false }">
            <button @click="open = !open" @click.away="open = false" class="flex flex-col items-center justify-center outline-none">
                <div class="{{ request()->routeIs('login') || request()->routeIs('admin.*') ? 'text-purple-500' : 'text-gray-500 group-hover:text-gray-300' }} transition-colors">
                    @auth
                        <div class="w-6 h-6 rounded-full bg-purple-600 flex items-center justify-center text-[10px] font-bold text-white ring-1 ring-white/20">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @else
                        <i data-lucide="user" class="w-6 h-6"></i>
                    @endauth
                </div>
                <span class="text-[10px] font-medium {{ request()->routeIs('login') ? 'text-purple-500' : 'text-gray-500' }}">Akun</span>
            </button>

            <div x-show="open" x-transition:enter="transition ease-out duration-200" style="display: none;" class="absolute bottom-full right-2 mb-3 w-48 bg-gray-900 border border-gray-700 rounded-xl shadow-2xl p-2 z-[70]">
                @auth
                    <div class="px-3 py-2 border-b border-gray-800 mb-1">
                        <p class="text-xs text-gray-400">Halo,</p>
                        <p class="text-sm font-bold text-white truncate">{{ Auth::user()->name }}</p>
                    </div>
                    @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-gray-300 hover:bg-gray-800 rounded-lg">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
                    </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-sm text-red-400 hover:bg-gray-800 rounded-lg text-left">
                            <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="flex items-center gap-2 px-3 py-2 text-sm font-bold text-white hover:bg-gray-800 rounded-lg">
                        <i data-lucide="log-in" class="w-4 h-4"></i> Masuk
                    </a>
                    <a href="{{ route('register') }}" class="flex items-center gap-2 px-3 py-2 text-sm font-bold text-purple-400 hover:bg-gray-800 rounded-lg">
                        <i data-lucide="user-plus" class="w-4 h-4"></i> Daftar
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>