@extends('layout.app')
{{-- CKEditor CDN --}}
@push('styles')
<style>
    /* CKEditor Custom Styling */
    .ck-editor__editable {
        min-height: 200px;
        max-height: 400px;
    }

    .ck-content {
        font-size: 14px !important;
        line-height: 1.6 !important;
    }

    .ck-content h1 { font-size: 2em; }
    .ck-content h2 { font-size: 1.5em; }
    .ck-content h3 { font-size: 1.17em; }
    .ck-content h4 { font-size: 1em; }
    .ck-content p { margin: 0 0 1em; }
    .ck-content ul, .ck-content ol { margin-left: 2em; }

    /* Custom Scrollbar */
   

    #sku {
        padding-right: 85px;
    }

    #image-preview {
        transition: all 0.3s ease;
    }

    #additional-images-preview > div {
        transition: transform 0.2s ease;
    }

    #additional-images-preview > div:hover {
        transform: scale(1.05);
        z-index: 10;
    }

    /* Toggle Switch Styles */
    .peer:checked ~ .peer-checked\:bg-gradient-to-r {
        background-image: linear-gradient(to right, #06b6d4, #10b981);
    }

    /* FIXED CONTAINER SCROLL - Browser UI scroll nahi hoga */
  
</style>
@endpush

@section('content')
<div class="max-w-6xl mx-auto h-full">
    {{-- Single scroll: rely on layout main scroll, card stays natural height --}}
    <div class="bg-white rounded-xl border border-cyan-100/50 shadow-sm flex flex-col">
        
        {{-- Fixed Header - Scroll Nahi Hoga --}}
        <div class="sticky top-0 z-10 px-6 py-3 bg-gradient-to-r from-cyan-50 to-emerald-50 border-b border-cyan-100/50 rounded-t-xl">
            <h3 class="text-sm font-semibold text-gray-700">Add New Product</h3>
        </div>

        {{-- Scrollable Content - YAHI SCROLL HOGA --}}
        <div class="p-6">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Row 1: Product Name & SKU --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    {{-- Product Name --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">
                            Product Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                            name="product_name"
                            value="{{ old('product_name') }}"
                            class="w-full px-4 py-2.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none focus:ring-1 focus:ring-cyan-100 text-xs @error('product_name') border-red-400 @enderror"
                            placeholder="Enter product name"
                            required>
                        @error('product_name')
                        <p class="mt-1 text-[10px] text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- SKU with Generate Button --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">
                            SKU <span class="text-gray-400">(Unique, Auto-generated)</span>
                        </label>
                        <div class="relative">
                            <input type="text"
                                name="sku"
                                id="sku"
                                value="{{ old('sku') }}"
                                class="w-full px-4 py-2.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none focus:ring-1 focus:ring-cyan-100 text-xs pr-24 @error('sku') border-red-400 @enderror"
                                placeholder="Click generate to create SKU"
                                readonly>
                            <button type="button"
                                onclick="generateSKU()"
                                class="absolute right-1 top-1/2 -translate-y-1/2 px-3 py-1.5 bg-gradient-to-r from-cyan-500 to-emerald-500 text-white text-[10px] font-medium rounded-md hover:from-cyan-600 hover:to-emerald-600 transition-all duration-200 whitespace-nowrap">
                                <i class="fas fa-random mr-1 text-[8px]"></i>
                                Generate
                            </button>
                        </div>
                        <p class="mt-1 text-[10px] text-gray-400">
                            <i class="fas fa-info-circle mr-1"></i>
                            Click generate button to create unique SKU
                        </p>
                        @error('sku')
                        <p class="mt-1 text-[10px] text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Row 2: Category, Sub Category, Sub Sub Category --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    {{-- Category --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">
                            Category
                        </label>
                        <select name="category_id" id="category_id" class="w-full px-4 py-2.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none text-xs @error('category_id') border-red-400 @enderror">
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Sub Category --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">
                            Sub Category
                        </label>
                        <select name="sub_category_id" id="sub_category_id" class="w-full px-4 py-2.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none text-xs @error('sub_category_id') border-red-400 @enderror">
                            <option value="">-- Select Sub Category --</option>
                            @foreach($subCategories as $subCategory)
                            <option value="{{ $subCategory->id }}"
                                data-category-id="{{ $subCategory->category_id }}"
                                {{ old('sub_category_id') == $subCategory->id ? 'selected' : '' }}>
                                {{ $subCategory->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Sub Sub Category --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">
                            Sub Sub Category
                        </label>
                        <select name="sub_sub_category_id" id="sub_sub_category_id" class="w-full px-4 py-2.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none text-xs @error('sub_sub_category_id') border-red-400 @enderror">
                            <option value="">-- Select Sub Sub Category --</option>
                            @foreach($subSubCategories as $subSubCategory)
                            <option value="{{ $subSubCategory->id }}"
                                data-subcategory-id="{{ $subSubCategory->sub_sub_category_id }}"
                                {{ old('sub_sub_category_id') == $subSubCategory->id ? 'selected' : '' }}>
                                {{ $subSubCategory->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Row 3: Brand, Attribute, Attribute Value --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    {{-- Brand --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">
                            Brand
                        </label>
                        <select name="brand_id" class="w-full px-4 py-2.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none text-xs @error('brand_id') border-red-400 @enderror">
                            <option value="">-- Select Brand --</option>
                            @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Attribute --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">
                            Attribute
                        </label>
                        <select name="attribute_id" class="w-full px-4 py-2.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none text-xs @error('attribute_id') border-red-400 @enderror">
                            <option value="">-- Select Attribute --</option>
                            @foreach($attributes as $attribute)
                            <option value="{{ $attribute->id }}" {{ old('attribute_id') == $attribute->id ? 'selected' : '' }}>
                                {{ $attribute->attribute_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Attribute Value --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">
                            Attribute Value
                        </label>
                        <input type="text"
                            name="attribute_value"
                            value="{{ old('attribute_value') }}"
                            class="w-full px-4 py-2.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none text-xs"
                            placeholder="e.g., Red, XL, Cotton">
                    </div>
                </div>

                {{-- Row 4: Product Type, Unit Price, Product Unit, Stock --}}
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                    {{-- Product Type --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">
                            Product Type <span class="text-red-500">*</span>
                        </label>
                        <select name="product_type" class="w-full px-4 py-2.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none text-xs">
                            <option value="physical" {{ old('product_type') == 'physical' ? 'selected' : '' }}>Physical</option>
                            <option value="digital" {{ old('product_type') == 'digital' ? 'selected' : '' }}>Digital</option>
                        </select>
                    </div>

                    {{-- Unit Price --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">
                            Unit Price (₹) <span class="text-red-500">*</span>
                        </label>
                        <input type="number"
                            step="0.01"
                            name="unit_price"
                            value="{{ old('unit_price', '0.00') }}"
                            class="w-full px-4 py-2.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none text-xs @error('unit_price') border-red-400 @enderror"
                            placeholder="0.00"
                            required>
                        @error('unit_price')
                        <p class="mt-1 text-[10px] text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Product Unit --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">
                            Product Unit
                        </label>
                        @php
                            $units = ['kg', 'pc', 'gms', 'ltrs', 'pair', 'oz', 'lb'];
                        @endphp
                        <select name="product_unit" class="w-full px-4 py-2.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none text-xs @error('product_unit') border-red-400 @enderror">
                            <option value="">-- Select Unit --</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit }}" {{ old('product_unit') === $unit ? 'selected' : '' }}>{{ ucfirst($unit) }}</option>
                            @endforeach
                        </select>
                        @error('product_unit')
                        <p class="mt-1 text-[10px] text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Stock Quantity --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">
                            Stock Quantity <span class="text-red-500">*</span>
                        </label>
                        <input type="number"
                            name="stock_quantity"
                            value="{{ old('stock_quantity', '0') }}"
                            class="w-full px-4 py-2.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none text-xs @error('stock_quantity') border-red-400 @enderror"
                            placeholder="0"
                            required>
                        @error('stock_quantity')
                        <p class="mt-1 text-[10px] text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Row 5: Discount, Discount Type, Shipping Cost --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    {{-- Discount --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">
                            Discount
                        </label>
                        <input type="number"
                            step="0.01"
                            name="discount"
                            value="{{ old('discount') }}"
                            class="w-full px-4 py-2.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none text-xs"
                            placeholder="0.00">
                    </div>

                    {{-- Discount Type --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">
                            Discount Type
                        </label>
                        <select name="discount_type" class="w-full px-4 py-2.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none text-xs">
                            <option value="">-- Select Type --</option>
                            <option value="flat" {{ old('discount_type') == 'flat' ? 'selected' : '' }}>Flat (₹)</option>
                            <option value="percent" {{ old('discount_type') == 'percent' ? 'selected' : '' }}>Percentage (%)</option>
                        </select>
                    </div>

                    {{-- Shipping Cost --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">
                            Shipping Cost (₹)
                        </label>
                        <input type="number"
                            step="0.01"
                            name="shipping_cost"
                            value="{{ old('shipping_cost') }}"
                            class="w-full px-4 py-2.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none text-xs"
                            placeholder="0.00">
                    </div>
                </div>

                {{-- Row 6: Tax Amount, Status --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    {{-- Tax Amount --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">
                            Tax Amount (₹)
                        </label>
                        <input type="number"
                            step="0.01"
                            name="tax_amount"
                            value="{{ old('tax_amount') }}"
                            class="w-full px-4 py-2.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none text-xs"
                            placeholder="0.00">
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">
                            Status
                        </label>
                        <div class="flex items-center h-[42px]">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="status" value="1" class="sr-only peer" {{ old('status', '1') == '1' ? 'checked' : '' }}>
                                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-cyan-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-cyan-500 peer-checked:to-emerald-500"></div>
                                <span class="ms-3 text-xs font-medium text-gray-600">Active</span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Row 7: Description with CKEditor --}}
                <div class="mb-4">
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">
                        Description <span class="text-gray-400">(Rich Text Editor)</span>
                    </label>
                    <textarea name="description"
                        id="editor"
                        rows="4"
                        class="w-full px-4 py-2.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none focus:ring-1 focus:ring-cyan-100 text-xs"
                        placeholder="Enter product description">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="mt-1 text-[10px] text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Row 8: Tags --}}
                <div class="mb-4">
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">
                        Tags <span class="text-gray-400">(Comma separated)</span>
                    </label>
                    <input type="text"
                        name="tags"
                        value="{{ old('tags') }}"
                        class="w-full px-4 py-2.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none focus:ring-1 focus:ring-cyan-100 text-xs"
                        placeholder="new, trending, sale">
                </div>

                {{-- Row 9: Main Image --}}
                <div class="mb-4">
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">
                        Main Image <span class="text-gray-400">(jpg, jpeg, png)</span>
                    </label>
                    <div class="flex items-center space-x-4">
                        <div class="relative w-24 h-24 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden group">
                            <i class="fas fa-image text-gray-400 text-2xl preview-main-default"></i>
                            <img id="image-preview" src="" alt="Preview" class="absolute inset-0 w-full h-full object-cover hidden">
                            <button type="button"
                                id="remove-main-image"
                                class="absolute top-1 right-1 w-5 h-5 bg-red-500 rounded-full flex items-center justify-center text-white text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-200 hidden"
                                onclick="removeMainImage()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div>
                            <input type="file"
                                name="image"
                                id="image"
                                accept="image/jpg,image/jpeg,image/png"
                                class="hidden"
                                onchange="previewMainImage(this)">
                            <label for="image" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg text-xs text-gray-600 hover:bg-gray-50 cursor-pointer transition-all duration-200">
                                <i class="fas fa-upload mr-2"></i>
                                Choose File
                            </label>
                            <span id="file-name" class="ml-3 text-xs text-gray-500"></span>
                        </div>
                    </div>
                    @error('image')
                    <p class="mt-1 text-[10px] text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Row 10: Additional Images --}}
                <div class="mb-4">
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">
                        Additional Images <span class="text-gray-400">(Multiple files allowed)</span>
                    </label>
                    <div class="mb-3">
                        <input type="file"
                            name="additional_image[]"
                            id="additional_images"
                            multiple
                            accept="image/jpg,image/jpeg,image/png"
                            class="hidden"
                            onchange="previewAdditionalImages(this)">
                        <label for="additional_images" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg text-xs text-gray-600 hover:bg-gray-50 cursor-pointer transition-all duration-200">
                            <i class="fas fa-images mr-2"></i>
                            Choose Multiple Files
                        </label>
                        <span id="additional-file-count" class="ml-3 text-xs text-gray-500">No files chosen</span>
                    </div>
                    <div id="additional-images-preview" class="grid grid-cols-4 md:grid-cols-6 gap-3"></div>
                    @error('additional_image.*')
                    <p class="mt-1 text-[10px] text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Buttons --}}
                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('products.index') }}"
                        class="px-6 py-2 border border-gray-200 text-gray-600 text-xs font-medium rounded-lg hover:bg-gray-50 transition-all duration-200">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-cyan-500 to-emerald-500 text-white text-xs font-medium rounded-lg hover:from-cyan-600 hover:to-emerald-600 transition-all duration-200 shadow-sm">
                        Create Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- CKEditor Script --}}
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
    // CKEDITOR INITIALIZATION
    ClassicEditor
        .create(document.querySelector('#editor'), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                    'outdent', 'indent', '|',
                    'blockQuote', 'insertTable', 'undo', 'redo'
                ]
            },
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2' },
                    { model: 'heading3', view: 'h3', title: 'Heading 3' }
                ]
            },
            placeholder: 'Enter product description...',
        })
        .catch(error => console.error(error));

    // SKU GENERATOR
    function generateSKU() {
        const prefix = 'PRD';
        const timestamp = Date.now().toString().slice(-2);
        const random = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
        document.getElementById('sku').value = `${prefix}${timestamp}${random}`;
    }

    window.addEventListener('load', function() {
        if (!document.getElementById('sku').value) generateSKU();
    });

    // IMAGE PREVIEW FUNCTIONS
    function previewMainImage(input) {
        const preview = document.getElementById('image-preview');
        const defaultIcon = document.querySelector('.preview-main-default');
        const fileName = document.getElementById('file-name');
        const removeBtn = document.getElementById('remove-main-image');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            fileName.textContent = input.files[0].name;
            
            reader.onload = function(e) {
                defaultIcon.classList.add('hidden');
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                removeBtn.classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeMainImage() {
        const input = document.getElementById('image');
        const preview = document.getElementById('image-preview');
        const defaultIcon = document.querySelector('.preview-main-default');
        const fileName = document.getElementById('file-name');
        const removeBtn = document.getElementById('remove-main-image');
        
        input.value = '';
        preview.src = '';
        preview.classList.add('hidden');
        defaultIcon.classList.remove('hidden');
        fileName.textContent = '';
        removeBtn.classList.add('hidden');
    }

    // ADDITIONAL IMAGES PREVIEW
    let additionalImages = [];

    function previewAdditionalImages(input) {
        const previewGrid = document.getElementById('additional-images-preview');
        const fileCount = document.getElementById('additional-file-count');
        
        previewGrid.innerHTML = '';
        
        if (input.files && input.files.length > 0) {
            additionalImages = Array.from(input.files);
            fileCount.textContent = additionalImages.length + ' file(s) chosen';
            
            additionalImages.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewDiv = document.createElement('div');
                    previewDiv.className = 'relative group';
                    previewDiv.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-20 rounded-lg object-cover border border-gray-200">
                        <button type="button" onclick="removeAdditionalImage(${index})" class="absolute -top-2 -right-2 w-5 h-5 bg-red-500 rounded-full text-white text-xs opacity-0 group-hover:opacity-100">×</button>
                    `;
                    previewGrid.appendChild(previewDiv);
                }
                reader.readAsDataURL(file);
            });
        }
    }

    function removeAdditionalImage(index) {
        additionalImages.splice(index, 1);
        const dataTransfer = new DataTransfer();
        additionalImages.forEach(file => dataTransfer.items.add(file));
        document.getElementById('additional_images').files = dataTransfer.files;
        previewAdditionalImages(document.getElementById('additional_images'));
    }

    // CATEGORY FILTERING
    document.getElementById('category_id').addEventListener('change', function() {
        let selectedCategory = this.value;
        
        document.querySelectorAll('#sub_category_id option').forEach(option => {
            if (option.value === '') return;
            option.style.display = (selectedCategory && option.dataset.categoryId != selectedCategory) ? 'none' : 'block';
        });
        
        document.getElementById('sub_category_id').value = '';
        document.getElementById('sub_sub_category_id').innerHTML = '<option value="">-- Select Sub Sub Category --</option>';
    });

    document.getElementById('sub_category_id').addEventListener('change', function() {
        let selectedSubCategory = this.value;
        let subSubSelect = document.getElementById('sub_sub_category_id');
        
        subSubSelect.innerHTML = '<option value="">-- Select Sub Sub Category --</option>';
        
        @foreach($subSubCategories as $subSubCategory)
        if (selectedSubCategory == {{ $subSubCategory->sub_category_id }}) {
            let option = document.createElement('option');
            option.value = {{ $subSubCategory->id }};
            option.textContent = '{{ $subSubCategory->name }}';
            subSubSelect.appendChild(option);
        }
        @endforeach
    });
</script>

<style>
    #sku { padding-right: 85px; }
    #image-preview { transition: all 0.3s ease; }
    #additional-images-preview > div { transition: transform 0.2s ease; }
    #additional-images-preview > div:hover { transform: scale(1.05); z-index: 10; }
    .ck-editor__editable { min-height: 250px; max-height: 500px; border-radius: 0 0 0.5rem 0.5rem !important; }
    .ck.ck-toolbar { border-radius: 0.5rem 0.5rem 0 0 !important; }
    .peer:checked ~ .peer-checked\:bg-gradient-to-r { background-image: linear-gradient(to right, #06b6d4, #10b981); }
</style>
@endsection
