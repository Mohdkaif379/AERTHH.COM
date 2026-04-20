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

        .ck-content h1 {
            font-size: 2em;
        }

        .ck-content h2 {
            font-size: 1.5em;
        }

        .ck-content h3 {
            font-size: 1.17em;
        }

        #sku {
            padding-right: 85px;
        }

        #image-preview {
            transition: all 0.3s ease;
        }

        #additional-images-preview>div {
            transition: transform 0.2s ease;
        }

        #additional-images-preview>div:hover {
            transform: scale(1.05);
            z-index: 10;
        }

        .peer:checked~.peer-checked\:bg-gradient-to-r {
            background-image: linear-gradient(to right, #f97316, #ea580c);
        }
    </style>
    @endpush

    @section('content')
    <div class="max-w-6xl mx-auto">
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-orange-100/50 shadow-sm flex flex-col">

            {{-- Header --}}
            <div class="sticky top-0 z-10 px-6 py-3 bg-gradient-to-r from-orange-50 to-amber-50 border-b border-orange-100/50 rounded-t-xl">
                <h3 class="text-sm font-semibold text-gray-700">Add New Product (Pending Approval)</h3>
            </div>

            {{-- Form --}}
            <div class="p-6">
                <form action="{{ route('vendor.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Row 1: Product Name & SKU --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">
                                Product Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="product_name" value="{{ old('product_name') }}" required
                                class="w-full px-4 py-2.5 bg-gray-50/90 dark:bg-gray-800/90 border border-gray-200 dark:border-gray-600 rounded-lg focus:border-orange-300 focus:ring-1 focus:ring-orange-100 text-xs text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 @error('product_name') border-red-400 @enderror"
                                placeholder="Enter product name">
                            @error('product_name') <p class="mt-1 text-[10px] text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="relative">
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">SKU <span class="text-gray-400">(Auto-generate)</span></label>
                            <input type="text" name="sku" id="sku" value="{{ old('sku') }}" readonly
                                class="w-full pr-24 px-4 py-2.5 bg-gray-50/95 dark:bg-gray-800/95 border border-gray-200 dark:border-gray-600 rounded-lg focus:border-orange-400 dark:focus:border-orange-400 focus:ring-1 focus:ring-orange-100 dark:focus:ring-orange-200 text-xs text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 @error('sku') border-red-400 dark:border-red-400 @enderror"
                                placeholder="Click generate">
                            <button type="button" onclick="generateSKU()" class="absolute right-1 top-1/2 -translate-y-1/2 px-3 py-1.5 bg-gradient-to-r from-orange-500 to-orange-600 text-white text-[10px] rounded-md hover:from-orange-600 hover:to-orange-700 transition">
                                <i class="fas fa-random mr-1 text-[8px]"></i>Generate
                            </button>
                            @error('sku') <p class="mt-1 text-[10px] text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Row 2: Categories --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Category <span class="text-red-500">*</span></label>
                            <select name="category_id" id="category_id" class="w-full px-4 py-2.5 bg-gray-50/95 dark:bg-gray-800/95 border border-gray-200 dark:border-gray-600 rounded-lg focus:border-orange-400 dark:focus:border-orange-400 focus:ring-1 focus:ring-orange-100 dark:focus:ring-orange-200 text-xs text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 @error('category_id') border-red-400 dark:border-red-400 @enderror">
                                <option value=""> -- Select Category -- </option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <p class="mt-1 text-[10px] text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Sub Category</label>
                            <select name="sub_category_id" id="sub_category_id" class="w-full px-4 py-2.5 bg-gray-50/95 dark:bg-gray-800/95 border border-gray-200 dark:border-gray-600 rounded-lg focus:border-orange-400 dark:focus:border-orange-400 focus:ring-1 focus:ring-orange-100 dark:focus:ring-orange-200 text-xs text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400">
                                <option value=""> -- Select Sub Category -- </option>
                                @foreach($subcategories as $sub_category)
                                <option value="{{ $sub_category->id }}" {{ old('sub_category_id') == $sub_category->id ? 'selected' : '' }}>{{ $sub_category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Sub Sub Category</label>
                            <select name="sub_sub_category_id" id="sub_sub_category_id" class="w-full px-4 py-2.5 bg-gray-50/95 dark:bg-gray-800/95 border border-gray-200 dark:border-gray-600 rounded-lg focus:border-orange-400 dark:focus:border-orange-400 focus:ring-1 focus:ring-orange-100 dark:focus:ring-orange-200 text-xs text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400">
                                <option value=""> -- Select Sub Sub Category -- </option>
                                @foreach($subsubcategories as $sub_sub_category)
                                <option value="{{ $sub_sub_category->id }}" {{ old('sub_sub_category_id') == $sub_sub_category->id ? 'selected' : '' }}>{{ $sub_sub_category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Row 3: Brand, Attribute --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Brand</label>
                            <select name="brand_id" class="w-full px-4 py-2.5 bg-gray-50/95 dark:bg-gray-800/95 border border-gray-200 dark:border-gray-600 rounded-lg focus:border-orange-400 dark:focus:border-orange-400 focus:ring-1 focus:ring-orange-100 dark:focus:ring-orange-200 text-xs text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400">
                                <option value=""> -- Select Brand -- </option>
                                @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Attribute</label>
                            <select name="attribute_id" class="w-full px-4 py-2.5 bg-gray-50/95 dark:bg-gray-800/95 border border-gray-200 dark:border-gray-600 rounded-lg focus:border-orange-400 dark:focus:border-orange-400 focus:ring-1 focus:ring-orange-100 dark:focus:ring-orange-200 text-xs text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400">

                                <option value=""> -- Select Attribute -- </option>
                                @foreach($attributes as $attribute)
                                <option value="{{ $attribute->id }}" {{ old('attribute_id') == $attribute->id ? 'selected' : '' }}>{{ $attribute->attribute_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Attribute Value --}}
                    <div class="mb-4">
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Attribute Value</label>

                        <input type="text" name="attribute_value" value="{{ old('attribute_value') }}" placeholder="Red, XL, Cotton"
                            class="w-full px-4 py-2.5 bg-gray-50/95 dark:bg-gray-800/95 border border-gray-200 dark:border-gray-600 rounded-lg focus:border-orange-400 dark:focus:border-orange-400 focus:ring-1 focus:ring-orange-100 dark:focus:ring-orange-200 text-xs text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400">

                    </div>

                    {{-- Row 4: Pricing --}}
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Unit Price ₹ <span class="text-red-500">*</span></label>
                            <input type="number" step="0.01" name="unit_price"
                                value="{{ old('unit_price', '0.00') }}" required
                                class="w-full px-4 py-2.5 bg-gray-50/95 dark:bg-gray-800/95 border border-gray-200 rounded-lg focus:border-orange-300 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Stock Qty <span class="text-red-500">*</span></label>
                            <input type="number" name="stock_quantity" value="{{ old('stock_quantity', '0.00') }}" required
                                class="w-full px-4 py-2.5 bg-gray-50/95 dark:bg-gray-800/95 border border-gray-200 rounded-lg focus:border-orange-300 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Unit</label>

                            <select name="product_unit"
                                class="w-full px-4 py-2.5 bg-gray-50/95 dark:bg-gray-800/95 border border-gray-200 rounded-lg focus:border-orange-300 text-xs">

                                <option value=""> -- Select Unit -- </option>

                                @php
                                $units = ['kg', 'pc', 'gms', 'ltrs', 'pair', 'oz', 'lb'];
                                @endphp

                                @foreach($units as $unit)
                                <option value="{{ $unit }}" {{ old('product_unit') == $unit ? 'selected' : '' }}>
                                    {{ strtoupper($unit) }}
                                </option>
                                @endforeach

                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Product Type</label>
                            <select name="product_type" class="w-full px-4 py-2.5 bg-gray-50/95 dark:bg-gray-800/95 border border-gray-200 rounded-lg focus:border-orange-300 text-xs">
                                <!-- <option value=""> -- Select Product Type -- </option> -->
                                <option value="physical">Physical</option>
                                <option value="digital">Digital</option>
                            </select>
                        </div>
                    </div>

                    {{-- Row 5: Discount, Shipping, Tax --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Discount</label>
                            <input type="number" step="0.01" name="discount" value="{{ old('discount') }}" placeholder="0.00"
                                class="w-full px-4 py-2.5 bg-gray-50/95 dark:bg-gray-800/95 border border-gray-200 rounded-lg focus:border-orange-300 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5"> -- Discount Type --</label>
                            <select name="discount_type" class="w-full px-4 py-2.5 bg-gray-50/95 dark:bg-gray-800/95 border border-gray-200 rounded-lg focus:border-orange-300 text-xs">
                                <option value="flat">Flat ₹</option>
                                <option value="percent">Percentage (%)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Shipping ₹</label>
                            <input type="number" step="0.01" name="shipping_cost" value="{{ old('shipping_cost') }} " placeholder="0.00"
                                class="w-full px-4 py-2.5 bg-gray-50/95 dark:bg-gray-800/95 border border-gray-200 rounded-lg focus:border-orange-300 text-xs">
                        </div>
                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 mb-6">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Tax ₹</label>
                            <input type="number" step="0.01" name="tax_amount" value="{{ old('tax_amount') }}" placeholder="0.00"
                                class="w-full px-4 py-2.5 bg-gray-50/95 dark:bg-gray-800/95 border border-gray-200 rounded-lg focus:border-orange-300 text-xs">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Status</label>
                            <div class="flex items-center h-10">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="status" value="1" checked class="sr-only peer">
                                    <div class="relative w-11 h-6 bg-gray-200 rounded-full peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-orange-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-500"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Description with CKEditor --}}

                    <div class="mb-8">
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Description </label>
                        <textarea name="description" id="editor" placeholder="Enter Product Description">{{ old('description') }}</textarea>
                    </div>


                    {{-- Tags --}}
                    <div class="mb-4">
                        <label class="block text-xs font-medium text-gray-600 mb-1.5">Tags (comma separated)</label>
                        <input type="text" name="tags" value="{{ old('tags') }}" placeholder="sale,new,trending"
                            class="w-full px-4 py-2.5 bg-gray-50/95 dark:bg-gray-800/95 border border-gray-200 rounded-lg focus:border-orange-300 text-xs">
                    </div>

                    {{-- Images --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Main Image</label>

                            <div id="main-image-drop" class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-8 text-center hover:border-orange-400 dark:hover:border-orange-400 transition cursor-pointer" onclick="document.getElementById('main-image-input').click()">

                                <i class="fa fa-image text-3xl text-gray-400 mb-2"></i>
                                <input type="file" name="image" accept="image/*" class="hidden" id="main-image-input" onchange="previewMainImage(this)">
                                <p class="text-xs text-gray-500">Click or drag main image (preview below)</p>
                                <div id="main-image-preview" class="mt-3 p-2 bg-gray-50 rounded-lg hidden">
                                    <img id="main-preview-img" class="max-h-32 rounded object-cover">
                                    <button type="button" onclick="clearMainImage()" class="mt-1 px-2 py-1 text-xs bg-red-500 text-white rounded">Remove</button>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1.5">Additional Images</label>


<div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-8 text-center hover:border-orange-400 dark:hover:border-orange-400 transition cursor-pointer" onclick="document.getElementById('additional-image-input').click()">

                                <i class="fa fa-images text-3xl text-gray-400 mb-2"></i>
                                <input type="file" name="additional_image[]" multiple accept="image/*" class="hidden" id="additional-image-input" onchange="previewAdditionalImages(this)">
                                <p class="text-xs text-gray-500">Click or drag additional images (preview below)</p>
                                <div id="additional-images-preview" class="mt-3 p-2 bg-gray-50 rounded-lg hidden grid grid-cols-2 md:grid-cols-3 gap-2"></div>
                            </div>

                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                        <a href="{{ route('vendor.products.index') }}" class="px-6 py-2.5 border border-gray-200 text-gray-700 text-xs rounded-lg hover:bg-gray-50">Cancel</a>
                        <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-orange-500 to-orange-600 text-white text-xs rounded-lg hover:from-orange-600 hover:to-orange-700 shadow-lg">
                            <i class="fa fa-save mr-1"></i>Create Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- CKEditor --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {

                // 👇 directly editable area ki height set karo
                editor.editing.view.change(writer => {
                    writer.setStyle(
                        'min-height',
                        '300px',
                        editor.editing.view.document.getRoot()
                    );
                });

            })
            .catch(console.error);

        function previewMainImage(input) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('main-preview-img').src = e.target.result;
                    document.getElementById('main-image-preview').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        }

        function clearMainImage() {
            document.getElementById('main-image-input').value = '';
            document.getElementById('main-image-preview').classList.add('hidden');
        }

        function previewAdditionalImages(input) {
            const files = input.files;
            const preview = document.getElementById('additional-images-preview');
            preview.innerHTML = '';
            preview.classList.remove('hidden');

            Array.from(files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative group';
                    div.innerHTML = `
        <img src="${e.target.result}" class="w-full h-24 object-cover rounded">
        <button type="button" onclick="removeAdditionalImage(${index})" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs group-hover:opacity-100 opacity-0 transition">×</button>
      `;
                    preview.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        }

        function removeAdditionalImage(index) {
            // Note: This removes preview only. File input reset if needed
            const previews = document.querySelectorAll('#additional-images-preview .relative');
            if (previews[index]) {
                previews[index].remove();
            }
        }

        function generateSKU() {
            document.getElementById('sku').value = 'VPRD' + Date.now().toString().slice(-6);
        }
        generateSKU();
    </script>
    </xai:function_call>

    <xai:function_call name="attempt_completion">
        <parameter name="result">


            @endsection