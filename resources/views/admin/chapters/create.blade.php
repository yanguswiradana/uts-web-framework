@extends('layouts.admin')

@section('title', 'Upload Chapter')
@section('header_title', 'Upload Chapter Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ route('admin.chapters.index') }}" class="text-neutral-400 hover:text-white mb-6 inline-flex items-center gap-2 text-sm">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
    </a>

    <div class="bg-neutral-900 border border-white/5 rounded-2xl p-8 shadow-xl">
        
        <form action="{{ route('admin.chapters.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-6">
                <label class="block text-sm font-bold text-neutral-300 mb-2">Pilih Komik</label>
                <div class="relative">
                    <select name="comic_id" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500 appearance-none">
                        @foreach($comics as $comic)
                            <option value="{{ $comic->id }}">{{ $comic->title }}</option>
                        @endforeach
                    </select>
                    <i data-lucide="chevron-down" class="absolute right-4 top-3.5 w-5 h-5 text-neutral-500 pointer-events-none"></i>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">No. Chapter</label>
                    <input type="number" name="number" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500" placeholder="100" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Judul Chapter</label>
                    <input type="text" name="title" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500" placeholder="The Beginning" required>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-neutral-300 mb-2">Slug URL</label>
                <input type="text" name="slug" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500" placeholder="ch-100" required>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-bold text-neutral-300 mb-2">Halaman Komik</label>
                <div class="border-2 border-dashed border-white/10 rounded-xl p-8 text-center bg-neutral-950 hover:bg-neutral-900 transition-colors relative group">
                    
                    <input type="file" name="content_images[]" id="images" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="previewFiles()">
                    
                    <div class="flex flex-col items-center justify-center group-hover:scale-105 transition-transform duration-300">
                        <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center mb-3 text-blue-400">
                            <i data-lucide="image-plus" class="w-6 h-6"></i>
                        </div>
                        <p class="text-neutral-300 text-sm font-medium">Klik atau seret gambar ke sini</p>
                        <p class="text-neutral-600 text-xs mt-1">Bisa pilih banyak gambar sekaligus (JPG, PNG)</p>
                    </div>

                    <div id="file-count" class="mt-4 text-blue-400 text-sm font-bold hidden bg-blue-500/10 inline-block px-4 py-1 rounded-full border border-blue-500/20">
                        0 file dipilih
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-blue-900/30 flex items-center justify-center gap-2">
                <i data-lucide="upload" class="w-4 h-4"></i> Upload Chapter
            </button>
        </form>
    </div>
</div>

<script>
    // Script sederhana untuk menghitung jumlah file yang dipilih
    function previewFiles() {
        const input = document.getElementById('images');
        const countBadge = document.getElementById('file-count');
        
        if(input.files && input.files.length > 0) {
            countBadge.classList.remove('hidden');
            countBadge.innerText = input.files.length + " halaman dipilih";
        } else {
            countBadge.classList.add('hidden');
        }
    }
</script>
@endsection