@extends('layout.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl border border-cyan-100/50 shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-cyan-50 to-emerald-50 border-b border-cyan-100/50">
            <h3 class="text-sm font-semibold text-gray-700">Add New Category</h3>
        </div>

        <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf
            
            {{-- Category Name* (EN) --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">
                    Category Name* (EN)
                </label>
                <input type="text" 
                       name="name"
                       value="{{ old('name') }}"
                       placeholder="Enter category name"
                       class="w-full px-4 py-2.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none focus:ring-1 focus:ring-cyan-100 transition-all duration-300 text-xs text-gray-600 placeholder-gray-400"
                       required>
            </div>

            <!-- {{-- New Category (Dropdown) --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">
                    New Category
                </label>
                <select name="new_category" 
                        class="w-full px-4 py-2.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none focus:ring-1 focus:ring-cyan-100 transition-all duration-300 text-xs text-gray-600">
                    <option value="">Select Category</option>
                    <option value="new">New Category</option>
                    <option value="electronics">Electronics</option>
                    <option value="fashion">Fashion</option>
                </select>
            </div> -->

            {{-- Priority --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">
                    Priority <span class="text-gray-400 ml-1">⓪</span>
                </label>
                <select name="priority" 
                        class="w-full px-4 py-2.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none focus:ring-1 focus:ring-cyan-100 transition-all duration-300 text-xs text-gray-600">
                    <option value="">Set Priority</option>
                    @for($i = 0; $i <= 10; $i++)
                        <option value="{{ $i }}" {{ old('priority') == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>

            {{-- Category Logo with Ratio and Preview --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">
                    Category Logo * <span class="text-gray-400 text-[10px]">Ratio 1:1 (500 × 500 px)</span>
                </label>
                <div class="flex items-center space-x-4">
                    {{-- Image Preview Container --}}
                    <div class="relative w-20 h-20 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden group">
                        {{-- Default Icon (hidden when image is selected) --}}
                        <i class="fas fa-image text-gray-400 text-2xl preview-default {{ old('image') ? 'hidden' : '' }}"></i>
                        
                        {{-- Preview Image --}}
                        <img id="image-preview" 
                             src="" 
                             alt="Category preview" 
                             class="absolute inset-0 w-full h-full object-cover hidden">
                        
                        {{-- Remove image button (hidden by default) --}}
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
                               id="category-image"
                               class="hidden"
                               accept="image/*"
                               onchange="previewImage(this)">
                        <label for="category-image" 
                               class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg text-xs text-gray-600 hover:bg-cyan-50 hover:border-cyan-200 hover:text-cyan-600 cursor-pointer transition-all duration-200">
                            <i class="fas fa-upload mr-2"></i>
                            Choose File
                        </label>
                        <span id="file-name" class="ml-3 text-xs text-gray-500"></span>
                    </div>
                </div>
            </div>

            {{-- Browse Button (you might want to remove this as it's redundant with Choose File) --}}
            <div class="pt-1">
                <button type="button" onclick="document.getElementById('category-image').click()" class="text-xs text-cyan-600 hover:text-cyan-700 flex items-center">
                    <i class="fas fa-folder-open mr-1"></i>
                    Browse
                </button>
            </div>

            {{-- Form Actions --}}
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
    } else {
        // Reset preview if no file selected
        resetImagePreview();
    }
}

function removeImage() {
    const input = document.getElementById('category-image');
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

function resetImagePreview() {
    const input = document.getElementById('category-image');
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

// Optional: Add drag and drop functionality
document.getElementById('category-image').addEventListener('dragover', function(e) {
    e.preventDefault();
    this.parentElement.classList.add('border-cyan-300');
});

document.getElementById('category-image').addEventListener('dragleave', function(e) {
    e.preventDefault();
    this.parentElement.classList.remove('border-cyan-300');
});

document.getElementById('category-image').addEventListener('drop', function(e) {
    e.preventDefault();
    this.parentElement.classList.remove('border-cyan-300');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        this.files = files;
        previewImage(this);
    }
});
</script>

{{-- Optional: Add CSS for better preview experience --}}
<style>
#image-preview {
    transition: opacity 0.2s ease;
}

.group:hover #remove-image {
    opacity: 1;
}

#remove-image {
    z-index: 10;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

#remove-image:hover {
    background-color: #dc2626;
    transform: scale(1.1);
}
</style>
@endpush
@endsection