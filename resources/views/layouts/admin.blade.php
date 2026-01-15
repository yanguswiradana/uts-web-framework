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
<body class="bg-neutral-950 text-neutral-200 selection:bg-purple-500/30">

    <div class="flex min-h-screen">
        
        <aside class="w-64 bg-neutral-900 border-r border-white/5 fixed h-full z-20 hidden md:block">
            <div class="h-20 flex items-center px-6 border-b border-white/5 gap-3">
                @if(isset($web_config['app_logo']) && $web_config['app_logo'])
                    <img src="{{ asset('storage/' . $web_config['app_logo']) }}" class="w-8 h-8 rounded-lg object-cover shadow-sm">
                @else
                    <i data-lucide="zap" class="w-6 h-6 text-purple-500"></i>
                @endif
                
                <div class="overflow-hidden">
                    <span class="block text-lg font-bold tracking-tight text-white truncate">
                        {{ $web_config['app_name'] ?? 'Komikin' }}
                    </span>
                    <span class="block text-[10px] text-neutral-500 font-medium uppercase tracking-wider">Admin Panel</span>
                </div>
            </div>

            <nav class="p-4 space-y-2 overflow-y-auto h-[calc(100vh-80px)] custom-scrollbar">
                <p class="px-4 text-[10px] font-bold text-neutral-500 uppercase tracking-wider mb-2 mt-4">Menu Utama</p>
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-purple-600 text-white shadow-lg shadow-purple-900/20' : 'text-neutral-400 hover:bg-white/5 hover:text-white' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i> Dashboard
                </a>
                
                <a href="{{ route('admin.comics.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.comics.*') ? 'bg-purple-600 text-white shadow-lg shadow-purple-900/20' : 'text-neutral-400 hover:bg-white/5 hover:text-white' }}">
                    <i data-lucide="book-open" class="w-5 h-5"></i> Data Komik
                </a>

                <a href="{{ route('admin.chapters.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.chapters.*') ? 'bg-purple-600 text-white shadow-lg shadow-purple-900/20' : 'text-neutral-400 hover:bg-white/5 hover:text-white' }}">
                    <i data-lucide="file-text" class="w-5 h-5"></i> Chapter
                </a>

                <a href="{{ route('admin.genres.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.genres.*') ? 'bg-purple-600 text-white shadow-lg shadow-purple-900/20' : 'text-neutral-400 hover:bg-white/5 hover:text-white' }}">
                    <i data-lucide="tags" class="w-5 h-5"></i> Genre
                </a>

                <p class="px-4 text-[10px] font-bold text-neutral-500 uppercase tracking-wider mb-2 mt-6">Sistem</p>

                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.users.*') ? 'bg-purple-600 text-white shadow-lg shadow-purple-900/20' : 'text-neutral-400 hover:bg-white/5 hover:text-white' }}">
                    <i data-lucide="users" class="w-5 h-5"></i> Pengguna
                </a>

                <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.settings.*') ? 'bg-purple-600 text-white shadow-lg shadow-purple-900/20' : 'text-neutral-400 hover:bg-white/5 hover:text-white' }}">
                    <i data-lucide="settings" class="w-5 h-5"></i> Pengaturan
                </a>

                <form action="{{ route('logout') }}" method="POST" class="mt-8">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-all text-sm font-medium">
                        <i data-lucide="log-out" class="w-5 h-5"></i> Logout
                    </button>
                </form>
            </nav>
        </aside>

        <div class="flex-1 md:ml-64 min-h-screen flex flex-col relative">
            
            <header class="md:hidden bg-neutral-900 border-b border-white/5 p-4 flex items-center justify-between sticky top-0 z-30 shadow-lg">
                <div class="flex items-center gap-2">
                    @if(isset($web_config['app_logo']) && $web_config['app_logo'])
                        <img src="{{ asset('storage/' . $web_config['app_logo']) }}" class="w-6 h-6 rounded object-cover">
                    @endif
                    <span class="font-bold text-white">{{ $web_config['app_name'] ?? 'Admin Panel' }}</span>
                </div>
                <button class="text-neutral-400"><i data-lucide="menu" class="w-6 h-6"></i></button>
            </header>

            <main class="p-6 md:p-10 max-w-7xl w-full mx-auto flex-1">
                <div class="mb-8">
                    <h1 class="text-2xl md:text-3xl font-bold text-white mb-2 tracking-tight">@yield('header_title', 'Dashboard')</h1>
                </div>

                @yield('content')
            </main>

            <footer class="border-t border-white/5 p-6 text-center text-xs text-neutral-600">
                &copy; {{ date('Y') }} {{ $web_config['footer_text'] ?? 'Komikin Project' }}.
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

        // Fungsi Global Confirm Delete
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
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>

</body>
</html>