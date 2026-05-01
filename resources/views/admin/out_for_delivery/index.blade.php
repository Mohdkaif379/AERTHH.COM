@extends('layout.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h3 class="text-sm font-medium text-gray-700 flex items-center space-x-2">
                <i class="fas fa-truck text-indigo-500 text-sm"></i>
                <span>Out for Delivery Orders</span>
            </h3>
            <p class="text-[10px] text-gray-400">Browse all orders currently <span class="font-medium">in transit</span></p>
        </div>

        <div class="w-full lg:w-[360px]">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input
                    type="text"
                    id="outForDeliverySearch"
                    placeholder="Search order, customer, product..."
                    class="w-full pl-8 pr-3 py-2 bg-white border border-gray-200 rounded-lg focus:border-indigo-300 focus:outline-none focus:ring-1 focus:ring-indigo-100 text-xs"
                >
            </div>
        </div>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
    <div class="m-4 p-3 bg-green-50 border border-green-200 rounded-lg">
        <p class="text-xs text-green-600 flex items-center font-bold">
            <i class="fas fa-check-circle mr-2 text-sm"></i>
            {{ session('success') }}
        </p>
    </div>
    @endif

    <div class="bg-white rounded-xl border border-indigo-100/50 shadow-sm overflow-hidden">
        <div class="px-4 sm:px-6 py-4 bg-gradient-to-r from-indigo-50 to-blue-50 border-b border-indigo-100/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <h3 class="text-sm font-semibold text-gray-700 flex items-center space-x-2">
                <i class="fas fa-list text-indigo-500 text-sm"></i>
                <span>Transit List</span>
            </h3>

            <span class="text-[10px] text-gray-500">
                Total: {{ $orders->total() }} orders
            </span>
        </div>

        @if($orders->count() > 0)
            <div class="md:hidden divide-y divide-gray-100" id="outForDeliveryMobileList">
                @foreach($orders as $index => $order)
                    @php
                        $customerName = trim(($order->customer->first_name ?? '') . ' ' . ($order->customer->last_name ?? '')) ?: 'Unknown Customer';
                        $productName = $order->product->product_name ?? 'Unknown Product';
                        $vendorName = $order->vendor->name ?? 'Unknown Vendor';
                    @endphp
                    <div class="p-4 space-y-3 out-for-delivery-card" data-search="{{ strtolower($order->order_no.' '.$customerName.' '.$productName.' '.$vendorName.' '.$order->status) }}">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-[10px] uppercase tracking-wide text-gray-400">Order #{{ ($orders->currentPage() - 1) * $orders->perPage() + $index + 1 }}</p>
                                <h4 class="text-sm font-semibold text-gray-800">{{ $order->order_no ?? 'N/A' }}</h4>
                            </div>
                            <button type="button" 
                                    onclick="openDeliveredModal({{ $order->id }}, '{{ addslashes($order->order_no ?? 'N/A') }}', '{{ addslashes($customerName) }}')"
                                    class="px-2 py-1 rounded-full text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-100 uppercase tracking-tighter transition-all duration-300 shadow-sm">
                                Out for Delivery
                            </button>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                            <div>
                                <p class="text-gray-400">Customer</p>
                                <p class="text-gray-700 font-medium">{{ $customerName }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400">Product</p>
                                <p class="text-gray-700 font-medium">{{ $productName }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400">Vendor</p>
                                <p class="text-gray-700 font-medium">{{ $vendorName }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400">Total</p>
                                <p class="text-gray-700 font-medium">₹{{ number_format((float) $order->total_price, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400">Qty</p>
                                <p class="text-gray-700 font-medium">{{ $order->quantity }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400">Created</p>
                                <p class="text-gray-700 font-medium">{{ optional($order->created_at)->format('d M Y, h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-xs">
                    <thead>
                        <tr class="bg-gray-50 border-y border-gray-100">
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Sr.No</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Order No</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Customer</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Product</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Vendor</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Qty</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Total</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Status</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Created</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($orders as $index => $order)
                            @php
                                $customerName = trim(($order->customer->first_name ?? '') . ' ' . ($order->customer->last_name ?? '')) ?: 'Unknown Customer';
                                $productName = $order->product->product_name ?? 'Unknown Product';
                                $vendorName = $order->vendor->name ?? 'Unknown Vendor';
                            @endphp
                            <tr class="hover:bg-indigo-50/30 transition out-for-delivery-row" data-search="{{ strtolower($order->order_no.' '.$customerName.' '.$productName.' '.$vendorName.' '.$order->status) }}">
                                <td class="px-4 py-3 text-gray-600">
                                    {{ ($orders->currentPage() - 1) * $orders->perPage() + $index + 1 }}
                                </td>
                                <td class="px-4 py-3 text-gray-700 font-medium">
                                    {{ $order->order_no ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3 text-gray-700">
                                    {{ $customerName }}
                                </td>
                                <td class="px-4 py-3 text-gray-700">
                                    {{ $productName }}
                                </td>
                                <td class="px-4 py-3 text-gray-700">
                                    {{ $vendorName }}
                                </td>
                                <td class="px-4 py-3 text-gray-700">
                                    {{ $order->quantity }}
                                </td>
                                <td class="px-4 py-3 text-gray-700">
                                    ₹{{ number_format((float) $order->total_price, 2) }}
                                </td>
                                <td class="px-4 py-3">
                                    <button type="button" 
                                            onclick="openDeliveredModal({{ $order->id }}, '{{ addslashes($order->order_no ?? 'N/A') }}', '{{ addslashes($customerName) }}')"
                                            class="px-2 py-1 rounded-full text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-100 uppercase tracking-tighter transition-all duration-300 shadow-sm">
                                        {{ str_replace('_', ' ', $order->status) }}
                                    </button>
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    {{ optional($order->created_at)->format('d M Y, h:i A') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div id="outForDeliveryNoResult" class="hidden px-6 py-16 text-center text-gray-400">
                <i class="fas fa-search text-3xl mb-3 block text-gray-300"></i>
                No matching transit orders found
            </div>

            <div class="px-4 sm:px-6 py-4 border-t border-gray-100" id="outForDeliveryPagination">
                {{ $orders->links() }}
            </div>
        @else
            <div class="px-6 py-16 text-center text-gray-400" id="outForDeliveryEmptyState">
                <i class="fas fa-truck text-3xl mb-3 block text-gray-300"></i>
                No orders currently in transit
            </div>
        @endif
    </div>
</div>

{{-- Delivered Modal --}}
<div id="deliveredModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 py-6">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="deliveredModalOverlay" onclick="closeDeliveredModal()"></div>
        <div class="relative bg-white rounded-xl max-w-md w-full overflow-hidden shadow-2xl transform transition-all border border-indigo-100">
            <button type="button" onclick="closeDeliveredModal()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times"></i>
            </button>
            <div class="p-8 text-center space-y-4">
                <div class="w-16 h-16 mx-auto bg-emerald-50 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-double text-emerald-500 text-3xl"></i>
                </div>
                <div class="space-y-1">
                    <h3 id="deliveredModalTitle" class="text-base font-bold text-gray-800 tracking-tight uppercase">Mark as Delivered</h3>
                    <p id="deliveredModalDesc" class="text-[11px] text-gray-500 leading-relaxed"></p>
                </div>
            </div>
            <div class="bg-gray-50 px-8 py-4 flex justify-end space-x-3 rounded-b-xl border-t border-gray-100">
                <button type="button" onclick="closeDeliveredModal()" class="px-5 py-2 text-[10px] font-bold text-gray-500 hover:bg-gray-200 rounded-lg uppercase tracking-wider transition-all duration-200">Cancel</button>
                <form id="deliveredForm" method="GET">
                    <button type="submit" class="px-5 py-2 text-[10px] font-bold text-white bg-emerald-500 hover:bg-emerald-600 rounded-lg uppercase tracking-wider shadow-lg shadow-emerald-200 transition-all duration-200">Confirm Delivery</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('outForDeliverySearch');
        if (!searchInput) return;

        const rows = Array.from(document.querySelectorAll('.out-for-delivery-row'));
        const cards = Array.from(document.querySelectorAll('.out-for-delivery-card'));
        const pagination = document.getElementById('outForDeliveryPagination');
        const noResultState = document.getElementById('outForDeliveryNoResult');

        const applyFilter = () => {
            const query = searchInput.value.trim().toLowerCase();
            let visibleCount = 0;

            const match = (el) => {
                const haystack = el.getAttribute('data-search') || '';
                const isVisible = haystack.includes(query);
                el.style.display = isVisible ? '' : 'none';
                if (isVisible) visibleCount++;
            };

            rows.forEach(match);
            cards.forEach(match);

            if (pagination) {
                pagination.classList.toggle('hidden', query.length > 0);
            }

            if (noResultState) {
                noResultState.classList.toggle('hidden', !(query.length > 0 && visibleCount === 0));
            }
        };

        searchInput.addEventListener('input', applyFilter);
    });

    function openDeliveredModal(id, orderNo, customerName) {
        const modal = document.getElementById('deliveredModal');
        const title = document.getElementById('deliveredModalTitle');
        const desc = document.getElementById('deliveredModalDesc');
        const form = document.getElementById('deliveredForm');

        if (!modal || !title || !desc || !form) return;

        title.textContent = `Confirm Delivery: ${orderNo}`;
        desc.textContent = `Has the order for ${customerName} been successfully delivered to the customer?`;
        form.action = `{{ url('admin/delivered-orders/move') }}/${id}`;
        
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeDeliveredModal() {
        const modal = document.getElementById('deliveredModal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    }
</script>
@endpush
