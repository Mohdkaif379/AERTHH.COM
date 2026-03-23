@extends('layout.app')

@section('title', 'Create Banner')
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl border border-cyan-100/50 shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-cyan-50 to-emerald-50 border-b border-cyan-100/50">
            <h3 class="text-sm font-semibold text-gray-700">Add New Banner</h3>
        </div>

        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf
            
            {{-- Banner Title --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">
                    Banner Title
                </label>
                <input type="text" 
                       name="banner_type"
                       value="{{ old('banner_type') }}"
                       placeholder="Home Hero, Sidebar Offer, Campaign name"
                       class="w-full px-4 py-2.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none focus:ring-1 focus:ring-cyan-100 transition-all duration-300 text-xs text-gray-600 placeholder-gray-400"
                       required>
                @error('banner_type')
                    <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status Toggle --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">
                    Status
                </label>
                <div class="flex items-center gap-3">
                    <input type="hidden" name="is_published" value="0">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_published" value="1" class="sr-only peer" {{ old('is_published') ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-cyan-200 rounded-full peer peer-checked:bg-emerald-500 transition-colors duration-300 ease-in-out after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:border-gray-300 after:rounded-full after:h-5 after:w-5 after:transition-transform after:duration-300 after:ease-in-out peer-checked:after:translate-x-5"></div>
                    </label>
                    <span class="text-xs text-gray-500">Enable to show banner on site/app.</span>
                </div>
            </div>

            {{-- Banner Image with Preview --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">
                    Banner Image * <span class="text-gray-400 text-[10px]">Recommended 16:6</span>
                </label>
                <div class="flex items-center space-x-4">
                    <div class="relative w-32 h-20 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden group">
                        <i class="fas fa-image text-gray-400 text-2xl preview-default {{ old('image') ? 'hidden' : '' }}"></i>
                        <img id="banner-preview" src="" alt="Banner preview" class="absolute inset-0 w-full h-full object-cover hidden">
                        <button type="button" id="remove-banner" class="absolute top-1 right-1 w-5 h-5 bg-red-500 rounded-full flex items-center justify-center text-white text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-200 hidden" onclick="removeBanner()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <div class="flex-1">
                        <input type="file" name="image" id="banner-image" class="hidden" accept="image/*" onchange="previewBanner(this)" required>
                        <label for="banner-image" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg text-xs text-gray-600 hover:bg-cyan-50 hover:border-cyan-200 hover:text-cyan-600 cursor-pointer transition-all duration-200">
                            <i class="fas fa-upload mr-2"></i>
                            Choose File
                        </label>
                        <span id="banner-file-name" class="ml-3 text-xs text-gray-500"></span>
                        @error('image')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="pt-1">
                <button type="button" onclick="document.getElementById('banner-image').click()" class="text-xs text-cyan-600 hover:text-cyan-700 flex items-center">
                    <i class="fas fa-folder-open mr-1"></i>
                    Browse
                </button>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                <button type="reset" class="px-6 py-2 border border-gray-200 text-gray-600 text-xs font-medium rounded-lg hover:bg-gray-50 transition-all duration-200">
                    Reset
                </button>
                <button type="submit" class="px-6 py-2 bg-gradient-to-r from-cyan-500 to-emerald-500 text-white text-xs font-medium rounded-lg hover:from-cyan-600 hover:to-emerald-600 transition-all duration-200 shadow-sm hover:shadow">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function previewBanner(input) {
    const preview = document.getElementById('banner-preview');
    const defaultIcon = document.querySelector('.preview-default');
    const fileName = document.getElementById('banner-file-name');
    const removeBtn = document.getElementById('remove-banner');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        const file = input.files[0];
        fileName.textContent = file.name;
        reader.onload = function(e) {
            defaultIcon.classList.add('hidden');
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            removeBtn.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    } else {
        resetBannerPreview();
    }
}

function removeBanner() {
    const input = document.getElementById('banner-image');
    const preview = document.getElementById('banner-preview');
    const defaultIcon = document.querySelector('.preview-default');
    const fileName = document.getElementById('banner-file-name');
    const removeBtn = document.getElementById('remove-banner');
    
    input.value = '';
    preview.src = '';
    preview.classList.add('hidden');
    defaultIcon.classList.remove('hidden');
    fileName.textContent = '';
    removeBtn.classList.add('hidden');
}

function resetBannerPreview() {
    const input = document.getElementById('banner-image');
    const preview = document.getElementById('banner-preview');
    const defaultIcon = document.querySelector('.preview-default');
    const fileName = document.getElementById('banner-file-name');
    const removeBtn = document.getElementById('remove-banner');
    
    input.value = '';
    preview.src = '';
    preview.classList.add('hidden');
    defaultIcon.classList.remove('hidden');
    fileName.textContent = '';
    removeBtn.classList.add('hidden');
}
</script>

<style>
#banner-preview {
    transition: opacity 0.2s ease;
}
.group:hover #remove-banner {
    opacity: 1;
}
#remove-banner {
    z-index: 10;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
#remove-banner:hover {
    background-color: #dc2626;
    transform: scale(1.1);
}
</style>
@endpush
@endsection
