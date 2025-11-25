<header x-data="{ mobileMenuOpen: false }" class="bg-black shadow-2xl sticky top-0 z-50 border-b border-gray-800">

    {{-- MAIN HEADER CONTAINER --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">

            {{-- 1. LOGO (DIKEMBALIKAN SEPERTI SEMULA) --}}
            <div class="flex items-center flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    {{-- Class saya hapus, atribut height/width dikembalikan --}}
                    <img src="{{ asset('images/komikin-logo.png') }}" alt="KOMIKIN Logo" height="150px" width="150px">
                </a>
            </div>

            {{-- 2. DESKTOP NAVIGATION (Hidden on Mobile) --}}
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

                {{-- Desktop Profile Button --}}
                <button class="hidden md:flex items-center space-x-2 bg-purple-600 text-white py-2 px-4 rounded-full hover:bg-purple-700 transition duration-200 text-sm font-semibold shadow-lg shadow-purple-500/30">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span>Masuk</span>
                </button>

                {{-- MOBILE HAMBURGER BUTTON (Visible only on Mobile) --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="md:hidden p-2 rounded-lg text-gray-400 hover:text-white hover:bg-gray-800 focus:outline-none">
                    {{-- Icon Menu (Hamburger) --}}
                    <svg x-show="!mobileMenuOpen" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    {{-- Icon Close (X) --}}
                    <svg x-show="mobileMenuOpen" x-cloak class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- 4. MOBILE MENU DROPDOWN (Shown via AlpineJS) --}}
    <div x-show="mobileMenuOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden bg-gray-900 border-t border-gray-800"
         x-cloak>

        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-purple-400 hover:bg-gray-800 {{ request()->routeIs('home') ? 'bg-gray-800 text-purple-400' : '' }}">Home</a>
            <a href="{{ route('explore.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-800 {{ request()->routeIs('explore.index') ? 'bg-gray-800 text-purple-400' : '' }}">Explore</a>
            <a href="{{ route('library.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-800 {{ request()->routeIs('library.index') ? 'bg-gray-800 text-purple-400' : '' }}">Library</a>
        </div>

        {{-- Mobile Profile Section --}}
        <div class="pt-4 pb-4 border-t border-gray-800">
            <div class="flex items-center px-5">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 rounded-full bg-purple-600 flex items-center justify-center text-white font-bold">
                        G
                    </div>
                </div>
                <div class="ml-3">
                    <div class="text-base font-medium leading-none text-white">Guest User</div>
                    <div class="text-sm font-medium leading-none text-gray-400 mt-1">guest@example.com</div>
                </div>
                <button class="ml-auto bg-gray-800 flex-shrink-0 p-1 rounded-full text-gray-400 hover:text-white">
                    <span class="sr-only">View notifications</span>
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- 5. MOBILE SEARCH BAR (Always visible on mobile below header) --}}
    <div class="lg:hidden bg-gray-900 py-3 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <form action="{{ route('explore.index') }}" method="GET">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari komik..."
                           class="w-full py-2 pl-10 pr-4 border border-gray-700 bg-gray-800 text-white rounded-full focus:ring-purple-500 focus:border-purple-500 text-sm" />
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
            </form>
        </div>
    </div>

</header>
