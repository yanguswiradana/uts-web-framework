@extends('layouts.admin')

@section('title', 'Edit Chapter')
@section('header_title', 'Edit Data Chapter')

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="{{ route('admin.chapters.index') }}" class="text-neutral-400 hover:text-white mb-6 inline-flex items-center gap-2 text-sm">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
    </a>

    <div class="bg-neutral-900 border border-white/5 rounded-2xl p-8 shadow-xl">
        
        <form action="{{ route('admin.chapters.update', $chapter->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <div class="mb-6">
                <label class="block text-sm font-bold text-neutral-300 mb-2">Pilih Komik</label>
                <div class="relative">
                    <select name="comic_id" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500 appearance-none">
                        @foreach($comics as $comic)
                            <option value="{{ $comic->id }}" {{ $chapter->comic_id == $comic->id ? 'selected' : '' }}>
                                {{ $comic->title }}
                            </option>
                        @endforeach
                    </select>
                    <i data-lucide="chevron-down" class="absolute right-4 top-3.5 w-5 h-5 text-neutral-500 pointer-events-none"></i>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">No. Chapter</label>
                    <input type="number" name="number" value="{{ old('number', $chapter->number) }}" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Judul Chapter</label>
                    <input type="text" name="title" value="{{ old('title', $chapter->title) }}" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500" required>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-neutral-300 mb-2">Slug URL</label>
                <input type="text" name="slug" value="{{ old('slug', $chapter->slug) }}" class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-blue-500" required>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-bold text-neutral-300 mb-2">Update Halaman Komik</label>
                
                @if($chapter->content_images)
                    <div class="mb-4 p-3 bg-blue-500/10 border border-blue-500/20 rounded-lg flex items-center gap-3">
                        <i data-lucide="info" class="w-5 h-5 text-blue-400"></i>
                        <p class="text-sm text-blue-300">
                            Saat ini ada <strong>{{ count($chapter->content_images) }}</strong> gambar halaman. 
                            Upload baru akan <strong>mengganti semua</strong> gambar lama.
                        </p>
                    </div>
                @endif

                <div class="border-2 border-dashed border-white/10 rounded-xl p-8 text-center bg-neutral-950 hover:bg-neutral-900 transition-colors relative group">
                    
                    <input type="file" name="content_images[]" id="images" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="previewFiles()">
                    
                    <div class="flex flex-col items-center justify-center group-hover:scale-105 transition-transform duration-300">
                        <div class="w-12 h-12 rounded-full bg-yellow-500/10 flex items-center justify-center mb-3 text-yellow-500">
                            <i data-lucide="folder-up" class="w-6 h-6"></i>
                        </div>
                        <p class="text-neutral-300 text-sm font-medium">Upload ulang untuk mengganti gambar</p>
                        <p class="text-neutral-600 text-xs mt-1">Kosongkan jika tidak ingin mengubah isi chapter</p>
                    </div>

                    <div id="file-count" class="mt-4 text-yellow-500 text-sm font-bold hidden bg-yellow-500/10 inline-block px-4 py-1 rounded-full border border-yellow-500/20">
                        0 file dipilih
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full bg-yellow-600 hover:bg-yellow-500 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-yellow-900/30 flex items-center justify-center gap-2">
                <i data-lucide="save" class="w-4 h-4"></i> Simpan Perubahan
            </button>
        </form>
    </div>
</div>

<script>
    function previewFiles() {
        const input = document.getElementById('images');
        const countBadge = document.getElementById('file-count');
        
        if(input.files && input.files.length > 0) {
            countBadge.classList.remove('hidden');
            countBadge.innerText = input.files.length + " halaman dipilih (akan mengganti yang lama)";
        } else {
            countBadge.classList.add('hidden');
        }
    }
</script>
@endsection