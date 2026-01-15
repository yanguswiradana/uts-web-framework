@extends('layouts.admin')

@section('title', 'Pengaturan Web')
@section('header_title', 'Pengaturan Website')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-neutral-900 border border-white/5 rounded-2xl p-8 shadow-xl">
        
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-8 text-center">
                <label class="block text-sm font-bold text-neutral-300 mb-4">Logo Website</label>
                
                <div class="relative w-32 h-32 mx-auto bg-neutral-950 rounded-full border-2 border-dashed border-white/20 flex items-center justify-center overflow-hidden group">
                    @if(isset($settings['app_logo']) && $settings['app_logo'])
                        <img src="{{ asset('storage/'.$settings['app_logo']) }}" class="w-full h-full object-cover">
                    @else
                        <i data-lucide="image" class="w-8 h-8 text-neutral-600"></i>
                    @endif

                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity cursor-pointer">
                        <i data-lucide="upload" class="w-6 h-6 text-white"></i>
                        <input type="file" name="app_logo" class="absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                </div>
                <p class="text-xs text-neutral-500 mt-2">Klik gambar untuk mengganti logo</p>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Nama Website</label>
                    <input type="text" name="app_name" value="{{ $settings['app_name'] ?? 'KOMIKIN' }}" 
                           class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Deskripsi Website (SEO)</label>
                    <textarea name="app_description" rows="3"
                              class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none">{{ $settings['app_description'] ?? '' }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-neutral-300 mb-2">Teks Footer</label>
                    <input type="text" name="footer_text" value="{{ $settings['footer_text'] ?? '' }}" 
                           class="w-full bg-neutral-950 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-purple-500 focus:outline-none">
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-white/5">
                <button type="submit" class="w-full bg-purple-600 hover:bg-purple-500 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-purple-900/20 flex items-center justify-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i> Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection