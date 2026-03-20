@extends('layout.app')
@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    {{-- Header Section - Same as Index --}}
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-sm font-medium text-gray-700">Product Details</h3>
            <p class="text-[10px] text-gray-400">View complete product information</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('products.edit', $product->id) }}" 
               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-cyan-500 to-emerald-500 text-white text-xs font-medium rounded-lg hover:from-cyan-600 hover:to-emerald-600 transition-all duration-200 shadow-sm">
                <i class="fas fa-edit mr-2"></i>
                Edit Product
            </a>
            <a href="{{ route('products.index') }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-200 text-gray-600 text-xs font-medium rounded-lg hover:bg-gray-50 transition-all duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Back
            </a>
        </div>
    </div>

    {{-- Status Badges - Simple like Index --}}
    <div class="flex flex-wrap gap-3">
        <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-medium {{ $product->status ? 'bg-green-50 text-green-600' : 'bg-gray-50 text-gray-500' }}">
            <i class="fas fa-circle mr-1 text-[6px] {{ $product->status ? 'text-green-500' : 'text-gray-400' }}"></i>
            {{ $product->status ? 'Active' : 'Inactive' }}
        </span>
        <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-medium bg-blue-50 text-blue-600">
            <i class="fas fa-tag mr-1"></i>
            {{ ucfirst($product->product_type ?? 'physical') }}
        </span>
        @if($product->stock_quantity > 10)
            <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-medium bg-green-50 text-green-600">
                <i class="fas fa-boxes mr-1"></i>
                {{ $product->stock_quantity }} in stock
            </span>
        @elseif($product->stock_quantity > 0)
            <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-medium bg-yellow-50 text-yellow-600">
                <i class="fas fa-exclamation-triangle mr-1"></i>
                Low stock: {{ $product->stock_quantity }}
            </span>
        @else
            <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-medium bg-rose-50 text-rose-600">
                <i class="fas fa-times-circle mr-1"></i>
                Out of stock
            </span>
        @endif
    </div>

    {{-- Single Card --}}
    <div class="bg-white rounded-xl border border-cyan-100/50 shadow-sm overflow-hidden">
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-1 space-y-4">
                    <div>
                        <h3 class="text-xs font-semibold text-gray-700 flex items-center space-x-2 mb-2">
                            <i class="fas fa-image text-gray-500 text-sm"></i><span>Main Image</span>
                        </h3>
                        @if($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}" class="w-full rounded-lg border border-gray-200" alt="{{ $product->product_name }}">
                        @else
                            <div class="w-full aspect-square bg-gray-100 rounded-lg flex items-center justify-center border border-gray-200">
                                <i class="fas fa-image text-gray-400 text-3xl"></i>
                            </div>
                        @endif
                    </div>
                    @php
                        $additionalImages = null;
                        if($product->additional_image){
                            $additionalImages = is_string($product->additional_image) ? json_decode($product->additional_image, true) : $product->additional_image;
                        }
                    @endphp
                    @if(is_array($additionalImages) && count($additionalImages) > 0)
                    <div>
                        <h3 class="text-xs font-semibold text-gray-700 flex items-center space-x-2 mb-2">
                            <i class="fas fa-images text-gray-500 text-sm"></i><span>Additional Images</span>
                        </h3>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach($additionalImages as $image)
                                <img src="{{ asset('storage/'.$image) }}" class="w-full aspect-square rounded-lg object-cover border border-gray-200">
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <div class="lg:col-span-2 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="text-xs font-semibold text-gray-700 flex items-center space-x-2 mb-1">
                                <i class="fas fa-info-circle text-gray-500 text-sm"></i><span>Basic Information</span>
                            </h4>
                            <dl class="space-y-2 text-sm text-gray-800">
                                <div><span class="font-semibold">Product:</span> {{ $product->product_name }}</div>
                                <div><span class="font-semibold">SKU:</span> {{ $product->sku ?? '�' }}</div>
                                <div><span class="font-semibold">Category:</span>
                                    @if($product->category) {{ $product->category->name }} @endif
                                    @if($product->subCategory) - {{ $product->subCategory->name }} @endif
                                    @if($product->subSubCategory) - {{ $product->subSubCategory->name }} @endif
                                    @if(!$product->category && !$product->subCategory && !$product->subSubCategory) � @endif
                                </div>
                            </dl>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold text-gray-700 flex items-center space-x-2 mb-1">
                                <i class="fas fa-rupee-sign text-gray-500 text-sm"></i><span>Pricing & Stock</span>
                            </h4>
                            <dl class="space-y-2 text-sm text-gray-800">
                                <div><span class="font-semibold">Unit Price:</span> ₹{{ number_format($product->unit_price, 2) }}</div>
                                <div><span class="font-semibold">Product Unit:</span> {{ $product->product_unit ?? '—' }}</div>
                                <div><span class="font-semibold">Discount:</span>
                                    @if($product->discount)
                                        @if($product->discount_type == 'percent')
                                            {{ $product->discount }}% off
                                        @else
                                           ₹ {{ number_format($product->discount, 2) }} off
                                        @endif
                                    @else
                                        �
                                    @endif
                                </div>
                                <div><span class="font-semibold">Stock:</span> {{ $product->stock_quantity }}</div>
                            </dl>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="text-xs font-semibold text-gray-700 flex items-center space-x-2 mb-1">
                                <i class="fas fa-sliders-h text-gray-500 text-sm"></i><span>Brand & Attribute</span>
                            </h4>
                            <dl class="space-y-2 text-sm text-gray-800">
                                <div><span class="font-semibold">Brand:</span> {{ $product->brand->name ?? '�' }}</div>
                                <div><span class="font-semibold">Attribute:</span>
                                    @if($product->attribute)
                                        {{ $product->attribute->attribute_name }} @if($product->attribute_value) - {{ $product->attribute_value }} @endif
                                    @else
                                        �
                                    @endif
                                </div>
                            </dl>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold text-gray-700 flex items-center space-x-2 mb-1">
                                <i class="fas fa-shipping-fast text-gray-500 text-sm"></i><span>Shipping & Tax</span>
                            </h4>
                            <dl class="space-y-2 text-sm text-gray-800">
                                <div><span class="font-semibold">Shipping:</span> {{ $product->shipping_cost ? '₹'.number_format($product->shipping_cost, 2) : 'Free' }}</div>
                                <div><span class="font-semibold">Tax:</span> {{ $product->tax_amount ? '₹'.number_format($product->tax_amount, 2) : '�' }}</div>
                            </dl>
                        </div>
                    </div>

                    @if($product->tags)
                        @php
                            $tags = is_string($product->tags) ? json_decode($product->tags, true) : $product->tags;
                        @endphp
                        @if(is_array($tags) && count($tags) > 0)
                        <div>
                            <h4 class="text-xs font-semibold text-gray-700 flex items-center space-x-2 mb-2">
                                <i class="fas fa-tags text-gray-500 text-sm"></i><span>Tags</span>
                            </h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach($tags as $tag)
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-[10px] font-medium">#{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    @endif

                    <div>
                        <h4 class="text-xs font-semibold text-gray-700 flex items-center space-x-2 mb-2">
                            <i class="fas fa-align-left text-gray-500 text-sm"></i><span>Description</span>
                        </h4>
                        @if($product->description)
                            <div class="text-sm text-gray-700 prose prose-sm max-w-none">{!! $product->description !!}</div>
                        @else
                            <p class="text-sm text-gray-400">No description provided</p>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="text-xs font-semibold text-gray-700 flex items-center space-x-2 mb-1">
                                <i class="fas fa-calendar-plus text-gray-500 text-sm"></i><span>Created At</span>
                            </h4>
                            <p class="text-sm text-gray-800">{{ $product->created_at ? $product->created_at->format('d M Y, h:i A') : '�' }}</p>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold text-gray-700 flex items-center space-x-2 mb-1">
                                <i class="fas fa-sync-alt text-gray-500 text-sm"></i><span>Last Updated</span>
                            </h4>
                            <p class="text-sm text-gray-800">{{ $product->updated_at ? $product->updated_at->format('d M Y, h:i A') : '�' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
