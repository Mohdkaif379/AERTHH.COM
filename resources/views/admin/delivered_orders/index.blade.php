@extends('layout.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h3 class="text-sm font-medium text-gray-700 flex items-center space-x-2">
                <i class="fas fa-check-circle text-emerald-500 text-sm"></i>
                <span>Delivered Orders</span>
            </h3>
            <p class="text-[10px] text-gray-400">Browse all orders with <span class="font-medium text-emerald-600">delivered</span> status</p>
        </div>

        <div class="w-full lg:w-[360px]">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input
                    type="text"
                    id="deliveredOrderSearch"
                    placeholder="Search order, customer, product..."
                    class="w-full pl-8 pr-3 py-2 bg-white border border-gray-200 rounded-lg focus:border-emerald-300 focus:outline-none focus:ring-1 focus:ring-emerald-100 text-xs"
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

    <div class="bg-white rounded-xl border border-emerald-100/50 shadow-sm overflow-hidden">
        <div class="px-4 sm:px-6 py-4 bg-gradient-to-r from-emerald-50 to-teal-50 border-b border-emerald-100/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <h3 class="text-sm font-semibold text-gray-700 flex items-center space-x-2">
                <i class="fas fa-list text-emerald-500 text-sm"></i>
                <span>Delivered List</span>
            </h3>

            <span class="text-[10px] text-gray-500">
                Total: {{ $orders->total() }} orders
            </span>
        </div>

        @if($orders->count() > 0)
            <div class="md:hidden divide-y divide-gray-100" id="deliveredOrderMobileList">
                @foreach($orders as $index => $order)
                    @php
                        $customerName = trim(($order->customer->first_name ?? '') . ' ' . ($order->customer->last_name ?? '')) ?: 'Unknown Customer';
                        $productName = $order->product->product_name ?? 'Unknown Product';
                        $vendorName = $order->vendor->name ?? 'Unknown Vendor';
                    @endphp
                    <div class="p-4 space-y-3 delivered-order-card" data-search="{{ strtolower($order->order_no.' '.$customerName.' '.$productName.' '.$vendorName.' '.$order->status) }}">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-[10px] uppercase tracking-wide text-gray-400">Order #{{ ($orders->currentPage() - 1) * $orders->perPage() + $index + 1 }}</p>
                                <h4 class="text-sm font-semibold text-gray-800">{{ $order->order_no ?? 'N/A' }}</h4>
                            </div>
                            <span class="px-2 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100 uppercase tracking-tighter shadow-sm">
                                Delivered
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
                            <tr class="hover:bg-emerald-50/30 transition delivered-order-row" data-search="{{ strtolower($order->order_no.' '.$customerName.' '.$productName.' '.$vendorName.' '.$order->status) }}">
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
                                    <span class="px-2 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100 uppercase tracking-tighter shadow-sm">
                                        Delivered
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

            <div id="deliveredOrderNoResult" class="hidden px-6 py-16 text-center text-gray-400">
                <i class="fas fa-search text-3xl mb-3 block text-gray-300"></i>
                No matching delivered orders found
            </div>

            <div class="px-4 sm:px-6 py-4 border-t border-gray-100" id="deliveredOrderPagination">
                {{ $orders->links() }}
            </div>
        @else
            <div class="px-6 py-16 text-center text-gray-400" id="deliveredOrderEmptyState">
                <i class="fas fa-check-circle text-3xl mb-3 block text-gray-300"></i>
                No orders have been delivered yet
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('deliveredOrderSearch');
        if (!searchInput) return;

        const rows = Array.from(document.querySelectorAll('.delivered-order-row'));
        const cards = Array.from(document.querySelectorAll('.delivered-order-card'));
        const pagination = document.getElementById('deliveredOrderPagination');
        const noResultState = document.getElementById('deliveredOrderNoResult');

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
