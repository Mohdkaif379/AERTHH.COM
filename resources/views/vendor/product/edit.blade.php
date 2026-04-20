@extends('vendor.layout.navbar')

@push('styles')
<style>
    .ck-editor__editable {
        width: 100%;
    }

    .ck-content {
        font-size: 14px !important;
        line-height: 1.6 !important;
    }

    #sku {
        padding-right: 85px;
    }

    #existing-additional-images > div,
    #new-additional-images-preview > div {
        transition: transform 0.2s ease;
    }

    #existing-additional-images > div:hover,
    #new-additional-images-preview > div:hover {
        transform: scale(1.05);
        z-index: 10;
    }

    .peer:checked ~ .peer-checked\:bg-gradient-to-r {
        background-image: linear-gradient(to right, #f97316, #ea580c);
    }
</style>
@endpush

@section('content')
@php
    $selectedTags = old('tags');
    if (is_array($selectedTags)) {
        $selectedTags = implode(',', $selectedTags);
    } elseif ($selectedTags === null) {
        $selectedTags = is_array($product->tags ?? null) ? implode(',', $product->tags) : ($product->tags ?? '');
    }

    $existingAdditionalImages = $product->additional_image ?? [];
    if (!is_array($existingAdditionalImages)) {
        $existingAdditionalImages = [];
    }
@endphp

<div class="max-w-6xl mx-auto">
    <div class="bg-white dark:bg-gray-900 rounded-xl border border-orange-100/50 shadow-sm flex flex-col">
        <div class="sticky top-0 z-10 px-6 py-3 bg-gradient-to-r from-orange-50 to-amber-50 border-b border-orange-100/50 rounded-t-xl">
            <h3 class="text-sm font-semibold text-gray-700">Edit Product</h3>
        </div>

        <div class="p-6">
            <form action="{{ route('vendor.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">
                            Product Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}" required
                            class="w-full px-4 py-2.5 bg-gray-50/90 dark:bg-gray-800/90 border border-gray-200 dark:border-gray-600 rounded-lg focus:border-orange-300 focus:ring-1 focus:ring-orange-100 text-xs text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 @error('product_name') border-red-400 @enderror"
                            placeholder="Enter product name">
                        @error('product_name') <p class="mt-1 text-[10px] text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="relative">
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">SKU</label>
                        <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}" readonly
                            class="w-full pr-24 px-4 py-2.5 bg-gray-50/95 dark:bg-gray-800/95 border border-gray-200 dark:border-gray-600 rounded-lg focus:border-orange-400 focus:ring-1 focus:ring-orange-100 text-xs text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 @error('sku') border-red-400 @enderror">
                        <button type="button" onclick="generateSKU()" class="absolute right-1 top-1/2 -translate-y-1/2 px-3 py-1.5 bg-gradient-to-r from-orange-500 to-orange-600 text-white text-[10px] rounded-md hover:from-orange-600 hover:to-orange-700 transition">
                            <i class="fas fa-random mr-1 text-[8px]"></i>Generate
                        </button>
                        @error('sku') <p class="mt-1 text-[10px] text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Category <span class="text-red-500">*</span></label>
                        <select name="category_id" id="category_id" class="w-full px-4 py-2.5 bg-gray-50/95 dark:bg-gray-800/95 border border-gray-200 dark:border-gray-600 rounded-lg focus:border-orange-400 focus:ring-1 focus:ring-orange-100 text-xs text-gray-900 dark:text-gray-100 @error('category_id') border-red-400 @enderror">
                            <option value=""> -- Select Category -- </option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ (string) old('category_id', $product->category_id) === (string) $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="mt-1 text-[10px] text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Sub Category</label>
                        <select name="sub_category_id" id="sub_category_id" class="w-full px-4 py-2.5 bg-gray-50/95 dark:bg-gray-800/95 border border-gray-200 dark:border-gray-600 rounded-lg focus:border-orange-400 focus:ring-1 focus:ring-orange-100 text-xs text-gray-900 dark:text-gray-100">
                            <option value=""> -- Select Sub Category -- </option>
                            @foreach($subcategories as $subCategory)
                                <option value="{{ $subCategory->id }}" {{ (string) old('sub_category_id', $product->sub_category_id) === (string) $subCategory->id ? 'selected' : '' }}>{{ $subCategory->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Sub Sub Category</label>
                        <select name="sub_sub_category_id" id="sub_sub_category_id" class="w-full px-4 py-2.5 bg-gray-50/95 dark:bg-gray-800/95 border border-gray-200 dark:border-gray-600 rounded-lg focus:border-orange-400 focus:ring-1 focus:ring-orange-100 text-xs text-gray-900 dark:text-gray-100">
                            <option value=""> -- Select Sub Sub Category -- </option>
                            @foreach($subsubcategories as $subSubCategory)
                                <option value="{{ $subSubCategory->id }}" {{ (string) old('sub_sub_category_id', $product->sub_sub_category_id) === (string) $subSubCategory->id ? 'selected' : '' }}>{{ $subSubCategory->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Brand</label>
                        <select name="brand_id" class="w-full px-4 py-2.5 bg-gray-50/95 dark:bg-gray-800/95 border border-gray-200 dark:border-gray-600 rounded-lg focus:border-orange-400 focus:ring-1 focus:ring-orange-100 text-xs text-gray-900 dark:text-gray-100">
                            <option value=""> -- Select Brand -- </option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ (string) old('brand_id', $product->brand_id) === (string) $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Attribute</label>
                        <select name="attribute_id" class="w-full px-4 py-2.5 bg-gray-50/95 dark:bg-gray-800/95 border border-gray-200 dark:border-gray-600 rounded-lg focus:border-orange-400 focus:ring-1 focus:ring-orange-100 text-xs text-gray-900 dark:text-gray-100">
                            <option value=""> -- Select Attribute -- </option>
                            @foreach($attributes as $attribute)
                                <option value="{{ $attribute->id }}" {{ (string) old('attribute_id', $product->attribute_id) === (string) $attribute->id ? 'selected' : '' }}>{{ $attribute->attribute_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">Attribute Value</label>
                    <input type="text" name="attribute_value" value="{{ old('attribute_value', $product->attribute_value) }}" placeholder="Red, XL, Cotton"
                        class="w-full px-4 py-2.5 bg-gray-50/95 dark:bg-gray-800/95 border border-gray-200 dark:border-gray-600 rounded-lg focus:border-orange-400 focus:ring-1 focus:ring-orange-100 text-xs text-gray-900 dark:text-gray-100">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Unit Price <span class="text-red-500">*</span></label>
                        <input type="number" step="0.01" name="unit_price" value="{{ old('unit_price', $product->unit_price) }}" required
                            class="w-full px-4 py-2.5 bg-gray-50/95 dark:bg-gray-800/95 border border-gray-200 rounded-lg focus:border-orange-300 text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Stock Qty <span class="text-red-500">*</span></label>
                        <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" required
                            class="w-full px-4 py-2.5 bg-gray-50/95 dark:bg-gray-800/95 border border-gray-200 rounded-lg focus:border-orange-300 text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Unit</label>
                        @php $units = ['kg', 'pc', 'gms', 'ltrs', 'pair', 'oz', 'lb']; @endphp
                        <select name="product_unit" class="w-full px-4 py-2.5 bg-gray-50/95 dark:bg-gray-800/95 border border-gray-200 rounded-lg focus:border-orange-300 text-xs">
                            <option value=""> -- Select Unit -- </option>
                            @foreach($units as $unit)
                                <option value="{{ $unit }}" {{ old('product_unit', $product->product_unit) === $unit ? 'selected' : '' }}>{{ strtoupper($unit) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Product Type</label>
                        <select name="product_type" class="w-full px-4 py-2.5 bg-gray-50/95 dark:bg-gray-800/95 border border-gray-200 rounded-lg focus:border-orange-300 text-xs">
                            <option value="physical" {{ old('product_type', $product->product_type) === 'physical' ? 'selected' : '' }}>Physical</option>
                            <option value="digital" {{ old('product_type', $product->product_type) === 'digital' ? 'selected' : '' }}>Digital</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Discount</label>
                        <input type="number" step="0.01" name="discount" value="{{ old('discount', $product->discount) }}" placeholder="0.00"
                            class="w-full px-4 py-2.5 bg-gray-50/95 dark:bg-gray-800/95 border border-gray-200 rounded-lg focus:border-orange-300 text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Discount Type</label>
                        <select name="discount_type" class="w-full px-4 py-2.5 bg-gray-50/95 dark:bg-gray-800/95 border border-gray-200 rounded-lg focus:border-orange-300 text-xs">
                            <option value="flat" {{ old('discount_type', $product->discount_type) === 'flat' ? 'selected' : '' }}>Flat</option>
                            <option value="percent" {{ old('discount_type', $product->discount_type) === 'percent' ? 'selected' : '' }}>Percentage</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Shipping</label>
                        <input type="number" step="0.01" name="shipping_cost" value="{{ old('shipping_cost', $product->shipping_cost) }}" placeholder="0.00"
                            class="w-full px-4 py-2.5 bg-gray-50/95 dark:bg-gray-800/95 border border-gray-200 rounded-lg focus:border-orange-300 text-xs">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 mb-6">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Tax</label>
                        <input type="number" step="0.01" name="tax_amount" value="{{ old('tax_amount', $product->tax_amount) }}" placeholder="0.00"
                            class="w-full px-4 py-2.5 bg-gray-50/95 dark:bg-gray-800/95 border border-gray-200 rounded-lg focus:border-orange-300 text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Status</label>
                        <div class="flex items-center h-10">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="status" value="1" {{ old('status', $product->status ? 1 : 0) == 1 ? 'checked' : '' }} class="sr-only peer">
                                <div class="relative w-11 h-6 bg-gray-200 rounded-full peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-500"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">Description</label>
                    <textarea name="description" id="editor" placeholder="Enter Product Description">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">Tags (comma separated)</label>
                    <input type="text" name="tags" value="{{ $selectedTags }}" placeholder="sale,new,trending"
                        class="w-full px-4 py-2.5 bg-gray-50/95 dark:bg-gray-800/95 border border-gray-200 rounded-lg focus:border-orange-300 text-xs">
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Main Image</label>
                        <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center hover:border-orange-400 transition cursor-pointer" onclick="document.getElementById('main-image-input').click()">
                            <i class="fa fa-image text-3xl text-gray-400 mb-2"></i>
                            <input type="file" name="image" accept="image/*" class="hidden" id="main-image-input" onchange="previewMainImage(this)">
                            <p class="text-xs text-gray-500">Upload a new main image to replace current one</p>
                        </div>
                        <div id="main-image-preview" class="mt-3 p-2 bg-gray-50 rounded-lg {{ $product->image ? '' : 'hidden' }}">
                            <img id="main-preview-img" src="{{ $product->image ? asset('storage/'.$product->image) : '' }}" class="max-h-32 rounded object-cover mx-auto">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Additional Images</label>
                        <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center hover:border-orange-400 transition cursor-pointer" onclick="document.getElementById('additional-image-input').click()">
                            <i class="fa fa-images text-3xl text-gray-400 mb-2"></i>
                            <input type="file" name="additional_images[]" multiple accept="image/*" class="hidden" id="additional-image-input" onchange="previewAdditionalImages(this)">
                            <p class="text-xs text-gray-500">Upload new additional images</p>
                        </div>

                        <div id="existing-additional-images" class="mt-3 p-2 bg-gray-50 rounded-lg grid grid-cols-2 md:grid-cols-3 gap-2 {{ count($existingAdditionalImages) ? '' : 'hidden' }}">
                            @foreach($existingAdditionalImages as $index => $img)
                                <div class="relative group" data-existing-image="{{ $index }}">
                                    <input type="hidden" name="existing_additional_images[]" value="{{ $img }}" data-existing-input="{{ $index }}">
                                    <img src="{{ asset('storage/'.$img) }}" class="w-full h-24 object-cover rounded">
                                    <button type="button" onclick="removeExistingImage('{{ $index }}')" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs group-hover:opacity-100 opacity-0 transition">x</button>
                                </div>
                            @endforeach
                        </div>

                        <div id="new-additional-images-preview" class="mt-3 p-2 bg-gray-50 rounded-lg hidden grid grid-cols-2 md:grid-cols-3 gap-2"></div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('vendor.products.index') }}" class="px-6 py-2.5 border border-gray-200 text-gray-700 text-xs rounded-lg hover:bg-gray-50">Cancel</a>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-orange-500 to-orange-600 text-white text-xs rounded-lg hover:from-orange-600 hover:to-orange-700 shadow-lg">
                        <i class="fa fa-save mr-1"></i>Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .then(editor => {
            editor.editing.view.change(writer => {
                writer.setStyle('min-height', '300px', editor.editing.view.document.getRoot());
            });
        })
        .catch(console.error);

    function previewMainImage(input) {
        const file = input.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('main-preview-img').src = e.target.result;
            document.getElementById('main-image-preview').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }

    function previewAdditionalImages(input) {
        const files = input.files;
        const preview = document.getElementById('new-additional-images-preview');
        preview.innerHTML = '';
        preview.classList.remove('hidden');

        Array.from(files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative group';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-24 object-cover rounded">
                    <button type="button" onclick="removeAdditionalImage(${index})" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs group-hover:opacity-100 opacity-0 transition">x</button>
                `;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }

    function removeAdditionalImage(index) {
        const previews = document.querySelectorAll('#new-additional-images-preview .relative');
        if (previews[index]) {
            previews[index].remove();
        }
    }

    function removeExistingImage(index) {
        const card = document.querySelector(`[data-existing-image="${index}"]`);
        const hiddenInput = document.querySelector(`[data-existing-input="${index}"]`);

        if (card) {
            card.remove();
        }
        if (hiddenInput) {
            hiddenInput.remove();
        }

        const remainingCards = document.querySelectorAll('#existing-additional-images .relative');
        if (!remainingCards.length) {
            document.getElementById('existing-additional-images').classList.add('hidden');
        }
    }

    function generateSKU() {
        document.getElementById('sku').value = 'VPRD' + Date.now().toString().slice(-6);
    }
</script>
@endsection
