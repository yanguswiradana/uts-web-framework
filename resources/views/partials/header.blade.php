<header class="bg-black shadow-2xl sticky top-0 z-50 border-b border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">

            <div class="flex items-center">
                <a href="/" class="flex items-center space-x-2">

                    <img src="/images/komikin-logo.png" alt="KOMIKIN Logo" class="h-8 w-auto">
                    <span class="text-3xl font-extrabold text-purple-500 hidden sm:inline">KOMIKIN</span>
                </a>
            </div>

            <nav class="hidden md:flex space-x-8 lg:space-x-12">
                <a href="/" class="text-white hover:text-purple-500 font-medium text-lg transition duration-200 border-b-2 border-transparent hover:border-purple-500 pb-1">Home</a>
                <a href="explore" class="text-gray-400 hover:text-purple-500 font-medium text-lg transition duration-200 border-b-2 border-transparent hover:border-purple-500 pb-1">Explore</a>
                <a href="library" class="text-gray-400 hover:text-purple-500 font-medium text-lg transition duration-200 border-b-2 border-transparent hover:border-purple-500 pb-1">Library</a>
            </nav>

            <div class="flex items-center space-x-4">

                <form class="hidden lg:block">
                    <div class="relative w-64">
                        <input type="search" name="q" placeholder="Search..."
                               class="w-full py-2 pl-10 pr-4 border border-gray-700 bg-gray-900 text-white rounded-full focus:ring-purple-500 focus:border-purple-500 text-sm transition duration-150" />
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>
                </form>

                <button class="flex items-center space-x-2 bg-purple-600 text-white py-2 px-4 rounded-full hover:bg-purple-700 transition duration-200 text-sm font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span class="hidden sm:inline">Profile / Masuk</span>
                </button>

                <button class="md:hidden p-2 rounded-lg hover:bg-gray-800 text-white">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <div class="lg:hidden bg-gray-900 py-3 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <form action="/search" method="GET">
                <div class="relative">
                    <input type="search" name="q" placeholder="Cari komik..."
                           class="w-full py-2 pl-10 pr-4 border border-gray-700 bg-gray-800 text-white rounded-full focus:ring-purple-500 focus:border-purple-500 text-sm" />
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
            </form>
        </div>
    </div>

</header>
