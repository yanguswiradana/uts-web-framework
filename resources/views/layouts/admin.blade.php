<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>@yield('title') - Admin {{ $web_config['app_name'] ?? 'Panel' }}</title>
    
    @if(isset($web_config['app_logo']) && $web_config['app_logo'])
        <link rel="shortcut icon" href="{{ asset('storage/' . $web_config['app_logo']) }}" type="image/x-icon">
    @endif

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Scrollbar Admin */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #171717; }
        ::-webkit-scrollbar-thumb { background: #404040; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #525252; }
    </style>
</head>
<body class="bg-neutral-950 text-neutral-200 selection:bg-purple-500/30" x-data="{ mobileMenu: false }">

    <div class="flex min-h-screen">
        
        <aside :class="mobileMenu ? 'translate-x-0' : '-translate-x-full md:translate-x-0'" 
               class="w-64 bg-neutral-900 border-r border-white/5 fixed h-full z-40 transition-transform duration-300 ease-in-out">
            
            <div class="h-20 flex items-center px-6 border-b border-white/5 gap-3">
                @if(isset($web_config['app_logo']) && $web_config['app_logo'])
                    <img src="{{ asset('storage/' . $web_config['app_logo']) }}" class="w-8 h-8 rounded-lg object-cover shadow-sm">
                @else
                    <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center">
                        <i data-lucide="zap" class="w-5 h-5 text-white"></i>
                    </div>
                @endif
                
                <div class="overflow-hidden">
                    <span class="block text-lg font-bold tracking-tight text-white truncate">
                        {{ $web_config['app_name'] ?? 'Komikin' }}
                    </span>
                    <span class="block text-[10px] text-neutral-500 font-medium uppercase tracking-wider">Admin Panel</span>
                </div>
                
                <button @click="mobileMenu = false" class="md:hidden ml-auto text-neutral-400">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <nav class="p-4 space-y-1 overflow-y-auto h-[calc(100vh-80px)] custom-scrollbar">
                
                <p class="px-4 text-[10px] font-bold text-neutral-500 uppercase tracking-wider mb-2 mt-4">Komik Zone</p>
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all mb-1 {{ request()->routeIs('admin.dashboard') ? 'bg-purple-600 text-white shadow-lg shadow-purple-900/20' : 'text-neutral-400 hover:bg-white/5 hover:text-white' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i> Dashboard
                </a>
                
                <a href="{{ route('admin.comics.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all mb-1 {{ request()->routeIs('admin.comics.*') ? 'bg-purple-600 text-white shadow-lg shadow-purple-900/20' : 'text-neutral-400 hover:bg-white/5 hover:text-white' }}">
                    <i data-lucide="book-open" class="w-5 h-5"></i> Data Komik
                </a>

                <a href="{{ route('admin.chapters.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all mb-1 {{ request()->routeIs('admin.chapters.*') ? 'bg-purple-600 text-white shadow-lg shadow-purple-900/20' : 'text-neutral-400 hover:bg-white/5 hover:text-white' }}">
                    <i data-lucide="file-text" class="w-5 h-5"></i> Chapter
                </a>

                <a href="{{ route('admin.genres.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all mb-1 {{ request()->routeIs('admin.genres.*') ? 'bg-purple-600 text-white shadow-lg shadow-purple-900/20' : 'text-neutral-400 hover:bg-white/5 hover:text-white' }}">
                    <i data-lucide="tags" class="w-5 h-5"></i> Genre
                </a>

                <p class="px-4 text-[10px] font-bold text-neutral-500 uppercase tracking-wider mb-2 mt-6">Anime Station</p>

                <a href="{{ route('admin.animes.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all mb-1 {{ request()->routeIs('admin.animes.*') ? 'bg-red-600 text-white shadow-lg shadow-red-900/20' : 'text-neutral-400 hover:bg-white/5 hover:text-white' }}">
                    <i data-lucide="tv" class="w-5 h-5"></i> Data Anime
                </a>

                <a href="{{ route('admin.anime_episodes.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all mb-1 {{ request()->routeIs('admin.anime_episodes.*') ? 'bg-red-600 text-white shadow-lg shadow-red-900/20' : 'text-neutral-400 hover:bg-white/5 hover:text-white' }}">
                    <i data-lucide="play-circle" class="w-5 h-5"></i> Episode Anime
                </a>

                <p class="px-4 text-[10px] font-bold text-neutral-500 uppercase tracking-wider mb-2 mt-6">Sistem</p>

                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all mb-1 {{ request()->routeIs('admin.users.*') ? 'bg-neutral-800 text-white border border-white/5' : 'text-neutral-400 hover:bg-white/5 hover:text-white' }}">
                    <i data-lucide="users" class="w-5 h-5"></i> Pengguna
                </a>

                <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all mb-1 {{ request()->routeIs('admin.settings.*') ? 'bg-neutral-800 text-white border border-white/5' : 'text-neutral-400 hover:bg-white/5 hover:text-white' }}">
                    <i data-lucide="settings" class="w-5 h-5"></i> Pengaturan
                </a>

                <form action="{{ route('logout') }}" method="POST" class="mt-8 mb-4">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-all text-sm font-medium border border-transparent hover:border-red-500/20">
                        <i data-lucide="log-out" class="w-5 h-5"></i> Logout
                    </button>
                </form>
            </nav>
        </aside>

        <div x-show="mobileMenu" @click="mobileMenu = false" class="fixed inset-0 bg-black/50 z-30 md:hidden backdrop-blur-sm"></div>

        <div class="flex-1 md:ml-64 min-h-screen flex flex-col relative w-full">
            
            <header class="md:hidden bg-neutral-900 border-b border-white/5 p-4 flex items-center justify-between sticky top-0 z-20 shadow-lg">
                <div class="flex items-center gap-2">
                    @if(isset($web_config['app_logo']) && $web_config['app_logo'])
                        <img src="{{ asset('storage/' . $web_config['app_logo']) }}" class="w-8 h-8 rounded object-cover">
                    @endif
                    <span class="font-bold text-white tracking-tight">{{ $web_config['app_name'] ?? 'Admin Panel' }}</span>
                </div>
                <button @click="mobileMenu = !mobileMenu" class="text-neutral-400 hover:text-white transition-colors">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
            </header>

            <main class="p-4 md:p-10 max-w-7xl w-full mx-auto flex-1">
                <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-white tracking-tight">@yield('header_title', 'Dashboard')</h1>
                        <p class="text-neutral-500 text-sm mt-1">Selamat datang kembali, {{ Auth::user()->name ?? 'Admin' }}</p>
                    </div>
                    
                    <div class="text-xs text-neutral-500 bg-neutral-900 border border-white/5 px-3 py-1.5 rounded-lg">
                        {{ now()->format('l, d F Y') }}
                    </div>
                </div>

                @yield('content')
            </main>

            <footer class="border-t border-white/5 p-6 text-center text-xs text-neutral-600">
                &copy; {{ date('Y') }} {{ $web_config['footer_text'] ?? 'Komikin Project' }}. All rights reserved.
            </footer>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Popup Sukses
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                background: '#171717', color: '#fff', confirmButtonColor: '#9333ea',
                timer: 3000, timerProgressBar: true
            });
        @endif

        // Popup Error
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                background: '#171717', color: '#fff', confirmButtonColor: '#ef4444'
            });
        @endif

        // Fungsi Global Confirm Delete (Dipakai di tombol hapus)
        // Cara pakai: form action="..." id="delete-form-1" ... onclick="confirmDelete(1)"
        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Data?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                background: '#171717', color: '#fff',
                showCancelButton: true,
                confirmButtonColor: '#ef4444', cancelButtonColor: '#404040',
                confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Cari form berdasarkan ID dan submit
                    let form = document.getElementById('delete-form-' + id);
                    if(form) form.submit();
                }
            })
        }
    </script>

</body>
</html>