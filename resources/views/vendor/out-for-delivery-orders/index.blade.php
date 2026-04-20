@extends('vendor.layout.navbar')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Out for Delivery Orders</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">Track delivery status ({{ $orders->total() ?? 0 }})</p>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="exportOutForDeliveryOrders()" class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-lg font-medium shadow-sm hover:shadow transition-all duration-200">
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
                    class="w-full pl-9 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-purple-500/50">
            </div>
            <select id="statusFilter" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800">
                <option value="all">All Status</option>
                <option value="out_for_delivery">Out for Delivery</option>
                <option value="delivered">Delivered</option>
                <option value="failed_delivery">Failed Delivery</option>
            </select>
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
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Order Date</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Actions</th>
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
            <span>Loading out for delivery orders...</span>
        </div>
        <div id="noResults" class="hidden flex items-center justify-center py-12 text-gray-500 dark:text-gray-400">
            <i class="fa fa-truck text-3xl mr-3 opacity-50"></i>
            <span>No out for delivery orders found</span>
        </div>
        <div id="errorState" class="hidden flex items-center justify-center py-12 text-red-500">
            <i class="fa fa-exclamation-triangle text-3xl mr-3"></i>
            <span>Failed to load orders</span>
        </div>
    </div>

    <!-- Pagination -->
    <div id="paginationContainer" class="mt-6">
        {{ $orders->links() }}
    </div>
</div>

