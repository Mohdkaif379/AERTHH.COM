@extends('layout.app')
@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-sm font-medium text-gray-700">Pending Vendor Products</h3>
            <p class="text-[10px] text-gray-400">Manage pending products from vendors</p>
        </div>
       
    </div>

    {{-- Products List Card --}}
    <div class="bg-white rounded-xl border border-cyan-100/50 shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-cyan-50 to-emerald-50 border-b border-cyan-100/50">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-700">Products List</h3>
                
                {{-- Search --}}
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="text" 
                           id="search-input"
                           placeholder="Search products..."
                           class="w-56 pl-8 pr-3 py-1.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none focus:ring-1 focus:ring-cyan-100 transition-all duration-300 text-xs text-gray-600 placeholder-gray-400">
                </div>
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

        {{-- Error Message --}}
        @if(session('error'))
        <div class="m-4 p-3 bg-rose-50 border border-rose-200 rounded-lg">
            <p class="text-xs text-rose-600 flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
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
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Vendor</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Price</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Status</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $index => $product)
                    <tr class="hover:bg-cyan-50/30 transition-colors duration-200">
                        {{-- Serial Number --}}
                        <td class="px-4 py-3 text-gray-600">{{ $products->firstItem() + $index }}</td>
                        
                        {{-- Image --}}
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
                        
                        {{-- Name --}}
                        <td class="px-4 py-3 font-medium text-gray-700">{{ $product->product_name }}</td>
                        
                        {{-- Vendor --}}
                        <td class="px-4 py-3 text-gray-600">{{ $product->vendor ? $product->vendor->name : 'N/A' }}</td>

                        {{-- Price --}}
                        <td class="px-4 py-3 text-gray-600">₹{{ number_format($product->unit_price, 2) }}</td>
                        
                        {{-- Status Button --}}
                        <td class="px-4 py-3">
                            <button type="button"
                                    onclick="openApproveModal({{ $product->id }}, '{{ addslashes($product->product_name) }}')"
                                    class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-medium cursor-pointer hover:opacity-80 transition-opacity bg-yellow-50 text-yellow-600"
                                    title="Click to Approve">
                                <i class="fas fa-clock mr-1 text-[6px] text-yellow-500"></i>
                                {{ ucfirst($product->vendor_product_status ?? 'Pending') }}
                            </button>
                        </td>
                        
                        {{-- Actions --}}
                        <td class="px-4 py-3">
                            <div class="flex items-center space-x-2">
                                {{-- View Button --}}
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
                            No pending products found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Table Footer --}}
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

{{-- Approve Confirmation Modal --}}
<div id="approveModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div id="approveModalOverlay" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-sm font-semibold text-gray-700" id="approveModalTitle">
                            Action on Product
                        </h3>
                        <div class="mt-2">
                            <p class="text-xs text-gray-500" id="approveModalMessage">
                                Are you sure you want to approve or reject this product?
                            </p>
                            <p class="text-xs font-medium text-gray-700 mt-2" id="approveProductName"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse space-y-2 sm:space-y-0 sm:space-x-reverse sm:space-x-3">
                <a href="#" id="approveConfirmButton" 
                   class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-xs font-medium text-white hover:bg-green-700 focus:outline-none sm:w-auto">
                    Approve
                </a>
                <a href="#" id="rejectConfirmButton" 
                   class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-rose-600 text-xs font-medium text-white hover:bg-rose-700 focus:outline-none sm:w-auto">
                    Reject
                </a>
                <button type="button" 
                        onclick="closeApproveModal()"
                        class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-xs font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:w-auto">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>



<script>
// Search functionality
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
// Approve Modal functionality
function openApproveModal(productId, productName) {
    document.getElementById('approveProductName').textContent = `"${productName}"`;
    const approveButton = document.getElementById('approveConfirmButton');
    const rejectButton = document.getElementById('rejectConfirmButton');
    approveButton.href = `{{ url('admin/vendor/products/pending/status') }}/${productId}/approved`;
    rejectButton.href = `{{ url('admin/vendor/products/pending/status') }}/${productId}/rejected`;
    document.getElementById('approveModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeApproveModal() {
    document.getElementById('approveModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

document.getElementById('approveModalOverlay')?.addEventListener('click', closeApproveModal);
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeApproveModal();
});
document.querySelector('#approveModal .bg-white')?.addEventListener('click', function(e) {
    e.stopPropagation();
});
</script>
@endsection