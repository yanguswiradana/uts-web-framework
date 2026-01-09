@extends('layouts.app')

@section('title', 'Tambah Komik - KOMIKIN')

@section('content')
<nav class="bg-[#1f1f1f] border-b border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-purple-500 font-bold text-xl hover:text-purple-400 transition">
                    ADMIN KOMIKIN
                </a>
            </div>
            <div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white">Tambah Komik Baru</h1>
            <p class="text-gray-400 mt-2 text-sm">Isi form di bawah untuk mengupload komik.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center text-gray-400 hover:text-white transition">
            Kembali
        </a>
    </div>

    <div class="bg-[#1f1f1f] rounded-2xl shadow-xl border border-gray-800 overflow-hidden p-8">
        
        <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Judul --}}
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Judul Komik</label>
                <input type="text" name="title" required
                    class="w-full bg-gray-900 border border-gray-700 rounded-lg py-3 px-4 text-white focus:outline-none focus:border-purple-500 transition"
                    placeholder="Contoh: One Piece">
            </div>

            {{-- Penulis --}}
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Penulis</label>
                <input type="text" name="author"
                    class="w-full bg-gray-900 border border-gray-700 rounded-lg py-3 px-4 text-white focus:outline-none focus:border-purple-500 transition">
            </div>

            {{-- AREA UPLOAD DENGAN DRAG & DROP YANG SUDAH DIPERBAIKI --}}
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Cover Komik</label>
                
                {{-- Container Dropzone --}}
                <div class="flex items-center justify-center w-full">
                    <label id="dropzone-label" for="file-upload" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-700 border-dashed rounded-lg cursor-pointer bg-gray-900 hover:bg-gray-800 transition relative overflow-hidden">
                        
                        {{-- Tampilan Default (Sebelum ada file) --}}
                        <div id="default-view" class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-10 h-10 mb-4 text-gray-400" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-400"><span class="font-semibold text-purple-500">Klik upload</span> atau drag & drop</p>
                            <p class="text-xs text-gray-500">PNG, JPG or JPEG (Max. 2MB)</p>
                        </div>

                        {{-- Tampilan Preview (Setelah ada file) --}}
                        <div id="preview-view" class="hidden absolute inset-0 w-full h-full flex flex-col items-center justify-center bg-gray-900 z-10">
                            <img id="image-preview" src="#" alt="Preview" class="h-48 object-contain mb-2 rounded">
                            <p id="file-name" class="text-sm text-purple-400 font-medium"></p>
                            <p class="text-xs text-gray-500 mt-1">Klik untuk ganti gambar</p>
                        </div>

                        {{-- Input File Asli --}}
                        {{-- accept="image/*" memaksa browser hanya menerima gambar --}}
                        <input id="file-upload" name="image" type="file" class="hidden" accept="image/png, image/jpeg, image/jpg" required />
                    </label>
                </div>
                @error('image')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Sinopsis</label>
                <textarea name="description" rows="4"
                    class="w-full bg-gray-900 border border-gray-700 rounded-lg py-3 px-4 text-white focus:outline-none focus:border-purple-500 transition"></textarea>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition">
                    Simpan Komik
                </button>
            </div>
        </form>
    </div>
</div>

{{-- SCRIPT JAVASCRIPT UNTUK MENANGANI DRAG & DROP --}}
<script>
    const dropzoneLabel = document.getElementById('dropzone-label');
    const fileInput = document.getElementById('file-upload');
    const defaultView = document.getElementById('default-view');
    const previewView = document.getElementById('preview-view');
    const imagePreview = document.getElementById('image-preview');
    const fileName = document.getElementById('file-name');

    // Mencegah browser membuka file saat didrop di luar area
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropzoneLabel.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    // Efek visual saat file ditarik ke area (Highlight border)
    ['dragenter', 'dragover'].forEach(eventName => {
        dropzoneLabel.addEventListener(eventName, () => {
            dropzoneLabel.classList.add('border-purple-500');
            dropzoneLabel.classList.add('bg-gray-800');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropzoneLabel.addEventListener(eventName, () => {
            dropzoneLabel.classList.remove('border-purple-500');
            dropzoneLabel.classList.remove('bg-gray-800');
        }, false);
    });

    // Saat file "dijatuhkan" (Dropped)
    dropzoneLabel.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        // Masukkan file yang didrop ke dalam input file HTML
        fileInput.files = files;
        
        handleFiles(files);
    }

    // Saat file dipilih lewat klik biasa
    fileInput.addEventListener('change', function() {
        handleFiles(this.files);
    });

    // Fungsi menampilkan preview
    function handleFiles(files) {
        if (files && files[0]) {
            const file = files[0];
            
            // Cek apakah file adalah gambar
            if (!file.type.startsWith('image/')) {
                alert('Mohon upload file gambar (JPG/PNG)!');
                return;
            }

            const reader = new FileReader();
            
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                fileName.textContent = file.name;
                
                // Toggle tampilan
                defaultView.classList.add('hidden');
                previewView.classList.remove('hidden');
            }
            
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection