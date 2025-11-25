@extends('layouts.app')

@section('title', 'Explore Komik - KOMIKIN')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <h1 class="text-4xl font-extrabold text-white mb-8 border-b border-purple-500 pb-3">Explore Komik Terbaru</h1>

    <div class="flex flex-col lg:flex-row gap-8">

        <aside class="w-full lg:w-1/4 p-6 bg-gray-800 rounded-lg shadow-xl border border-gray-700 hidden lg:block">
            <h3 class="text-xl font-bold text-white mb-4 border-b border-gray-700 pb-2">Filter</h3>

            <div class="mb-6">
                <label class="block text-gray-200 font-semibold mb-2">Genre</label>
                <div class="grid grid-cols-2 gap-2 text-sm">
                    @php
                        $genres = ['Action', 'Fantasy', 'Romance', 'Comedy', 'Horror', 'Slice of Life'];
                    @endphp
                    @foreach ($genres as $genre)
                        <label class="flex items-center text-gray-400 hover:text-purple-400 cursor-pointer">
                            <input type="checkbox" class="form-checkbox h-4 w-4 text-purple-600 bg-gray-900 border-gray-600 rounded mr-2 focus:ring-purple-500">
                            {{ $genre }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-200 font-semibold mb-2">Status</label>
                <select class="w-full p-2 bg-gray-900 border border-gray-700 text-gray-200 rounded-lg focus:border-purple-500 focus:ring-purple-500">
                    <option class="bg-gray-800">Semua</option>
                    <option class="bg-gray-800">Ongoing</option>
                    <option class="bg-gray-800">Completed</option>
                </select>
            </div>

            <button class="w-full bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700 font-semibold transition duration-150">
                Terapkan Filter
            </button>
        </aside>

        <div class="w-full lg:w-3/4">

            <div class="flex justify-between items-center mb-6 p-4 bg-gray-800 rounded-lg border border-gray-700">
                <p class="text-gray-400 text-sm sm:text-base">Menampilkan **1 - 24** dari **5.000** Komik</p>
                <select class="p-2 bg-gray-900 border border-gray-700 text-gray-200 rounded-lg text-sm focus:border-purple-500 focus:ring-purple-500">
                    <option class="bg-gray-800">Terbaru</option>
                    <option class="bg-gray-800">Populer (All Time)</option>
                    <option class="bg-gray-800">Terbanyak Dibaca</option>
                    <option class="bg-gray-800">A-Z</option>
                </select>
            </div>

            <div class="grid
                 grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5
                 gap-4 sm:gap-6">

                @for ($i = 0; $i < 20; $i++)
                <div class="bg-gray-800 rounded-lg shadow-xl overflow-hidden transition transform hover:scale-[1.03] duration-300 comic-card border border-gray-700">
                    <img src="https://via.placeholder.com/150x225/1f2937/FFFFFF?text=EXPLORE+{{$i+1}}" alt="Cover Komik" class="w-full">
                    <div class="p-3">
                        <h3 class="font-semibold text-white truncate text-base">Judul Eksplorasi {{$i+1}}</h3>
                        <p class="text-sm text-purple-400">Chapter: 99 | Action</p>
                    </div>
                </div>
                @endfor
            </div>

            <div class="flex justify-center items-center space-x-2 mt-10">
                <a href="#" class="py-2 px-3 border border-gray-700 rounded-lg text-gray-400 hover:bg-gray-800 transition duration-150 text-sm">
                    &laquo; Prev
                </a>
                <a href="#" class="py-2 px-4 border border-purple-500 rounded-lg bg-purple-600 text-white font-bold text-sm">1</a>
                <a href="#" class="py-2 px-4 border border-gray-700 rounded-lg bg-gray-800 hover:bg-gray-700 text-gray-200 text-sm">2</a>
                <span class="py-2 px-4 text-gray-500 text-sm">...</span>
                <a href="#" class="py-2 px-3 border border-gray-700 rounded-lg text-gray-400 hover:bg-gray-800 transition duration-150 text-sm">
                    Next &raquo;
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
