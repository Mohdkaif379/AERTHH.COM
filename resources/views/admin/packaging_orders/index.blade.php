@extends('layout.app')

@section('title', 'Packaging Orders')
@section('page-title', 'Packaging Orders')
@section('page-subtitle', 'Orders currently in packaging stage')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h3 class="text-sm font-medium text-gray-700 flex items-center space-x-2">
                <i class="fas fa-box-open text-indigo-500 text-sm"></i>
                <span>Packaging Orders</span>
            </h3>
            <p class="text-[10px] text-gray-400">Browse all orders with <span class="font-medium">packaging</span> status</p>
        </div>

        <div class="w-full lg:w-[360px]">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input
                    type="text"
                    id="packagingOrderSearch"
                    placeholder="Search order, customer, product..."
                    class="w-full pl-8 pr-3 py-2 bg-white border border-gray-200 rounded-lg focus:border-indigo-300 focus:outline-none focus:ring-1 focus:ring-indigo-100 text-xs"
                >
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-indigo-100/50 shadow-sm overflow-hidden">
        <div class="px-4 sm:px-6 py-4 bg-gradient-to-r from-indigo-50 to-violet-50 border-b border-indigo-100/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <h3 class="text-sm font-semibold text-gray-700 flex items-center space-x-2">
                <i class="fas fa-list text-indigo-500 text-sm"></i>
                <span>Packaging Orders List</span>
            </h3>

            <span class="text-[10px] text-gray-500">
                Total: {{ $orders->total() }} orders
            </span>
        </div>

        @if($orders->count() > 0)
            <div class="md:hidden divide-y divide-gray-100" id="packagingOrderMobileList">
                @foreach($orders as $index => $order)
                    @php
                        $customerName = trim(($order->customer->first_name ?? '') . ' ' . ($order->customer->last_name ?? '')) ?: 'Unknown Customer';
                        $productName = $order->product->product_name ?? 'Unknown Product';
                        $vendorName = $order->vendor->name ?? 'Unknown Vendor';
                    @endphp
                    <div class="p-4 space-y-3 packaging-order-card" data-search="{{ strtolower($order->order_no.' '.$customerName.' '.$productName.' '.$vendorName.' '.$order->status) }}">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-[10px] uppercase tracking-wide text-gray-400">Order #{{ ($orders->currentPage() - 1) * $orders->perPage() + $index + 1 }}</p>
                                <h4 class="text-sm font-semibold text-gray-800">{{ $order->order_no ?? 'N/A' }}</h4>
                            </div>
                            <span class="px-2 py-1 rounded-full text-[10px] font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                Packaging
                            </span>
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
                            <tr class="hover:bg-indigo-50/30 transition packaging-order-row" data-search="{{ strtolower($order->order_no.' '.$customerName.' '.$productName.' '.$vendorName.' '.$order->status) }}">
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
                                    <span class="px-2 py-1 rounded-full text-[10px] font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                        Packaging
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    {{ optional($order->created_at)->format('d M Y, h:i A') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div id="packagingOrderNoResult" class="hidden px-6 py-16 text-center text-gray-400">
                <i class="fas fa-search text-3xl mb-3 block text-gray-300"></i>
                No matching packaging orders found
            </div>

            <div class="px-4 sm:px-6 py-4 border-t border-gray-100" id="packagingOrderPagination">
                {{ $orders->links() }}
            </div>
        @else
            <div class="px-6 py-16 text-center text-gray-400" id="packagingOrderEmptyState">
                <i class="fas fa-inbox text-3xl mb-3 block text-gray-300"></i>
                No packaging orders found
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('packagingOrderSearch');
        if (!searchInput) return;

        const rows = Array.from(document.querySelectorAll('.packaging-order-row'));
        const cards = Array.from(document.querySelectorAll('.packaging-order-card'));
        const pagination = document.getElementById('packagingOrderPagination');
        const noResultState = document.getElementById('packagingOrderNoResult');

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
</script>
@endpush