<!-- Quick Actions Modal -->
<div id="quickActionModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden p-4" onclick="closeQuickActionModal()">
    <div class="flex items-center justify-center min-h-full" onclick="event.stopPropagation()">
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-200 dark:border-gray-800">
                <h3 id="modalTitle" class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <i class="fa fa-question-circle text-purple-500"></i>
                    Confirm Action
                </h3>
            </div>
            <div class="p-6">
                <p id="modalMessage" class="text-gray-600 dark:text-gray-300 mb-6">Are you sure?</p>
                <div class="flex gap-3">
                    <button onclick="closeQuickActionModal()" class="flex-1 px-4 py-2.5 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-900 dark:text-white rounded-xl transition-all font-medium">
                        Cancel
                    </button>
                    <button id="confirmBtn" onclick="confirmAction()" class="flex-1 px-4 py-2.5 bg-purple-500 hover:bg-purple-600 text-white rounded-xl transition-all font-medium shadow-lg hover:shadow-xl">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const orders = @json($orders ?? []);
    let filteredOrders = [...orders.data];

    function getStatusBadge(status) {
        const badges = {
            'out_for_delivery': {
                label: 'Out for Delivery',
                bg: 'bg-purple-100 text-purple-800 dark:bg-purple-900/40 dark:text-purple-300'
            },
            delivered: {
                label: 'Delivered',
                bg: 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300'
            },
            'failed_delivery': {
                label: 'Failed Delivery',
                bg: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-300'
            },
            returned: {
                label: 'Returned',
                bg: 'bg-orange-100 text-orange-800 dark:bg-orange-900/40 dark:text-orange-300'
            }
        };

        const badge = badges[status] || {label: status, bg: 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300'};

        return `<span class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-full ${badge.bg}">
            ${badge.label}
          </span>`;
    }

    // Render table
    function renderOrders() {
        const tbody = document.getElementById('ordersTableBody');
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;

        filteredOrders = orders.data.filter(order => {
            const customerName = (order.customer?.name || '').toLowerCase();
            const productName = (order.product?.product_name || '').toLowerCase();
            const orderId = order.id.toString();

            const searchMatch = orderId.includes(searchTerm) || customerName.includes(searchTerm) || productName.includes(searchTerm);
            const statusMatch = statusFilter === 'all' || order.status === statusFilter;

            return searchMatch && statusMatch;
        });

        if (filteredOrders.length === 0) {
            document.getElementById('loadingState').classList.add('hidden');
            document.getElementById('noResults').classList.remove('hidden');
            document.getElementById('errorState').classList.add('hidden');
            return;
        }

        document.getElementById('noResults').classList.add('hidden');

        tbody.innerHTML = filteredOrders.map(order => {
            const total = (parseFloat(order.total_price || 0) + parseFloat(order.shipping_cost || 0))
                .toLocaleString('en-IN');
            const date = new Date(order.created_at).toLocaleDateString('en-IN', {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

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
            <div class="text-xs text-gray-500">${order.quantity || 0} items</div>
          </td>
          <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
            ${date}
          </td>
          <td class="px-4 py-3 whitespace-nowrap">
            ${getStatusBadge(order.status)}
          </td>
          <td class="px-4 py-3 whitespace-nowrap">
            <div class="flex items-center gap-1.5">
              <button onclick="viewOrder(${order.id})" class="p-1.5 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-950/30 rounded-md transition" title="View">
                <i class="fa fa-eye text-sm"></i>
              </button>
              <button onclick="markDelivered(${order.id}, '${order.status}')" class="p-1.5 text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-950/30 rounded-md transition" title="Mark Delivered">
                <i class="fa fa-check-circle text-sm"></i>
              </button>
              <button onclick="markFailedDelivery(${order.id})" class="p-1.5 text-yellow-600 hover:bg-yellow-50 dark:hover:bg-yellow-950/30 rounded-md transition" title="Failed Delivery">
                <i class="fa fa-exclamation-triangle text-sm"></i>
              </button>
            </div>
          </td>
        </tr>`;
        }).join('');

        document.getElementById('loadingState').classList.add('hidden');
    }

    // Modal actions
    let currentOrderId = null;
    let currentAction = null;

    window.markDelivered = function(id, status) {
        if (status !== 'out_for_delivery') return;
        currentOrderId = id;
        currentAction = 'delivered';
        document.getElementById('modalTitle').innerHTML = '<i class="fa fa-check-circle text-emerald-500"></i>Delivered';
        document.getElementById('modalMessage').textContent = 'Mark this order as successfully delivered?';
        document.getElementById('confirmBtn').textContent = 'Delivered';
        document.getElementById('confirmBtn').className = 'flex-1 px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl transition-all font-medium shadow-lg hover:shadow-xl';
        document.getElementById('quickActionModal').classList.remove('hidden');
    };

    window.markFailedDelivery = function(id) {
        currentOrderId = id;
        currentAction = 'failed_delivery';
        document.getElementById('modalTitle').innerHTML = '<i class="fa fa-exclamation-triangle text-yellow-500"></i> Mark as Failed Delivery';
        document.getElementById('modalMessage').textContent = 'Mark this order as failed delivery attempt?';
        document.getElementById('confirmBtn').textContent = 'Mark Failed';
        document.getElementById('confirmBtn').className = 'flex-1 px-4 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl transition-all font-medium shadow-lg hover:shadow-xl';
        document.getElementById('quickActionModal').classList.remove('hidden');
    };

    window.confirmAction = function() {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/vendor/out-for-delivery-orders/${currentOrderId}/update-status`;
        form.style.display = 'none';
        
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        
        const statusInput = document.createElement('input');
        statusInput.type = 'hidden';
        statusInput.name = 'status';
        statusInput.value = currentAction;
        
        form.appendChild(csrf);
        form.appendChild(statusInput);
        document.body.appendChild(form);
        form.submit();
    };

    window.closeQuickActionModal = function() {
        document.getElementById('quickActionModal').classList.add('hidden');
        currentOrderId = null;
        currentAction = null;
    };

    window.viewOrder = function(id) {
        window.open(`/vendor/orders/${id}`, '_blank');
    };

    window.exportOutForDeliveryOrders = function() {
        window.open('/vendor/out-for-delivery-orders/export', '_blank');
    };

    // Filter events
    document.getElementById('searchInput').addEventListener('input', renderOrders);
    document.getElementById('statusFilter').addEventListener('change', renderOrders);
    document.getElementById('resetFilters').addEventListener('click', () => {
        document.getElementById('searchInput').value = '';
        document.getElementById('statusFilter').value = 'all';
        renderOrders();
    });

    // Toast helper
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 z-[999] p-4 rounded-xl shadow-2xl text-sm font-medium transform translate-x-full transition-all duration-300 ${
      type === 'success' ? 'bg-purple-500 text-white' : 'bg-red-500 text-white'
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
