@extends('vendor.layout.navbar')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Returned Orders</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Review returned orders ({{ $orders->total() ?? 0 }})</p>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="exportReturnedOrders()" class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-lg font-medium shadow-sm hover:shadow transition-all duration-200">
                <i class="fa fa-download text-sm"></i>
                <span>Export</span>
            </button>
            <a href="{{ route('vendor.dashboard') }}" class="inline-flex items-center gap-2 bg-orange-600 hover:bg-orange-700 text-white px-5 py-2.5 rounded-lg font-medium shadow-sm hover:shadow transition-all duration-200">
                <i class="fa fa-arrow-left text-sm"></i>
                <span>Dashboard</span>
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4 mb-6 shadow-sm">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div class="relative">
                <i class="fa fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" id="searchInput" placeholder="Search by Order ID, Customer, Product..."
                    class="w-full pl-9 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-yellow-500/50 focus:border-transparent">
            </div>
            <input type="date" id="dateFilter" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800">
            <select id="reasonFilter" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800">
                <option value="all">All Reasons</option>
            </select>
            <button id="resetFilters" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                <i class="fa fa-undo-alt text-sm"></i> Reset
            </button>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                <thead class="bg-gray-50 dark:bg-gray-800/60">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Order ID</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Customer</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Product</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Return Reason</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Return Date</th>
                    </tr>
                </thead>
                <tbody id="ordersTableBody" class="divide-y divide-gray-200 dark:divide-gray-800">
                    <!-- Dynamic content loaded by JS -->
                </tbody>
            </table>
        </div>

        <!-- Loading & Empty States -->
        <div id="loadingState" class="flex items-center justify-center py-12 text-gray-500 dark:text-gray-400">
            <i class="fa fa-spinner fa-pulse text-3xl mr-3"></i>
            <span>Loading returned orders...</span>
        </div>
        <div id="noResults" class="hidden flex items-center justify-center py-12 text-gray-500 dark:text-gray-400">
            <i class="fa fa-undo text-3xl mr-3 opacity-50 text-yellow-500"></i>
            <span>No returned orders found</span>
        </div>
        <div id="errorState" class="hidden flex items-center justify-center py-12 text-red-500">
            <i class="fa fa-exclamation-triangle text-3xl mr-3"></i>
            <span>Failed to load orders</span>
        </div>
    </div>

    <!-- Pagination Placeholder -->
    <div id="paginationContainer" class="mt-6">
        {{ $orders->appends(request()->query())->links() }}
    </div>
</div>

<script>
    const orders = @json($orders ?? []);
    let filteredOrders = [...orders.data];

    function getReturnBadge(reason) {
        return `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-300">
            ${reason || 'N/A'}
        </span>`;
    }

    function getUniqueReasons() {
        const reasons = [...new Set(orders.data.map(order => (order.cancel_reason || '').toLowerCase().trim()).filter(Boolean))];
        const reasonFilter = document.getElementById('reasonFilter');
        reasons.forEach(reason => {
            const option = document.createElement('option');
            option.value = reason;
            option.textContent = reason.charAt(0).toUpperCase() + reason.slice(1);
            reasonFilter.appendChild(option);
        });
    }

    function renderOrders() {
        const tbody = document.getElementById('ordersTableBody');
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const dateFilter = document.getElementById('dateFilter').value;
        const reasonFilter = document.getElementById('reasonFilter').value;

        filteredOrders = orders.data.filter(order => {
            const customerName = ((order.customer?.first_name || '') + ' ' + (order.customer?.last_name || '')).toLowerCase();
            const productName = (order.product?.product_name || '').toLowerCase();
            const orderId = order.id.toString().toLowerCase();
            const orderReason = (order.cancel_reason || '').toLowerCase();
            const updatedAt = new Date(order.updated_at || order.created_at);

            const searchMatch = orderId.includes(searchTerm) || customerName.includes(searchTerm) || productName.includes(searchTerm) || orderReason.includes(searchTerm);
            const dateMatch = !dateFilter || updatedAt.toDateString() === new Date(dateFilter).toDateString();
            const reasonMatch = reasonFilter === 'all' || orderReason.includes(reasonFilter);

            return searchMatch && dateMatch && reasonMatch;
        });

        if (filteredOrders.length === 0) {
            document.getElementById('loadingState').classList.add('hidden');
            document.getElementById('noResults').classList.remove('hidden');
            document.getElementById('errorState').classList.add('hidden');
            return;
        }

        document.getElementById('noResults').classList.add('hidden');
        document.getElementById('errorState').classList.add('hidden');

        tbody.innerHTML = filteredOrders.map(order => {
            const total = (parseFloat(order.total_price || 0) + parseFloat(order.shipping_cost || 0)).toLocaleString('en-IN');
            const date = new Date(order.updated_at || order.created_at).toLocaleDateString('en-IN', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });

            return `
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="font-mono text-sm font-semibold text-gray-900 dark:text-white">#${order.id}</div>
                    </td>
                    <td class="px-4 py-3">
                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                            ${order.customer 
                            ? [order.customer.first_name, order.customer.last_name]
                                .filter(Boolean)
                                .join(' ')
                                .replace(/\b\w/g, c => c.toUpperCase())
                            : 'N/A'}
                        </div>
                        <div class="text-xs text-gray-500">${order.customer?.phone || order.customer?.email || '—'}</div>
                    </td>
                    <td class="px-4 py-3">
                        <div class="text-sm font-medium text-gray-900 dark:text-white">${order.product?.product_name || 'N/A'}</div>
                        <div class="text-xs text-gray-500">${order.quantity || 0} items</div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap font-mono">
                        <div class="text-lg font-bold text-gray-900 dark:text-white">₹${total}</div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        ${getReturnBadge(order.cancel_reason)}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                        ${date}
                    </td>
                </tr>`;
        }).join('');

        document.getElementById('loadingState').classList.add('hidden');
    }

    // Utility functions
    window.viewOrder = function(id) {
        window.open(`/vendor/orders/${id}`, '_blank');
    };

    window.printInvoice = function(id) {
        window.open(`/vendor/returned-orders/${id}/invoice`, '_blank');
    };

    window.exportReturnedOrders = function() {
        window.open('/vendor/returned-orders/export', '_blank');
    };

    // Filter events
    document.addEventListener('DOMContentLoaded', function() {
        getUniqueReasons(); // Populate dynamic reasons

        document.getElementById('searchInput').addEventListener('input', renderOrders);
        document.getElementById('dateFilter').addEventListener('change', renderOrders);
        document.getElementById('reasonFilter').addEventListener('change', renderOrders);
        document.getElementById('resetFilters').addEventListener('click', function() {
            document.getElementById('searchInput').value = '';
            document.getElementById('dateFilter').value = '';
            document.getElementById('reasonFilter').value = 'all';
            renderOrders();
        });

        // Initial render
        renderOrders();
    });

    // Toast notifications
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 z-[999] p-4 rounded-xl shadow-2xl text-sm font-medium transform translate-x-full transition-all duration-300 ${
            type === 'success' ? 'bg-emerald-500 text-white' : 'bg-red-500 text-white'
        }`;
        toast.textContent = message;
        document.body.appendChild(toast);
        setTimeout(() => toast.classList.remove('translate-x-full'), 100);
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
</script>

@endsection