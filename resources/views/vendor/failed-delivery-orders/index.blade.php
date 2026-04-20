@extends('vendor.layout.navbar')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Failed Delivery Orders</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Orders that failed delivery ({{ $orders->total() ?? 0 }})</p>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="exportFailedDeliveryOrders()" class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-lg font-medium shadow-sm hover:shadow transition-all duration-200">
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
                    class="w-full pl-9 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-yellow-500/50">
            </div>
            

            <input type="date" id="dateFilter" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800">
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
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Failed Date</th>
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
            <span>Loading failed delivery orders...</span>
        </div>
        <div id="noResults" class="hidden flex items-center justify-center py-12 text-gray-500 dark:text-gray-400">
            <i class="fa fa-exclamation-triangle text-3xl mr-3 opacity-50 text-yellow-500"></i>
            <span>No failed delivery orders found</span>
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

    function getFailedBadge(status, reason = '') {
        const reasons = {
            'customer_unavailable': 'Customer Unavailable',
            'wrong_address': 'Wrong Address',
            'not_accepting': 'Customer Not Accepting',
            'other': 'Other'
        };
        
        const badgeReason = reasons[reason] || reason || 'Unknown';
        
        return `<span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-300">
            <i class="fa fa-exclamation-triangle text-yellow-500"></i>
            ${badgeReason}
        </span>`;
    }

    function getFailedDate(order) {
        const date = new Date(order.updated_at).toLocaleDateString('en-IN', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
        const time = new Date(order.updated_at).toLocaleTimeString('en-IN', {
            hour: '2-digit',
            minute: '2-digit'
        });
        
        return `<span class="text-xs text-gray-500">${date}<br><span class="opacity-75">${time}</span></span>`;
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
            const reason = order.delivery_reason || '';

            const searchMatch = orderId.includes(searchTerm) || customerName.includes(searchTerm) || productName.includes(searchTerm) || reason.toLowerCase().includes(searchTerm);
            
            let reasonMatch = true;

            let dateMatch = true;
            
            if (dateFilter) {
                const filterDate = new Date(dateFilter);
                const orderDate = new Date(order.updated_at);
                dateMatch = orderDate.toDateString() === filterDate.toDateString();
            }

            return searchMatch && reasonMatch && dateMatch;
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
            <div class="text-xs text-gray-500">${order.product?.sku || '—'}</div>
          </td>
          <td class="px-4 py-3 whitespace-nowrap font-mono">
            <div class="text-lg font-bold text-gray-900 dark:text-white">₹${total}</div>
          </td>
          <td class="px-4 py-3 whitespace-nowrap">
            ${getFailedDate(order)}
          </td>
          <td class="px-4 py-3 whitespace-nowrap">
            <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-300">
              <i class="fa fa-times-circle text-yellow-500"></i>
              Failed Delivery
            </span>
          </td>
        </tr>`;

        }).join('');

        document.getElementById('loadingState').classList.add('hidden');
    }

    window.viewOrder = function(id) {
        window.open(`/vendor/orders/${id}`, '_blank');
    };

    window.retryDelivery = function(id) {
        // Move back to packaging
        showToast('Order moved back to Packaging for retry', 'success');
    };

    window.contactCustomer = function(id) {
        showToast('Contact customer functionality - implement WhatsApp/email', 'info');
    };

    window.exportFailedDeliveryOrders = function() {
        window.open('/vendor/failed-delivery-orders/export', '_blank');
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
      type === 'success' ? 'bg-yellow-500 text-white' : 'bg-gray-500 text-white'
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
