@extends('vendor.layout.navbar')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Delivered Orders</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Successfully delivered orders ({{ $orders->total() ?? 0 }})</p>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="exportDeliveredOrders()" class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-lg font-medium shadow-sm hover:shadow transition-all duration-200">
                <i class="fa fa-download text-sm"></i>
                <span>Export</span>
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4 mb-6 shadow-sm">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div class="relative">
                <i class="fa fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" id="searchInput" placeholder="Search by Order ID, Customer..."
                    class="w-full pl-9 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-emerald-500/50">
            </div>
            <input type="date" id="dateFilter" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800">
            <select id="dateRange" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800">
                <option value="all">All Time</option>
                <option value="week">Last 7 Days</option>
                <option value="month">Last 30 Days</option>
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
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Delivery Date</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Status</th>
                    </tr>

                </thead>
                <tbody id="ordersTableBody" class="divide-y divide-gray-200 dark:divide-gray-800">
                    <!-- Dynamic content -->
                </tbody>
            </table>
        </div>

        <!-- States -->
        <div id="loadingState" class="flex items-center justify-center py-12 text-gray-500 dark:text-gray-400">
            <i class="fa fa-spinner fa-pulse text-3xl mr-3"></i>
            <span>Loading delivered orders...</span>
        </div>
        <div id="noResults" class="hidden flex items-center justify-center py-12 text-gray-500 dark:text-gray-400">
            <i class="fa fa-check-circle text-3xl mr-3 opacity-50 text-emerald-500"></i>
            <span>No delivered orders found</span>
        </div>
    </div>

    <!-- Pagination -->
    <div id="paginationContainer" class="mt-6">
        {{ $orders->links() }}
    </div>
</div>

<script>
    const orders = @json($orders ?? []);
    let filteredOrders = [...orders.data];

    function getDeliveryBadge(order) {
        const date = new Date(order.updated_at).toLocaleDateString('en-IN', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
        const time = new Date(order.updated_at).toLocaleTimeString('en-IN', {
            hour: '2-digit',
            minute: '2-digit'
        });
        
        return `<span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-medium rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300">
            <i class="fa fa-check text-emerald-500"></i>
            ${date} ${time}
        </span>`;
    }

    // Render table
    function renderOrders() {
        const tbody = document.getElementById('ordersTableBody');
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const dateFilter = document.getElementById('dateFilter').value;

        filteredOrders = orders.data.filter(order => {
            const customerName = (order.customer?.name || '').toLowerCase();
            const productName = (order.product?.product_name || '').toLowerCase();
            const orderId = order.id.toString();
            const updatedAt = new Date(order.updated_at);

            const searchMatch = orderId.includes(searchTerm) || customerName.includes(searchTerm) || productName.includes(searchTerm);
            
            let dateMatch = true;
            if (dateFilter) {
                const filterDate = new Date(dateFilter);
                dateMatch = updatedAt.toDateString() === filterDate.toDateString();
            }

            return searchMatch && dateMatch;
        });

        if (filteredOrders.length === 0) {
            document.getElementById('loadingState').classList.add('hidden');
            document.getElementById('noResults').classList.remove('hidden');
            return;
        }

        document.getElementById('noResults').classList.add('hidden');

        tbody.innerHTML = filteredOrders.map(order => {
            const total = (parseFloat(order.total_price || 0) + parseFloat(order.shipping_cost || 0))
                .toLocaleString('en-IN');

            return `
        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition">
          <td class="px-4 py-3 whitespace-nowrap">
            <div class="font-mono text-sm font-semibold text-gray-900 dark:text-white">#${order.id}</div>
          </td>
          <td class="px-4 py-3">
           <div class="text-sm font-medium text-gray-900 dark:text-white">
            ${[order.customer?.first_name, order.customer?.last_name]
                .filter(Boolean)
                .map(name => name.charAt(0).toUpperCase() + name.slice(1).toLowerCase())
                .join(' ') || 'N/A'}
            </div>
            <div class="text-xs text-gray-500">${order.customer?.phone || order.customer?.email || '—'}</div>
          </td>
          <td class="px-4 py-3">
            <div class="text-sm font-medium text-gray-900 dark:text-white">${order.product?.product_name || 'N/A'}</div>
            <div class="text-xs text-gray-500">${order.quantity || 0} x ${order.product?.product_unit || 'unit'}</div>
          </td>
          <td class="px-4 py-3 whitespace-nowrap font-mono">
            <div class="text-lg font-bold text-gray-900 dark:text-white">₹${total}</div>
          </td>
          <td class="px-4 py-3 whitespace-nowrap">
            ${getDeliveryBadge(order)}
          </td>
          <td class="px-4 py-3 whitespace-nowrap">
            <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300">
              <i class="fa fa-check-double text-emerald-500"></i>
              Delivered
            </span>
          </td>
        </tr>`;

        }).join('');

        document.getElementById('loadingState').classList.add('hidden');
    }

    window.viewOrder = function(id) {
        window.open(`/vendor/orders/${id}`, '_blank');
    };

    window.printInvoice = function(id) {
        window.open(`/vendor/delivered-orders/${id}/invoice`, '_blank');
    };

    window.exportDeliveredOrders = function() {
        window.open('/vendor/delivered-orders/export', '_blank');
    };

    // Filter events
    document.getElementById('searchInput').addEventListener('input', renderOrders);
    document.getElementById('dateFilter').addEventListener('change', renderOrders);
    document.getElementById('resetFilters').addEventListener('click', () => {
        document.getElementById('searchInput').value = '';
        document.getElementById('dateFilter').value = '';
        renderOrders();
    });

    // Toast helper
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

    // Initial load
    if (orders.data?.length > 0) {
        renderOrders();
    } else {
        document.getElementById('loadingState').classList.remove('hidden');
        setTimeout(() => {
            document.getElementById('loadingState').classList.add('hidden');
            document.getElementById('noResults').classList.remove('hidden');
        }, 800);
    }
</script>

@endsection
