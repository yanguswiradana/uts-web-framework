@extends('layouts.admin')

@section('title', 'Edit Chapter')
@section('header_title', 'Edit Data Chapter')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-neutral-900 border border-white/5 rounded-2xl p-8 shadow-xl">
        
        <form action="{{ route('admin.chapters.update', $chapter->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-bold text-neutral-300 mb-2">Pilih Komik <span class="text-red-500">*</span></label>
                <select name="comic_id" required class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none">
                    @foreach($comics as $comic)
                        <option value="{{ $comic->id }}" {{ $chapter->comic_id == $comic->id ? 'selected' : '' }}>
                            {{ $comic->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Nomor Chapter <span class="text-red-500">*</span></label>
                    <input type="number" name="number" value="{{ old('number', $chapter->number) }}" step="0.1" required
                           class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Judul Chapter <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $chapter->title) }}" required 
                           class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-neutral-300 mb-2">Slug URL</label>
                <input type="text" name="slug" value="{{ old('slug', $chapter->slug) }}" 
                       class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-bold text-neutral-300 mb-2">Ganti Gambar Konten</label>
                
                <div class="relative border-2 border-dashed border-white/10 rounded-xl p-8 text-center hover:border-blue-500/50 hover:bg-blue-500/5 transition-all group cursor-pointer" id="dropZone">
                    
                    <input type="file" id="imageInput" name="content_images[]" multiple accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    
                    <div class="flex flex-col items-center justify-center pointer-events-none" id="uploadPlaceholder">
                        <i data-lucide="refresh-cw" class="w-6 h-6 text-neutral-400 mb-2 group-hover:text-white"></i>
                        <p class="text-sm font-medium text-neutral-300">Klik untuk mengganti gambar</p>
                        <p class="text-xs text-neutral-500 mt-1">Biarkan kosong jika tidak ingin mengubah.</p>
                    </div>

                    <div id="previewContainer" class="hidden grid grid-cols-3 sm:grid-cols-5 gap-2 mt-4 pointer-events-none"></div>
                    <p id="fileCountText" class="hidden text-sm text-green-400 font-bold mt-4 pointer-events-none"></p>

                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-6 border-t border-white/5">
                <a href="{{ route('admin.chapters.index') }}" class="px-6 py-2.5 rounded-xl text-neutral-400 hover:text-white font-bold transition-colors">Batal</a>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-2.5 rounded-xl font-bold shadow-lg shadow-purple-900/20 transition-all flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    const imageInput = document.getElementById('imageInput');
    const previewContainer = document.getElementById('previewContainer');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const fileCountText = document.getElementById('fileCountText');
    const dropZone = document.getElementById('dropZone');

    imageInput.addEventListener('change', function() {
        previewContainer.innerHTML = '';
        const files = this.files;
        
        if (files.length > 0) {
            uploadPlaceholder.classList.add('hidden');
            previewContainer.classList.remove('hidden');
            fileCountText.classList.remove('hidden');
            dropZone.classList.add('border-green-500/50', 'bg-green-500/5');

            fileCountText.textContent = `✅ ${files.length} Gambar Baru Dipilih`;

            Array.from(files).slice(0, 10).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgDiv = document.createElement('div');
                    imgDiv.className = 'aspect-[2/3] rounded-lg overflow-hidden border border-white/10 shadow-sm relative';
                    imgDiv.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                    previewContainer.appendChild(imgDiv);
                }
                reader.readAsDataURL(file);
            });
             if (files.length > 10) {
                const moreDiv = document.createElement('div');
                moreDiv.className = 'aspect-[2/3] rounded-lg bg-neutral-800 flex items-center justify-center border border-white/10';
                moreDiv.innerHTML = `<span class="text-xs text-neutral-400">+${files.length - 10}</span>`;
                previewContainer.appendChild(moreDiv);
            }
        } else {
            uploadPlaceholder.classList.remove('hidden');
            previewContainer.classList.add('hidden');
            fileCountText.classList.add('hidden');
            dropZone.classList.remove('border-green-500/50', 'bg-green-500/5');
        }
    });
</script>
@endsection