@extends('layout.app')
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl border border-cyan-100/50 shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-cyan-50 to-emerald-50 border-b border-cyan-100/50">
            <h3 class="text-sm font-semibold text-gray-700">Add New Brand</h3>
        </div>

        <form action="{{ route('brand.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf
            
            {{-- Brand Name* --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">
                    Brand Name* <span class="text-gray-400">(Unique)</span>
                </label>
                <input type="text" 
                       name="name"
                       value="{{ old('name') }}"
                       placeholder="Enter brand name"
                       class="w-full px-4 py-2.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none focus:ring-1 focus:ring-cyan-100 transition-all duration-300 text-xs text-gray-600 placeholder-gray-400 @error('name') border-rose-300 @enderror"
                       required>
                @error('name')
                    <p class="mt-1 text-[10px] text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Alt Text --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">
                    Alt Text <span class="text-gray-400">(For SEO)</span>
                </label>
                <input type="text" 
                       name="alt_text"
                       value="{{ old('alt_text') }}"
                       placeholder="Enter alternative text for image"
                       class="w-full px-4 py-2.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none focus:ring-1 focus:ring-cyan-100 transition-all duration-300 text-xs text-gray-600 placeholder-gray-400 @error('alt_text') border-rose-300 @enderror">
                @error('alt_text')
                    <p class="mt-1 text-[10px] text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Brand Image with Preview --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">
                    Brand Image* <span class="text-gray-400 text-[10px]">(Recommended: 200×200 px)</span>
                </label>
                <div class="flex items-center space-x-4">
                    {{-- Image Preview Container --}}
                    <div class="relative w-20 h-20 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden group">
                        {{-- Default Icon --}}
                        <i class="fas fa-image text-gray-400 text-2xl preview-default"></i>
                        
                        {{-- Preview Image --}}
                        <img id="image-preview" 
                             src="" 
                             alt="Brand preview" 
                             class="absolute inset-0 w-full h-full object-cover hidden">
                        
                        {{-- Remove image button --}}
                        <button type="button" 
                                id="remove-image" 
                                class="absolute top-1 right-1 w-5 h-5 bg-red-500 rounded-full flex items-center justify-center text-white text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-200 hidden"
                                onclick="removeImage()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <div class="flex-1">
                        <input type="file" 
                               name="image"
                               id="brand-image"
                               class="hidden"
                               accept="image/*"
                               onchange="previewImage(this)"
                               required>
                        <label for="brand-image" 
                               class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg text-xs text-gray-600 hover:bg-cyan-50 hover:border-cyan-200 hover:text-cyan-600 cursor-pointer transition-all duration-200">
                            <i class="fas fa-upload mr-2"></i>
                            Choose File
                        </label>
                        <span id="file-name" class="ml-3 text-xs text-gray-500"></span>
                    </div>
                </div>
                @error('image')
                    <p class="mt-1 text-[10px] text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Browse Button --}}
            <div class="pt-1">
                <button type="button" onclick="document.getElementById('brand-image').click()" class="text-xs text-cyan-600 hover:text-cyan-700 flex items-center">
                    <i class="fas fa-folder-open mr-1"></i>
                    Browse
                </button>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                <a href="{{ route('brand.index') }}" 
                   class="px-6 py-2 border border-gray-200 text-gray-600 text-xs font-medium rounded-lg hover:bg-gray-50 transition-all duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-gradient-to-r from-cyan-500 to-emerald-500 text-white text-xs font-medium rounded-lg hover:from-cyan-600 hover:to-emerald-600 transition-all duration-200 shadow-sm hover:shadow">
                    Create Brand
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('image-preview');
    const defaultIcon = document.querySelector('.preview-default');
    const fileName = document.getElementById('file-name');
    const removeBtn = document.getElementById('remove-image');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        const file = input.files[0];
        
        // Show file name
        fileName.textContent = file.name;
        
        reader.onload = function(e) {
            // Hide default icon and show preview
            defaultIcon.classList.add('hidden');
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            
            // Show remove button
            removeBtn.classList.remove('hidden');
        }
        
        reader.readAsDataURL(file);
    }
}

function removeImage() {
    const input = document.getElementById('brand-image');
    const preview = document.getElementById('image-preview');
    const defaultIcon = document.querySelector('.preview-default');
    const fileName = document.getElementById('file-name');
    const removeBtn = document.getElementById('remove-image');
    
    // Clear file input
    input.value = '';
    
    // Reset preview
    preview.src = '';
    preview.classList.add('hidden');
    defaultIcon.classList.remove('hidden');
    
    // Clear file name
    fileName.textContent = '';
    
    // Hide remove button
    removeBtn.classList.add('hidden');
}
</script>
@endpush
@endsection