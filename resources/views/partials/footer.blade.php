<footer class="bg-neutral-950 pt-16 pb-8 border-t border-white/5 relative overflow-hidden">
    
    <div class="absolute top-0 left-1/4 right-1/4 h-[1px] bg-gradient-to-r from-transparent via-purple-500/50 to-transparent"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 mb-16">
            
            <div class="lg:col-span-4 space-y-4">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    
                    {{-- LOGIKA LOGO PRIORITAS --}}
                    @if(isset($web_config['app_logo']) && $web_config['app_logo'])
                        {{-- 1. Cek Logo dari Database (Admin Settings) --}}
                        <img src="{{ asset('storage/' . $web_config['app_logo']) }}" 
                             alt="Logo" 
                             class="w-10 h-10 rounded-lg object-cover grayscale group-hover:grayscale-0 transition-all duration-300">
                    @else
                        {{-- 2. Cek Logo Statis (public/images/komikin-logo.png) --}}
                        <img src="{{ asset('images/komikin-logo.png') }}" 
                             alt="Logo" 
                             class="w-20 h-20 rounded-lg object-cover grayscale group-hover:grayscale-0 transition-all duration-300"
                             onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden'); this.nextElementSibling.classList.add('flex');">
                        
                        {{-- 3. Fallback Icon (Jika file gambar statis tidak ditemukan) --}}
                        <div class="hidden w-10 h-10 bg-purple-600 rounded-lg items-center justify-center shadow-lg shadow-purple-900/20">
                            <i data-lucide="zap" class="w-5 h-5 text-white"></i>
                        </div>
                    @endif
                </a>
                
                <p class="text-neutral-500 text-sm leading-relaxed pr-4">
                    {{ $web_config['app_description'] ?? 'Platform baca komik online terlengkap dengan update tercepat. Nikmati ribuan judul Manga, Manhwa, dan Manhua secara gratis dengan kualitas terbaik.' }}
                </p>

                <div class="flex items-center gap-4 pt-2">
                    <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-neutral-400 hover:bg-purple-600 hover:text-white transition-all duration-300 transform hover:-translate-y-1">
                        <i data-lucide="instagram" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-neutral-400 hover:bg-blue-500 hover:text-white transition-all duration-300 transform hover:-translate-y-1">
                        <i data-lucide="twitter" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-neutral-400 hover:bg-white hover:text-black transition-all duration-300 transform hover:-translate-y-1">
                        <i data-lucide="github" class="w-5 h-5"></i>
                    </a>
                </div>
            </div>

            <div class="lg:col-span-3">
                <h4 class="text-white font-bold mb-6 flex items-center gap-2">
                    <i data-lucide="compass" class="w-4 h-4 text-purple-500"></i> Jelajahi
                </h4>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('explore.index', ['type' => 'Manga']) }}" class="text-neutral-400 hover:text-purple-400 text-sm flex items-center gap-2 transition-colors group">
                            <span class="w-1.5 h-1.5 rounded-full bg-neutral-700 group-hover:bg-purple-500 transition-colors"></span>
                            Manga (Jepang)
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('explore.index', ['type' => 'Manhwa']) }}" class="text-neutral-400 hover:text-purple-400 text-sm flex items-center gap-2 transition-colors group">
                            <span class="w-1.5 h-1.5 rounded-full bg-neutral-700 group-hover:bg-purple-500 transition-colors"></span>
                            Manhwa (Korea)
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('explore.index', ['type' => 'Manhua']) }}" class="text-neutral-400 hover:text-purple-400 text-sm flex items-center gap-2 transition-colors group">
                            <span class="w-1.5 h-1.5 rounded-full bg-neutral-700 group-hover:bg-purple-500 transition-colors"></span>
                            Manhua (China)
                        </a>
                    </li>
                </ul>
            </div>

            <div class="lg:col-span-3">
                <h4 class="text-white font-bold mb-6 flex items-center gap-2">
                    <i data-lucide="link" class="w-4 h-4 text-purple-500"></i> Menu Utama
                </h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('home') }}" class="text-neutral-400 hover:text-white text-sm transition-colors block hover:translate-x-1 duration-200">Beranda</a></li>
                    <li><a href="{{ route('explore.index') }}" class="text-neutral-400 hover:text-white text-sm transition-colors block hover:translate-x-1 duration-200">Cari Komik</a></li>
                    @auth
                        <li><a href="{{ route('library.index') }}" class="text-neutral-400 hover:text-white text-sm transition-colors block hover:translate-x-1 duration-200">Library Saya</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="text-neutral-400 hover:text-white text-sm transition-colors block hover:translate-x-1 duration-200">Login / Daftar</a></li>
                    @endauth
                </ul>
            </div>

            <div class="lg:col-span-2">
                <h4 class="text-white font-bold mb-6 flex items-center gap-2">
                    <i data-lucide="info" class="w-4 h-4 text-purple-500"></i> Bantuan
                </h4>
                <ul class="space-y-3">
                    <li><a href="#" class="text-neutral-400 hover:text-white text-sm transition-colors block">DMCA</a></li>
                    <li><a href="#" class="text-neutral-400 hover:text-white text-sm transition-colors block">Privacy Policy</a></li>
                    <li><a href="#" class="text-neutral-400 hover:text-white text-sm transition-colors block">Terms of Service</a></li>
                </ul>
            </div>

        </div>

        <div class="pt-8 border-t border-white/5 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-neutral-500 text-xs text-center md:text-left">
                &copy; {{ date('Y') }} <span class="text-purple-500 font-bold">{{ $web_config['app_name'] ?? 'KOMIKIN' }}</span>. Semua Hak Cipta Dilindungi.
            </p>

            <p class="text-neutral-600 text-xs flex items-center gap-1">
                Dibuat dengan <i data-lucide="heart" class="w-3 h-3 text-red-500 fill-red-500"></i> menggunakan <span class="text-neutral-400 font-medium">Laravel</span>
            </p>
        </div>

    </div>
</footer>