<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Komikin Admin')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #0a0a0a; }
        ::-webkit-scrollbar-thumb { background: #262626; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #9333ea; }
    </style>
</head>
<body class="bg-neutral-950 text-white flex h-screen overflow-hidden selection:bg-purple-500 selection:text-white">

    <aside class="w-72 bg-neutral-900 border-r border-white/5 flex flex-col justify-between hidden md:flex z-20 shadow-2xl">
        <div>
            <div class="h-24 flex items-center px-8 border-b border-white/5">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-purple-900/20 group-hover:scale-105 transition-transform">
                        <i data-lucide="zap" class="w-6 h-6 text-white fill-white"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold tracking-tight leading-none">Komik<span class="text-purple-500">in</span></h1>
                        <span class="text-[10px] text-neutral-500 font-medium uppercase tracking-widest">Admin Panel</span>
                    </div>
                </a>
            </div>

            <nav class="mt-8 px-4 space-y-1.5 overflow-y-auto max-h-[calc(100vh-200px)] custom-scrollbar">
                
                <div class="px-4 text-[10px] font-bold text-neutral-500 uppercase tracking-widest mb-2 mt-2">Utama</div>
                
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-purple-600/10 text-purple-400 border border-purple-600/20' : 'text-neutral-400 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    Dashboard
                </a>

                <div class="px-4 text-[10px] font-bold text-neutral-500 uppercase tracking-widest mb-2 mt-6">Manajemen Konten</div>
                
                <a href="{{ route('admin.comics.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('admin.comics*') ? 'bg-purple-600/10 text-purple-400 border border-purple-600/20' : 'text-neutral-400 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="book-open" class="w-5 h-5 {{ request()->routeIs('admin.comics*') ? '' : 'group-hover:text-purple-400' }} transition-colors"></i>
                    <span>Data Komik</span>
                </a>

                <a href="{{ route('admin.chapters.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('admin.chapters*') ? 'bg-purple-600/10 text-purple-400 border border-purple-600/20' : 'text-neutral-400 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="file-stack" class="w-5 h-5 {{ request()->routeIs('admin.chapters*') ? '' : 'group-hover:text-purple-400' }} transition-colors"></i>
                    <span>Chapter & Rilis</span>
                </a>

                <a href="{{ route('admin.genres.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('admin.genres*') ? 'bg-purple-600/10 text-purple-400 border border-purple-600/20' : 'text-neutral-400 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="tags" class="w-5 h-5 {{ request()->routeIs('admin.genres*') ? '' : 'group-hover:text-purple-400' }} transition-colors"></i>
                    <span>Genre</span>
                </a>

                <div class="px-4 text-[10px] font-bold text-neutral-500 uppercase tracking-widest mb-2 mt-6">Sistem & User</div>
                
                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('admin.users*') ? 'bg-purple-600/10 text-purple-400 border border-purple-600/20' : 'text-neutral-400 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="users" class="w-5 h-5 {{ request()->routeIs('admin.users*') ? '' : 'group-hover:text-purple-400' }} transition-colors"></i>
                    <span>Pengguna</span>
                </a>

                <a href="{{ route('admin.settings') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('admin.settings*') ? 'bg-purple-600/10 text-purple-400 border border-purple-600/20' : 'text-neutral-400 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="settings" class="w-5 h-5 {{ request()->routeIs('admin.settings*') ? '' : 'group-hover:text-purple-400' }} transition-colors"></i>
                    <span>Pengaturan Web</span>
                </a>
            </nav>
        </div>

        <div class="p-4 border-t border-white/5 bg-neutral-900/50">
            <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/5 transition-colors cursor-pointer border border-transparent hover:border-white/5">
                <div class="w-9 h-9 rounded-full bg-purple-600 flex items-center justify-center font-bold text-sm shadow-md">
                   {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold truncate text-white">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <p class="text-xs text-neutral-500 truncate">Administrator</p>
                </div>
                
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="p-2 text-neutral-400 hover:text-red-400 transition-colors" title="Logout">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <main class="flex-1 flex flex-col overflow-hidden relative bg-neutral-950">
        
        <header class="h-20 border-b border-white/5 flex items-center justify-between px-8 bg-neutral-950/80 backdrop-blur-xl sticky top-0 z-30">
            <div class="md:hidden font-bold text-xl flex items-center gap-2">
                <i data-lucide="zap" class="w-5 h-5 text-purple-500 fill-purple-500"></i> Komik<span class="text-purple-500">in</span>
            </div>
            
            <h2 class="hidden md:block text-lg font-semibold text-white">@yield('header_title', 'Dashboard')</h2>

            <div class="flex items-center gap-3 ml-4">
                <button class="relative p-2.5 text-neutral-400 hover:text-white hover:bg-white/5 rounded-full transition-colors">
                    <i data-lucide="bell" class="w-5 h-5"></i>
                </button>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-6 md:p-8 relative scroll-smooth">
            <div class="absolute top-0 left-0 w-full h-[600px] bg-purple-900/10 blur-[150px] -z-10 pointer-events-none"></div>
            
            @yield('content')

            <div class="mt-12 mb-4 text-center">
                <p class="text-xs text-neutral-600">&copy; {{ date('Y') }} Komikin Admin Panel • Built with Laravel</p>
            </div>
        </div>
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>