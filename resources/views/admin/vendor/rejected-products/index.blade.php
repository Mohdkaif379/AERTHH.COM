@extends('layout.app')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-sm font-medium text-gray-700">Rejected Vendor Products</h3>
            <p class="text-[10px] text-gray-400">Manage rejected products from vendors</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-cyan-100/50 shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-cyan-50 to-emerald-50 border-b border-cyan-100/50">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-700">Products List</h3>

                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="text"
                           id="search-input"
                           placeholder="Search products..."
                           class="w-56 pl-8 pr-3 py-1.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none focus:ring-1 focus:ring-cyan-100 transition-all duration-300 text-xs text-gray-600 placeholder-gray-400">
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="m-4 p-3 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-xs text-green-600 flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </p>
        </div>
        @endif

        @if(session('error'))
        <div class="m-4 p-3 bg-rose-50 border border-rose-200 rounded-lg">
            <p class="text-xs text-rose-600 flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </p>
        </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead>
                    <tr class="bg-gray-50 border-y border-gray-100">
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Sr.No</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Image</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Product Name</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Vendor</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Price</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Status</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $index => $product)
                    <tr class="hover:bg-cyan-50/30 transition-colors duration-200">
                        <td class="px-4 py-3 text-gray-600">{{ $products->firstItem() + $index }}</td>

                        <td class="px-4 py-3">
                            @if($product->image)
                                <img src="{{ asset($product->image) }}"
                                     class="w-10 h-10 rounded-lg object-cover border border-gray-200"
                                     alt="{{ $product->product_name }}">
                            @else
                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center border border-gray-200">
                                    <i class="fas fa-box text-gray-400"></i>
                                </div>
                            @endif
                        </td>

                        <td class="px-4 py-3 font-medium text-gray-700">{{ $product->product_name }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $product->vendor ? $product->vendor->name : 'N/A' }}</td>
                        <td class="px-4 py-3 text-gray-600">₹{{ number_format($product->unit_price, 2) }}</td>

                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-medium bg-rose-50 text-rose-600">
                                <i class="fas fa-times-circle mr-1 text-[6px] text-rose-500"></i>
                                {{ ucfirst($product->vendor_product_status ?? 'Rejected') }}
                            </span>
                        </td>

                        <td class="px-4 py-3">
                            <div class="flex items-center space-x-2">
                                <a href="#"
                                   class="p-1 hover:bg-cyan-50 rounded text-gray-400 hover:text-cyan-500 transition-colors duration-200"
                                   title="View">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-400 text-xs">
                            <i class="fas fa-box-open text-3xl mb-2 block text-gray-300"></i>
                            No rejected products found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
            <p class="text-[10px] text-gray-400">
                Showing {{ $products->count() }} {{ Str::plural('entry', $products->count()) }}
            </p>
            <div class="text-xs">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('search-input')?.addEventListener('keyup', function() {
    let search = this.value.toLowerCase();
    let rows = document.querySelectorAll('tbody tr');

    rows.forEach(row => {
        let name = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase();
        let vendor = row.querySelector('td:nth-child(4)')?.textContent.toLowerCase();
        if (name || vendor) {
            row.style.display = (name.includes(search) || vendor.includes(search)) ? '' : 'none';
        }
    });
});
</script>
@endsection
