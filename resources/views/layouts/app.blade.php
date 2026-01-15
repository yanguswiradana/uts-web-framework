<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>@yield('title') - {{ $web_config['app_name'] ?? 'KOMIKIN' }}</title>

    <meta name="description" content="{{ $web_config['app_description'] ?? 'Platform Baca Komik Online Bahasa Indonesia Terupdate' }}">

    @if(isset($web_config['app_logo']) && $web_config['app_logo'])
        <link rel="shortcut icon" href="{{ asset('storage/' . $web_config['app_logo']) }}" type="image/x-icon">
    @else
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    @endif
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Custom Scrollbar Dark Mode */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #171717; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #404040; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #9333ea; }
        
        /* Hide Scrollbar for specific elements but allow scroll */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-neutral-950 text-white min-h-screen flex flex-col selection:bg-purple-500 selection:text-white">

    @include('partials.header')

    <main class="flex-1 pt-24 pb-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
        @yield('content')
    </main>

    @include('partials.footer')

    <script>
        // Initialize Icons
        lucide.createIcons();
    </script>
</body>
</html>