// resources/views/components/category.blade.php

<div class="container mx-auto px-4 mt-8">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">🔥 Pilih Genre Komik</h2>

    <div id="category-buttons" class="flex space-x-4 border-b border-gray-200 mb-6">
        <button data-category="manga" class="category-btn py-2 px-4 text-lg font-semibold text-red-600 border-b-2 border-red-600 focus:outline-none">
            Manga 🇯🇵
        </button>
        <button data-category="manhua" class="category-btn py-2 px-4 text-lg text-gray-500 hover:text-red-600 focus:outline-none">
            Manhua 🇨🇳
        </button>
        <button data-category="manhwa" class="category-btn py-2 px-4 text-lg text-gray-500 hover:text-red-600 focus:outline-none">
            Manhwa 🇰🇷
        </button>
    </div>

    <div id="comic-panel" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
        @for ($i = 0; $i < 6; $i++)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden transition transform hover:scale-105 duration-300">

            <div class="p-3">
                <h3 class="font-semibold text-gray-800 truncate">Nama Komik {{$i+1}}</h3>
                <p class="text-sm text-red-600">Chapter Terakhir: 120</p>
            </div>
        </div>
        @endfor
    </div>
    </div>
