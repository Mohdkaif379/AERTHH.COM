@extends('layout.app')
@section('content')
<div class="space-y-6">
    {{-- Header with Create Button --}}
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-sm font-medium text-gray-700 flex items-center space-x-2">
                <i class="fas fa-box-open text-cyan-500 text-sm"></i><span>All Products</span>
            </h3>
            <p class="text-[10px] text-gray-400">Manage your product catalog</p>
        </div>
        <a href="{{ route('products.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-cyan-500 to-emerald-500 text-white text-xs font-medium rounded-lg hover:from-cyan-600 hover:to-emerald-600 transition-all duration-200 shadow-sm hover:shadow">
            <i class="fas fa-plus mr-2"></i>
            Add New Product
        </a>
    </div>

    {{-- Filters Card --}}
    <div class="bg-white rounded-xl border border-cyan-100/50 shadow-sm overflow-hidden">
        <form method="GET" action="{{ route('products.index') }}">
            <div class="p-4 bg-gray-50 border-b border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    {{-- Search --}}
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                        <input type="text" 
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Search products..."
                               class="w-full pl-8 pr-3 py-2 bg-white border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none focus:ring-1 focus:ring-cyan-100 transition-all duration-300 text-xs text-gray-600 placeholder-gray-400">
                    </div>

                {{-- Category Filter --}}
                    <select name="category_id" class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none focus:ring-1 focus:ring-cyan-100 transition-all duration-300 text-xs text-gray-600">
                        <option value="">All Categories</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>

                {{-- Brand Filter --}}
                    <select name="brand_id" class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none focus:ring-1 focus:ring-cyan-100 transition-all duration-300 text-xs text-gray-600">
                        <option value="">All Brands</option>
                        @foreach($brands ?? [] as $brand)
                            <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                        @endforeach
                    </select>

                {{-- Status Filter --}}
                    <select name="status" class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none focus:ring-1 focus:ring-cyan-100 transition-all duration-300 text-xs text-gray-600">
                        <option value="">All Status</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-2 mt-3">
                    <a href="{{ route('products.index') }}" class="px-4 py-2 text-xs text-gray-600 hover:bg-gray-100 rounded-lg">Reset</a>
                    <button type="submit" class="px-4 py-2 text-xs text-white bg-cyan-500 hover:bg-cyan-600 rounded-lg">Filter</button>
                </div>
            </div>
        </form>
    </div>

    {{-- Products List Card --}}
    <div class="bg-white rounded-xl border border-cyan-100/50 shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-cyan-50 to-emerald-50 border-b border-cyan-100/50">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-700 flex items-center space-x-2">
                    <i class="fas fa-list text-cyan-500 text-sm"></i><span>Products List</span>
                </h3>
                <span class="text-[10px] text-gray-500 flex items-center space-x-1">
                    <i class="fas fa-box text-gray-400"></i><span>Total: {{ $products->total() }} products</span>
                </span>
            </div>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
        <div class="m-4 p-3 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-xs text-green-600 flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </p>
        </div>
        @endif

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead>
                    <tr class="bg-gray-50 border-y border-gray-100">
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Sr.No</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Image</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Product Name</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">SKU</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Category</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Price</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Product Unit</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Stock</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Status</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $index => $product)
                    <tr class="hover:bg-cyan-50/30 transition-colors duration-200">
                        <td class="px-4 py-3 text-gray-600">{{ $products->firstItem() + $index }}</td>
                        
                        {{-- Image --}}
                        <td class="px-4 py-3">
                            @if($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}" 
                                     class="w-10 h-10 rounded-lg object-cover border border-gray-200"
                                     alt="{{ $product->product_name }}">
                            @else
                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center border border-gray-200">
                                    <i class="fas fa-box text-gray-400"></i>
                                </div>
                            @endif
                        </td>
                        
                        {{-- Product Name --}}
                        <td class="px-4 py-3">
                            <a href="{{ route('products.show', $product->id) }}" class="font-medium text-cyan-700 hover:text-emerald-600 underline-offset-2 hover:underline transition-colors duration-200">
                                {{ $product->product_name }}
                            </a>
                            @if($product->tags)
                                @php
                                    $tags = is_string($product->tags) ? json_decode($product->tags, true) : $product->tags;
                                @endphp
                                @if(is_array($tags) && count($tags) > 0)
                                    <div class="flex gap-1 mt-1 flex-wrap">
                                        @foreach($tags as $tag)
                                            <span class="px-1.5 py-0.5 bg-gray-100 text-gray-600 rounded text-[8px]">{{ $tag }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            @endif
                        </td>
                        
                        {{-- SKU --}}
                        <td class="px-4 py-3 text-gray-600">{{ $product->sku ?? '—' }}</td>
                        
                        {{-- Category --}}
                        <td class="px-4 py-3">
                            <div class="space-y-1">
                                @if($product->category)
                                    <span class="block text-gray-700">{{ $product->category->name }}</span>
                                @endif
                                @if($product->subCategory)
                                    <span class="block text-[8px] text-gray-500">{{ $product->subCategory->name }}</span>
                                @endif
                            </div>
                        </td>
                        
                        {{-- Price --}}
                        <td class="px-4 py-3">
                            <div class="font-medium text-gray-700">₹{{ number_format($product->unit_price, 2) }}</div>
                            @if($product->discount)
                                <div class="text-[8px] text-green-600">
                                    @if($product->discount_type == 'percent')
                                        {{ $product->discount }}% off
                                    @else
                                        ₹{{ number_format($product->discount, 2) }} off
                                    @endif
                                </div>
                            @endif
                        </td>
                        
                        {{-- Unit --}}
                        <td class="px-4 py-3 text-gray-700">
                            {{ $product->product_unit ?? '—' }}
                        </td>
                        
                        {{-- Stock --}}
                        <td class="px-4 py-3">
                            @if($product->stock_quantity > 10)
                                <span class="px-2 py-1 bg-green-50 text-green-600 rounded-full text-[8px] font-medium">
                                    {{ $product->stock_quantity }} in stock
                                </span>
                            @elseif($product->stock_quantity > 0)
                                <span class="px-2 py-1 bg-yellow-50 text-yellow-600 rounded-full text-[8px] font-medium">
                                    Low: {{ $product->stock_quantity }}
                                </span>
                            @else
                                <span class="px-2 py-1 bg-rose-50 text-rose-600 rounded-full text-[8px] font-medium">
                                    Out of stock
                                </span>
                            @endif
                        </td>
                        
                        {{-- Status --}}
                        <td class="px-4 py-3">
                            <button type="button"
                                    onclick="openStatusModal({{ $product->id }}, '{{ $product->product_name }}', {{ $product->status ? 'true' : 'false' }})"
                                    class="inline-flex items-center px-2 py-1 rounded-full text-[8px] font-medium {{ $product->status ? 'bg-green-50 text-green-600' : 'bg-gray-50 text-gray-500' }}">
                                <i class="fas fa-circle mr-1 text-[4px] {{ $product->status ? 'text-green-500' : 'text-gray-400' }}"></i>
                                {{ $product->status ? 'Active' : 'Inactive' }}
                            </button>
                        </td>
                        
                        {{-- Actions --}}
                        <td class="px-4 py-3">
                            <div class="flex items-center space-x-2">
                                {{-- View Button --}}
                                <a href="{{ route('products.show', $product->id) }}" 
                                   class="p-1 hover:bg-blue-50 rounded text-gray-400 hover:text-blue-500 transition-colors duration-200"
                                   title="View">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                                
                                {{-- Edit Button --}}
                                <a href="{{ route('products.edit', $product->id) }}" 
                                   class="p-1 hover:bg-cyan-50 rounded text-gray-400 hover:text-cyan-500 transition-colors duration-200"
                                   title="Edit">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                
                                {{-- Delete Button --}}
                                <button type="button"
                                   onclick="openDeleteModal({{ $product->id }}, '{{ $product->product_name }}')"
                                   class="p-1 hover:bg-rose-50 rounded text-gray-400 hover:text-rose-500 transition-colors duration-200"
                                   title="Delete">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-4 py-8 text-center text-gray-400 text-xs">
                            <i class="fas fa-box-open text-3xl mb-2 block text-gray-300"></i>
                            No products found
                            <a href="{{ route('products.create') }}" class="block mt-2 text-cyan-500 hover:text-cyan-600">
                                Add your first product
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-100">
            {{ $products->links() }}
        </div>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="deleteModalOverlay"></div>
        <div class="relative bg-white rounded-lg max-w-md w-full">
            <div class="p-6">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-rose-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-rose-600"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-700">Delete Product</h3>
                        <p class="text-xs text-gray-500 mt-1">Are you sure you want to delete <span id="deleteItemName" class="font-medium"></span>?</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-3 flex justify-end space-x-2 rounded-b-lg">
                <button onclick="closeDeleteModal()" class="px-4 py-2 text-xs text-gray-600 hover:bg-gray-100 rounded-lg">Cancel</button>
                <form id="deleteForm" method="GET">
                    <button type="submit" class="px-4 py-2 text-xs text-white bg-rose-600 hover:bg-rose-700 rounded-lg">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Delete Modal
let currentDeleteId = null;

function openDeleteModal(id, name) {
    currentDeleteId = id;
    document.getElementById('deleteItemName').textContent = `"${name}"`;
    document.getElementById('deleteForm').action = `{{ url('admin/products/delete') }}/${id}`;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

document.getElementById('deleteModalOverlay')?.addEventListener('click', closeDeleteModal);

// Status Modal
function openStatusModal(id, name, isActive) {
    const modal = document.getElementById('statusModal');
    const title = document.getElementById('statusModalTitle');
    const description = document.getElementById('statusModalDesc');
    const action = document.getElementById('statusForm');
    const onText = isActive ? 'Turn OFF' : 'Turn ON';
    title.textContent = `Want to ${onText} ${name} Status`;
    description.textContent = isActive
        ? 'If disabled this product will be hidden from the website and customer app.'
        : 'If enabled this product will be visible on the website and customer app.';
    action.action = `{{ url('admin/products/status') }}/${id}`;
    modal.classList.remove('hidden');
}

function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
}

document.getElementById('statusModalOverlay')?.addEventListener('click', closeStatusModal);
</script>

{{-- Status Confirmation Modal --}}
<div id="statusModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="statusModalOverlay"></div>
        <div class="relative bg-white rounded-lg max-w-md w-full overflow-hidden">
            <button onclick="closeStatusModal()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
            <div class="p-6 text-center space-y-3">
                <div class="w-14 h-14 mx-auto bg-cyan-50 rounded-full flex items-center justify-center">
                    <i class="fas fa-box text-cyan-500 text-2xl"></i>
                </div>
                <h3 id="statusModalTitle" class="text-sm font-semibold text-gray-700"></h3>
                <p id="statusModalDesc" class="text-xs text-gray-500"></p>
            </div>
            <div class="bg-gray-50 px-6 py-3 flex justify-end space-x-2 rounded-b-lg">
                <button onclick="closeStatusModal()" class="px-4 py-2 text-xs text-gray-600 hover:bg-gray-100 rounded-lg">Cancel</button>
                <form id="statusForm" method="GET">
                    <button type="submit" class="px-4 py-2 text-xs text-white bg-cyan-500 hover:bg-cyan-600 rounded-lg">Ok</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
