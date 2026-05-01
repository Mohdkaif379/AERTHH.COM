@extends('vendor.layout.navbar')

@section('content')
<div class="space-y-6">
    <!-- Header with Tabs -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Activity History</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Track all your past transactions and order statuses.</p>
        </div>
        
        <!-- Tab Navigation -->
        <div class="flex bg-gray-100/80 dark:bg-gray-800/80 p-1 rounded-xl border border-gray-200/50 dark:border-gray-700/50">
            <button onclick="switchTab('orders')" id="tab-btn-orders" class="px-4 py-1.5 text-xs font-bold rounded-lg transition-all duration-300 bg-white dark:bg-gray-700 text-orange-600 dark:text-orange-400 shadow-sm border border-orange-100 dark:border-orange-900/30">
                <i class="fas fa-box mr-1.5"></i> Order History
            </button>
            <button onclick="switchTab('withdrawals')" id="tab-btn-withdrawals" class="px-4 py-1.5 text-xs font-bold rounded-lg transition-all duration-300 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                <i class="fas fa-wallet mr-1.5"></i> Withdrawal History
            </button>
        </div>
    </div>

    <!-- Order History Tab Content -->
    <div id="content-orders" class="tab-content space-y-6">
        @php
            $statusCounts = $orders->getCollection()->groupBy('status')->map->count();
            $totalOrders = $orders->total();
        @endphp

        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <p class="text-sm text-gray-500 dark:text-gray-400">Delivered, cancelled, returned, and failed delivery orders</p>
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" id="orderSearch" placeholder="Search orders..."
                       class="w-full sm:w-64 pl-8 pr-3 py-1.5 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500/30 text-xs">
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach (['delivered' => 'Delivered', 'cancelled' => 'Cancelled', 'returned' => 'Returned', 'failed_delivery' => 'Failed Delivery'] as $key => $label)
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm p-4">
                    <p class="text-[10px] uppercase tracking-wide text-gray-400 font-bold">{{ $label }}</p>
                    <div class="mt-2 flex items-center justify-between">
                        <span class="text-2xl font-black text-gray-900 dark:text-white">{{ $statusCounts[$key] ?? 0 }}</span>
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center
                            @if($key === 'delivered') bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600
                            @elseif($key === 'cancelled') bg-rose-50 dark:bg-rose-900/20 text-rose-600
                            @elseif($key === 'returned') bg-violet-50 dark:bg-violet-900/20 text-violet-600
                            @else bg-red-50 dark:bg-red-900/20 text-red-600 @endif">
                            <i class="fas fa-box text-xs"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Orders List</h3>
                <span class="text-[10px] bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 px-2 py-0.5 rounded-full font-bold">Total {{ $totalOrders }}</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-700">
                            <th class="px-4 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Sr.No</th>
                            <th class="px-4 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Order Details</th>
                            <th class="px-4 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Customer</th>
                            <th class="px-4 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Created</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800" id="orderTableBody">
                        @forelse($orders as $index => $order)
                            @php
                                $badge = match($order->status) {
                                    'delivered' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-200',
                                    'cancelled' => 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-200',
                                    'returned' => 'bg-violet-100 text-violet-700 dark:bg-violet-900/30 dark:text-violet-200',
                                    'failed_delivery' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-200',
                                    default => 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300',
                                };
                            @endphp
                            <tr class="order-row hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                                <td class="px-4 py-4 text-gray-500 text-xs">{{ $orders->firstItem() + $index }}</td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg overflow-hidden border border-gray-100 dark:border-gray-800 shrink-0">
                                            @if(optional($order->product)->image)
                                                <img src="{{ str_starts_with($order->product->image, 'http') ? $order->product->image : asset('storage/'.$order->product->image) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center bg-gray-50 dark:bg-gray-800 text-gray-300"><i class="fas fa-box text-xs"></i></div>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-bold text-gray-900 dark:text-white truncate text-xs">{{ $order->product->product_name ?? 'Unknown Product' }}</p>
                                            <p class="text-[10px] text-gray-500">#{{ $order->order_no ?? $order->id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-xs text-gray-600 dark:text-gray-400">
                                    {{ trim((optional($order->customer)->first_name ?? '') . ' ' . (optional($order->customer)->last_name ?? '')) ?: 'Unknown Customer' }}
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-block px-2 py-0.5 rounded-full text-[9px] font-black uppercase {{ $badge }}">
                                        {{ str_replace('_', ' ', $order->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-[10px] text-gray-400 whitespace-nowrap">
                                    {{ optional($order->created_at)->format('d M Y, h:i A') }}
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-12 text-center text-gray-400 text-xs italic">No order history found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800 flex items-center justify-between">
                <span class="text-[10px] text-gray-400 font-bold uppercase">Entries: {{ $orders->count() }}</span>
                {{ $orders->links() }}
            </div>
        </div>
    </div>

    <!-- Withdrawal History Tab Content -->
    <div id="content-withdrawals" class="tab-content space-y-6 hidden">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <p class="text-sm text-gray-500 dark:text-gray-400">Approved and rejected withdrawal requests</p>
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" id="withdrawalSearch" placeholder="Search withdrawals..."
                       class="w-full sm:w-64 pl-8 pr-3 py-1.5 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500/30 text-xs">
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Withdrawal History List</h3>
                <span class="text-[10px] bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 px-2 py-0.5 rounded-full font-bold">Total {{ $withdrawals->count() }}</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-700">
                            <th class="px-4 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Sr.No</th>
                            <th class="px-4 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Method</th>
                            <th class="px-4 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Details</th>
                            <th class="px-4 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Amount</th>
                            <th class="px-4 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800" id="withdrawalTableBody">
                        @forelse($withdrawals as $index => $withdrawal)
                            @php
                                $statusBadge = match($withdrawal->status) {
                                    'approved' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-200',
                                    'rejected' => 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-200',
                                    default => 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300',
                                };
                            @endphp
                            <tr class="withdrawal-row hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                                <td class="px-4 py-4 text-gray-500 text-xs">{{ $index + 1 }}</td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ $withdrawal->payment_type == 'upi' ? 'bg-blue-50 text-blue-600' : 'bg-purple-50 text-purple-600' }}">
                                            <i class="fas {{ $withdrawal->payment_type == 'upi' ? 'fa-mobile-screen' : 'fa-university' }} text-xs"></i>
                                        </div>
                                        <span class="font-bold text-xs">{{ ucwords(str_replace('_', ' ', $withdrawal->payment_type)) }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-[11px] text-gray-600 dark:text-gray-400">
                                    @if($withdrawal->payment_type == 'upi')
                                        <span class="font-medium">UPI:</span> {{ $withdrawal->upi_id }}
                                    @else
                                        <span class="font-medium">Bank:</span> {{ $withdrawal->bank_name }} ({{ substr($withdrawal->account_number, -4) }})
                                    @endif
                                </td>
                                <td class="px-4 py-4 font-black text-gray-900 dark:text-white text-xs">₹{{ number_format($withdrawal->amount, 2) }}</td>
                                <td class="px-4 py-4">
                                    <span class="inline-block px-2 py-0.5 rounded-full text-[9px] font-black uppercase {{ $statusBadge }}">
                                        {{ $withdrawal->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-[10px] text-gray-400 whitespace-nowrap">
                                    {{ $withdrawal->created_at->format('d M Y, h:i A') }}
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-12 text-center text-gray-400 text-xs italic">No withdrawal history found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function switchTab(tab) {
    // Hide all contents
    document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
    // Show selected content
    document.getElementById('content-' + tab).classList.remove('hidden');
    
    // Update button styles
    const buttons = {
        orders: document.getElementById('tab-btn-orders'),
        withdrawals: document.getElementById('tab-btn-withdrawals')
    };
    
    Object.keys(buttons).forEach(key => {
        if (key === tab) {
            buttons[key].classList.add('bg-white', 'dark:bg-gray-700', 'text-orange-600', 'dark:text-orange-400', 'shadow-sm', 'border', 'border-orange-100', 'dark:border-orange-900/30');
            buttons[key].classList.remove('text-gray-500', 'dark:text-gray-400', 'hover:text-gray-700', 'dark:hover:text-gray-200');
        } else {
            buttons[key].classList.remove('bg-white', 'dark:bg-gray-700', 'text-orange-600', 'dark:text-orange-400', 'shadow-sm', 'border', 'border-orange-100', 'dark:border-orange-900/30');
            buttons[key].classList.add('text-gray-500', 'dark:text-gray-400', 'hover:text-gray-700', 'dark:hover:text-gray-200');
        }
    });
}

// Search functionality
function setupSearch(inputId, rowClass) {
    document.getElementById(inputId)?.addEventListener('input', function () {
        const search = this.value.toLowerCase();
        document.querySelectorAll('.' + rowClass).forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(search) ? '' : 'none';
        });
    });
}

setupSearch('orderSearch', 'order-row');
setupSearch('withdrawalSearch', 'withdrawal-row');
</script>
@endsection
