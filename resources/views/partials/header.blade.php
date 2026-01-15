<header x-data="{ mobileMenuOpen: false, profileDropdownOpen: false }" class="bg-black shadow-2xl sticky top-0 z-50 border-b border-gray-800">

    {{-- MAIN HEADER CONTAINER --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">

            {{-- 1. LOGO --}}
            <div class="flex items-center flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <img src="{{ asset('images/komikin-logo.png') }}" alt="KOMIKIN Logo" class="h-24 w-auto md:h-32"> 
                </a>
            </div>

            {{-- 2. DESKTOP NAVIGATION --}}
            <nav class="hidden md:flex space-x-8 lg:space-x-12">
                <a href="{{ route('home') }}"
                   class="text-white hover:text-purple-500 font-medium text-lg transition duration-200 border-b-2 pb-1 {{ request()->routeIs('home') ? 'border-purple-500 text-purple-500' : 'border-transparent text-gray-400' }}">
                   Home
                </a>
                <a href="{{ route('explore.index') }}"
                   class="text-white hover:text-purple-500 font-medium text-lg transition duration-200 border-b-2 pb-1 {{ request()->routeIs('explore.index') ? 'border-purple-500 text-purple-500' : 'border-transparent text-gray-400' }}">
                   Explore
                </a>
                <a href="{{ route('library.index') }}"
                   class="text-white hover:text-purple-500 font-medium text-lg transition duration-200 border-b-2 pb-1 {{ request()->routeIs('library.index') ? 'border-purple-500 text-purple-500' : 'border-transparent text-gray-400' }}">
                   Library
                </a>
            </nav>

            {{-- 3. RIGHT SECTION (Search & Profile) --}}
            <div class="flex items-center space-x-4">

                {{-- Desktop Search --}}
                <form action="{{ route('explore.index') }}" method="GET" class="hidden lg:block">
                    <div class="relative w-64">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
                               class="w-full py-2 pl-10 pr-4 border border-gray-700 bg-gray-900 text-white rounded-full focus:ring-purple-500 focus:border-purple-500 text-sm transition duration-150" />
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>
                </form>

                {{-- ==================================================== --}}
                {{-- LOGIC TOMBOL MASUK vs PROFIL (DESKTOP)             --}}
                {{-- ==================================================== --}}
                
                @guest
                    {{-- KONDISI 1: BELUM LOGIN (HEADER LAMA) --}}
                    {{-- Ini adalah kode tombol "Masuk" yang kamu punya sebelumnya --}}
                    <a href="{{ route('login') }}" class="hidden md:flex items-center space-x-2 bg-purple-600 text-white py-2 px-4 rounded-full hover:bg-purple-700 transition duration-200 text-sm font-semibold shadow-lg shadow-purple-500/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span>Masuk</span>
                    </a>
                @else
                    {{-- KONDISI 2: SUDAH LOGIN (TAMPILKAN AVATAR & LOGOUT) --}}
                    <div class="hidden md:relative md:block">
                        <button @click="profileDropdownOpen = !profileDropdownOpen" @click.away="profileDropdownOpen = false" class="flex items-center space-x-2 text-white hover:text-purple-400 focus:outline-none">
                            <div class="h-9 w-9 rounded-full bg-gradient-to-tr from-purple-500 to-indigo-500 flex items-center justify-center font-bold shadow-lg text-white">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="text-sm font-medium">{{ Str::limit(Auth::user()->name, 10) }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div x-show="profileDropdownOpen" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             class="absolute right-0 mt-2 w-48 bg-gray-900 border border-gray-700 rounded-xl shadow-xl py-1 z-50" 
                             style="display: none;">
                            
                             <div class="px-4 py-3 border-b border-gray-800">
                                <p class="text-sm text-white">Signed in as</p>
                                <p class="text-sm font-medium text-purple-400 truncate">{{ Auth::user()->email }}</p>
                             </div>

                             @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-800 hover:text-white">
                                    Dashboard Admin
                                </a>
                             @endif

                             {{-- TOMBOL LOGOUT --}}
                             <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-gray-800 hover:text-red-300">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest

                {{-- MOBILE HAMBURGER BUTTON --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="md:hidden p-2 rounded-lg text-gray-400 hover:text-white hover:bg-gray-800 focus:outline-none">
                    <svg x-show="!mobileMenuOpen" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    <svg x-show="mobileMenuOpen" x-cloak class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- 4. MOBILE MENU DROPDOWN --}}
    <div x-show="mobileMenuOpen"
         class="md:hidden bg-gray-900 border-t border-gray-800"
         x-cloak>

        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-purple-400 hover:bg-gray-800 {{ request()->routeIs('home') ? 'bg-gray-800 text-purple-400' : '' }}">Home</a>
            <a href="{{ route('explore.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-800 {{ request()->routeIs('explore.index') ? 'bg-gray-800 text-purple-400' : '' }}">Explore</a>
            <a href="{{ route('library.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-800 {{ request()->routeIs('library.index') ? 'bg-gray-800 text-purple-400' : '' }}">Library</a>
        </div>

        {{-- ==================================================== --}}
        {{-- LOGIC MOBILE (MASUK vs PROFIL)                     --}}
        {{-- ==================================================== --}}
        <div class="pt-4 pb-4 border-t border-gray-800">
            @guest
                {{-- JIKA BELUM LOGIN (MOBILE) --}}
                <div class="px-5">
                    <a href="{{ route('login') }}" class="block w-full text-center bg-purple-600 text-white px-4 py-3 rounded-lg font-bold hover:bg-purple-700 transition">
                        Masuk / Daftar
                    </a>
                </div>
            @else
                {{-- JIKA SUDAH LOGIN (MOBILE) --}}
                <div class="flex items-center px-5 mb-3">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-purple-600 flex items-center justify-center text-white font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium leading-none text-white">{{ Auth::user()->name }}</div>
                        <div class="text-sm font-medium leading-none text-gray-400 mt-1">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                
                <div class="px-2 space-y-1">
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-800">
                            Dashboard Admin
                        </a>
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-red-400 hover:text-red-300 hover:bg-gray-800">
                            Keluar
                        </button>
                    </form>
                </div>
            @endguest
        </div>
    </div>

    {{-- 5. MOBILE SEARCH BAR --}}
    <div class="lg:hidden bg-gray-900 py-3 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <form action="{{ route('explore.index') }}" method="GET">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari komik..."
                           class="w-full py-2 pl-10 pr-4 border border-gray-700 bg-gray-800 text-white rounded-full focus:ring-purple-500 focus:border-purple-500 text-sm" />
                </div>
            </form>
        </div>
    </div>

</header>