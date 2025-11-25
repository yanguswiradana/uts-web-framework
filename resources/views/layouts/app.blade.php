<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KOMIKIN - Baca Komik Online')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* Gaya Sederhana untuk Card Komik (Disarankan memiliki bayangan gelap) */
        .comic-card img {
            width: 100%;
            height: auto;
            object-fit: cover;
            aspect-ratio: 3 / 4;
            border-radius: 0.5rem 0.5rem 0 0;
        }
    </style>
</head>
<body class="bg-gray-900 font-sans text-gray-200">

    @include('partials.header')

    <main class="min-h-screen pb-10">
        @yield('content')
    </main>

    @include('partials.footer')

</body>
</html>
