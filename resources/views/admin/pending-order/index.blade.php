@extends('layout.app')

@section('title', 'Pending Orders')
@section('page-title', 'Pending Orders')
@section('page-subtitle', 'Orders that are still waiting for confirmation or processing')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h3 class="text-sm font-medium text-gray-700 flex items-center space-x-2">
                <i class="fas fa-clock text-amber-500 text-sm"></i>
                <span>Pending Orders</span>
            </h3>
            <p class="text-[10px] text-gray-400">Browse all orders with <span class="font-medium">pending</span> status</p>
        </div>

        <div class="w-full lg:w-[360px]">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input
                    type="text"
                    id="pendingOrderSearch"
                    placeholder="Search order, customer, product..."
                    class="w-full pl-8 pr-3 py-2 bg-white border border-gray-200 rounded-lg focus:border-amber-300 focus:outline-none focus:ring-1 focus:ring-amber-100 text-xs"
                >
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-amber-100/50 shadow-sm overflow-hidden">
        <div class="px-4 sm:px-6 py-4 bg-gradient-to-r from-amber-50 to-orange-50 border-b border-amber-100/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <h3 class="text-sm font-semibold text-gray-700 flex items-center space-x-2">
                <i class="fas fa-list text-amber-500 text-sm"></i>
                <span>Pending Orders List</span>
            </h3>

            <span class="text-[10px] text-gray-500">
                Total: {{ $pendingOrders->total() }} orders
            </span>
        </div>

        @if($pendingOrders->count() > 0)
            <div class="md:hidden divide-y divide-gray-100" id="pendingOrderMobileList">
                @foreach($pendingOrders as $index => $order)
                    @php
                        $customerName = trim(($order->customer->first_name ?? '') . ' ' . ($order->customer->last_name ?? '')) ?: 'Unknown Customer';
                        $productName = $order->product->product_name ?? 'Unknown Product';
                        $vendorName = $order->vendor->name ?? 'Unknown Vendor';
                    @endphp
                    <div class="p-4 space-y-3 pending-order-card" data-search="{{ strtolower($order->order_no.' '.$customerName.' '.$productName.' '.$vendorName.' '.$order->payment_status) }}">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-[10px] uppercase tracking-wide text-gray-400">Order #{{ ($pendingOrders->currentPage() - 1) * $pendingOrders->perPage() + $index + 1 }}</p>
                                <h4 class="text-sm font-semibold text-gray-800">{{ $order->order_no ?? 'N/A' }}</h4>
                            </div>
                            <button type="button"
                                    onclick="openOrderStatusModal({{ $order->id }}, '{{ addslashes($order->order_no ?? 'N/A') }}', '{{ addslashes($customerName) }}')"
                                    class="px-2 py-1 rounded-full text-[10px] font-semibold bg-amber-50 text-amber-700 border border-amber-100">
                                Pending
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
                        @foreach($pendingOrders as $index => $order)
                            @php
                                $customerName = trim(($order->customer->first_name ?? '') . ' ' . ($order->customer->last_name ?? '')) ?: 'Unknown Customer';
                                $productName = $order->product->product_name ?? 'Unknown Product';
                                $vendorName = $order->vendor->name ?? 'Unknown Vendor';
                            @endphp
                            <tr class="hover:bg-amber-50/30 transition pending-order-row" data-search="{{ strtolower($order->order_no.' '.$customerName.' '.$productName.' '.$vendorName.' '.$order->payment_status) }}">
                                <td class="px-4 py-3 text-gray-600">
                                    {{ ($pendingOrders->currentPage() - 1) * $pendingOrders->perPage() + $index + 1 }}
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
                                            onclick="openOrderStatusModal({{ $order->id }}, '{{ addslashes($order->order_no ?? 'N/A') }}', '{{ addslashes($customerName) }}')"
                                            class="px-2 py-1 rounded-full text-[10px] font-semibold bg-amber-50 text-amber-700 border border-amber-100">
                                        Pending
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

            <div id="pendingOrderNoResult" class="hidden px-6 py-16 text-center text-gray-400">
                <i class="fas fa-search text-3xl mb-3 block text-gray-300"></i>
                No matching pending orders found
            </div>

            <div class="px-4 sm:px-6 py-4 border-t border-gray-100" id="pendingOrderPagination">
                {{ $pendingOrders->links() }}
            </div>
        @else
            <div class="px-6 py-16 text-center text-gray-400" id="pendingOrderEmptyState">
                <i class="fas fa-inbox text-3xl mb-3 block text-gray-300"></i>
                No pending orders found
            </div>
        @endif
    </div>
</div>

<div id="orderStatusModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" id="orderStatusModalOverlay"></div>
        <div class="relative bg-white rounded-lg max-w-md w-full overflow-hidden">
            <button type="button" onclick="closeOrderStatusModal()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
            <div class="p-6 text-center space-y-3">
                <div class="w-14 h-14 mx-auto bg-amber-50 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-amber-500 text-2xl"></i>
                </div>
                <h3 id="orderStatusModalTitle" class="text-sm font-semibold text-gray-700">Confirm Order Status</h3>
                <p id="orderStatusModalDesc" class="text-xs text-gray-500"></p>
            </div>
            <div class="bg-gray-50 px-6 py-3 flex justify-end space-x-2 rounded-b-lg">
                <button type="button" onclick="closeOrderStatusModal()" class="px-4 py-2 text-xs text-gray-600 hover:bg-gray-100 rounded-lg">Cancel</button>
                <form id="orderStatusForm" method="GET">
                    <button type="submit" class="px-4 py-2 text-xs text-white bg-amber-500 hover:bg-amber-600 rounded-lg">Confirm</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('pendingOrderSearch');
        if (!searchInput) return;

        const rows = Array.from(document.querySelectorAll('.pending-order-row'));
        const cards = Array.from(document.querySelectorAll('.pending-order-card'));
        const pagination = document.getElementById('pendingOrderPagination');
        const noResultState = document.getElementById('pendingOrderNoResult');

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

    function openOrderStatusModal(id, orderNo, customerName) {
        const modal = document.getElementById('orderStatusModal');
        const title = document.getElementById('orderStatusModalTitle');
        const desc = document.getElementById('orderStatusModalDesc');
        const form = document.getElementById('orderStatusForm');

        if (!modal || !title || !desc || !form) return;

        title.textContent = `Confirm order ${orderNo}`;
        desc.textContent = `Are you sure you want to mark ${customerName} order as confirmed?`;
        form.action = `{{ url('admin/confirmed-orders/confirm') }}/${id}`;
        modal.classList.remove('hidden');
    }

    function closeOrderStatusModal() {
        const modal = document.getElementById('orderStatusModal');
        if (modal) modal.classList.add('hidden');
    }

    document.getElementById('orderStatusModalOverlay')?.addEventListener('click', closeOrderStatusModal);
</script>
@endpush
