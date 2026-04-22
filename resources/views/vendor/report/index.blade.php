@extends('vendor.layout.navbar')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-orange-600 dark:text-white">Order Report</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                Track orders by status with customer and product details ({{ $orders->total() ?? 0 }} total)
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('vendor.report.export', request()->query()) }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 bg-orange-600 hover:bg-orange-700 text-white px-5 py-2.5 rounded-lg font-medium shadow-sm hover:shadow transition-all duration-200">
                <i class="fa fa-file-pdf text-sm"></i>
                <span>Export</span>
            </a>
            <a href="{{ route('vendor.dashboard') }}" class="inline-flex items-center gap-2 bg-orange-600 hover:bg-orange-700 text-white px-5 py-2.5 rounded-lg font-medium shadow-sm hover:shadow transition-all duration-200">
                <i class="fa fa-arrow-left text-sm"></i>
                <span>Dashboard</span>
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4 mb-6 shadow-sm">
        <form method="GET" action="{{ route('vendor.report.index') }}" id="filterForm">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="relative">
                    <i class="fa fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" id="searchInput" name="search" placeholder="Search orders..." value="{{ request('search') }}" class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all">
                </div>
                <input type="date" id="dateFilter" name="date" value="{{ request('date') }}" class="px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                <select id="statusFilter" name="status" class="px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option value="all">All Status</option>
                    @foreach($statusCounts as $status => $count)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            {{ ucwords(str_replace('_', ' ', $status)) }} ({{ $count }})
                        </option>
                    @endforeach
                </select>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-orange-500 hover:bg-orange-600 text-white px-4 py-3 rounded-lg font-medium shadow-sm hover:shadow transition-all">
                        <i class="fa fa-filter mr-1"></i> Filter
                    </button>
                    <button type="button" onclick="resetFilters()" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white px-4 py-3 rounded-lg font-medium shadow-sm hover:shadow transition-all">
                        <i class="fa fa-undo mr-1"></i> Reset
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700" id="ordersTableBody">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Order ID</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Customer Name</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Customer Phone</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Product Image</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Product Name</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Product Price</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Qty</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($orders as $order)
                        @php
                            $customerName = trim((data_get($order, 'customer.first_name', '') . ' ' . data_get($order, 'customer.last_name', '')));
                            $customerName = $customerName !== '' ? $customerName : data_get($order, 'customer.name', 'N/A');
                            $customerName = $customerName !== 'N/A' ? ucwords(strtolower($customerName)) : $customerName;
                            $customerPhone = data_get($order, 'customer.phone', 'N/A');
                            $productName = data_get($order, 'product.product_name', 'N/A');
                            $productImage = data_get($order, 'product.image');
                            $productImageUrl = $productImage ? asset('storage/' . $productImage) : null;
                            $unitPrice = data_get($order, 'product.unit_price', 0);
                            $shippingCost = (float) ($order->shipping_cost ?? 0);
                            $grandTotal = (float) $order->total_price + $shippingCost;
                        @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap font-mono text-sm font-semibold text-gray-900 dark:text-white">
                                #{{ $order->order_no }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium @if($order->status == 'delivered') bg-green-100 text-green-800 @elseif($order->status == 'cancelled') bg-red-100 text-red-800 @elseif($order->status == 'confirmed') bg-blue-100 text-blue-800 @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ ucwords(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $customerName }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $customerPhone }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($productImageUrl)
                                    <img src="{{ $productImageUrl }}" alt="{{ $productName }}" class="w-12 h-12 rounded-lg object-cover shadow-sm">
                                @else
                                    <div class="w-12 h-12 rounded-lg bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-xs text-gray-500">N/A</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900 dark:text-white">{{ $productName }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                &#8377;{{ number_format((float) $unitPrice, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-white">
                                {{ $order->quantity }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="text-lg font-bold text-gray-900 dark:text-white">&#8377;{{ number_format($grandTotal, 2) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $order->created_at->format('d M Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-12 text-center">
                                <div class="text-gray-500 dark:text-gray-400">
                                    <i class="fa fa-inbox text-4xl mb-4 opacity-50"></i>
                                    <p class="text-lg">No orders found</p>
                                    <p class="text-sm mt-1">Try adjusting your filters</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800">
            {{ $orders->appends(request()->query())->links() }}
        </div>
    </div>
</div>

<script>
    function resetFilters() {
        window.location.href = "{{ route('vendor.report.index') }}";
    }

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('#searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const term = this.value.toLowerCase();
                const rows = document.querySelectorAll('#ordersTableBody tbody tr');
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(term) ? '' : 'none';
                });
            });
        }
    });
</script>
@endsection
