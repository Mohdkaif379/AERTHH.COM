@extends('vendor.layout.navbar')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen dark:from-slate-900 dark:to-slate-800 p-2">

    <!-- Welcome -->
    <div class="mb-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">
                Welcome, <span class="text-orange-500">{{ $vendor->name ?? 'Vendor' }}</span>
            </h2>
            <div class="flex gap-2">
                <a href="{{route('vendor.faq.index')}}" class="px-2 py-1 bg-orange-500 dark:bg-slate-700 text-slate-100 rounded-full text-sm font-medium hover:bg-orange-600 dark:hover:bg-slate-600 transition-colors">
                    <i class="fa-solid fa-circle-question mr-1"></i> FAQ
                </a>
                <a href="{{ route('vendor.privacy-policy.index') }}" class="px-2 py-1 bg-orange-500 dark:bg-slate-700 text-slate-100 rounded-full text-sm font-medium hover:bg-orange-600 dark:hover:bg-slate-600 transition-colors">
                    <i class="fa-solid fa-file-lines mr-1"></i> Policy
                </a>
            </div>
        </div>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
            ₹{{ number_format($profit ?? 0, 0) }} Total Profit | Revenue ₹{{ number_format($revenue ?? 0, 0) }}
        </p>
    </div>

    <!-- Tabs Navigation -->
    <div class="border-b border-gray-200 dark:border-gray-700 mb-6">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <button onclick="switchTab('analytics')" id="tab-analytics" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors border-orange-500 text-orange-600 dark:text-orange-500">
                <i class="fa-solid fa-chart-line mr-2"></i> Analytics
            </button>
            <button onclick="switchTab('orders')" id="tab-orders" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300">
                <i class="fa-solid fa-box mr-2"></i> Recent Orders
            </button>
        </nav>
    </div>

    <!-- Analytics Tab Content -->
    <div id="content-analytics" class="transition-opacity duration-300 opacity-100">

        <!-- Profile + Stats Row -->
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-8">
            <!-- Profile Card -->
            <div class="lg:col-span-2 bg-white/70 dark:bg-slate-800/70 backdrop-blur-xl rounded-3xl p-6 border shadow-2xl">
                <div class="flex items-center gap-4 mb-4">
                    <img src="{{ $vendor->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($vendor->name ?? '') . '&size=64' }}" alt="{{ $vendor->name ?? 'Vendor' }}" class="w-16 h-16 rounded-xl ring-2 ring-emerald-400/50">
                    <div>
                        <h3 class="font-bold text-lg text-gray-900 dark:text-white">{{ $vendor->name }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $vendor->phone ?? 'No phone' }}</p>
                        {{ $vendor->email }}
                        @if($vendor->status == 1)
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs bg-emerald-100 dark:bg-emerald-900/50 text-emerald-800 dark:text-emerald-200 font-medium mt-1">
                            <i class="fa-solid fa-check-circle text-emerald-500"></i> Verified
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs bg-orange-100 dark:bg-orange-900/50 text-orange-800 dark:text-orange-200 font-medium mt-1">
                            <i class="fa-solid fa-clock text-orange-500"></i> Pending
                        </span>
                        @endif
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-2 text-xs">
                    <div class="text-center p-2 bg-emerald-50 dark:bg-emerald-900/30 rounded-lg">
                        <div class="font-bold text-emerald-600 dark:text-emerald-400 text-lg">{{ number_format($revenue ?? 0, 0) }}</div>
                        <div class="text-emerald-800 dark:text-emerald-200 text-xs font-medium">Revenue</div>
                    </div>
                    <div class="text-center p-2 bg-purple-50 dark:bg-purple-900/30 rounded-lg">
                        <div class="font-bold text-purple-600 dark:text-purple-400 text-lg">{{ number_format($profit ?? 0, 0) }}</div>
                        <div class="text-purple-800 dark:text-purple-200 text-xs font-medium">Profit</div>
                    </div>
                    <div class="text-center p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                        <div class="font-bold text-blue-600 dark:text-blue-400 text-lg">{{ \App\Models\Order::where('vendor_id', $vendor->id)->count() ?? 0 }}</div>
                        <div class="text-blue-800 dark:text-blue-200 text-xs font-medium">Orders</div>
                    </div>
                </div>
            </div>

            <!-- 4 Stats Cards -->
            <div class="lg:col-span-3 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Revenue -->
                <div class="bg-gradient-to-br from-white via-emerald-50 to-teal-100 p-4 rounded-2xl text-gray-800 shadow-xl hover:shadow-2xl transition-all border border-emerald-100">

                    <div class="flex items-center gap-2 mb-2">
                        <div class="p-2 bg-emerald-100 rounded-xl">
                            <i class="fa-solid fa-coins text-xl text-emerald-600"></i>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wide text-gray-600">Revenue</span>
                    </div>

                    <div class="text-2xl font-bold text-emerald-700">
                        ₹{{ number_format($revenue ?? 0, 0) }}
                    </div>

                </div>
                <!-- Profit -->
                <div class="bg-gradient-to-br from-white via-purple-50 to-indigo-100 p-4 rounded-2xl text-gray-800 shadow-xl hover:shadow-2xl transition-all border border-purple-100">

                    <div class="flex items-center gap-2 mb-2">
                        <div class="p-2 bg-purple-100 rounded-xl">
                            <i class="fa-solid fa-chart-line text-xl text-purple-600"></i>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wide text-gray-600">Profit</span>
                    </div>

                    <div class="text-2xl font-bold {{ ($profit ?? 0) > 0 ? 'text-purple-600' : 'text-red-500' }}">
                        ₹{{ number_format($profit ?? 0, 0) }}
                    </div>

                </div>
                <!-- Orders -->
                <div class="bg-gradient-to-br from-white via-blue-50 to-cyan-100 p-4 rounded-2xl text-gray-800 shadow-xl hover:shadow-2xl transition-all border border-blue-100">

                    <div class="flex items-center gap-2 mb-2">
                        <div class="p-2 bg-blue-100 rounded-xl">
                            <i class="fa-solid fa-shopping-cart text-xl text-blue-600"></i>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wide text-gray-600">Orders</span>
                    </div>

                    <div class="text-2xl font-bold text-blue-700">
                        {{ \App\Models\Order::where('vendor_id', $vendor->id)->count() ?? 0 }}
                    </div>

                </div>
                <!-- Pending -->
                <div class="bg-gradient-to-br from-white via-orange-50 to-red-100 p-4 rounded-2xl text-gray-800 shadow-xl hover:shadow-2xl transition-all border border-orange-100">

                    <div class="flex items-center gap-2 mb-2">
                        <div class="p-2 bg-orange-100 rounded-xl">
                            <i class="fa-solid fa-clock text-xl text-orange-600"></i>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wide text-gray-600">Pending</span>
                    </div>

                    <div class="text-2xl font-bold text-orange-700">
                        {{ $statusCounts['pending'] ?? 0 }}
                    </div>

                </div>
            </div>
        </div>

        <!-- Status Cards (8 statuses) -->
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-4 mb-8">
            @php $statuses = ['pending', 'confirmed', 'delivered', 'out_for_delivery', 'cancelled', 'packaging', 'failed_delivery', 'returned']; @endphp
            @foreach($statuses as $status)
            <div class="bg-white/70 dark:bg-slate-800/70 p-4 rounded-xl text-center shadow-lg hover:shadow-xl transition-all border">
                <div class="w-12 h-12 mx-auto mb-2 bg-slate-200 dark:bg-slate-700 rounded-xl flex flex-col items-center justify-center text-xs font-bold text-slate-900 dark:text-slate-100 p-1">
                    @switch($status)
                    @case('pending')
                    <i class="fa-solid fa-clock-rotate-left text-sm"></i><small>Pending</small>
                    @break
                    @case('confirmed')
                    <i class="fa-solid fa-handshake text-sm"></i><small>Confirmed</small>
                    @break
                    @case('delivered')
                    <i class="fa-solid fa-check-double text-sm"></i><small>Delivered</small>
                    @break
                    @case('out_for_delivery')
                    <i class="fa-solid fa-truck text-sm"></i><small>Out for Delivery</small>
                    @break
                    @case('cancelled')
                    <i class="fa-solid fa-ban text-sm"></i><small>Cancelled</small>
                    @break
                    @case('packaging')
                    <i class="fa-solid fa-box text-sm"></i><small>Packaging</small>
                    @break
                    @case('failed_delivery')
                    <i class="fa-solid fa-exclamation-triangle text-sm"></i><small>Failed</small>
                    @break
                    @case('returned')
                    <i class="fa-solid fa-undo text-sm"></i><small>Returned</small>
                    @break
                    @endswitch
                </div>
                <div class="text-2xl font-bold text-slate-900 dark:text-white">{{ $statusCounts[$status] ?? 0 }}</div>
            </div>
            @endforeach
        </div>

        <!-- Charts - 3 Separate -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Revenue Chart -->
            <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-xl p-6 rounded-3xl border shadow-2xl">
                <h4 class="font-bold mb-4 flex items-center gap-2 text-gray-900 dark:text-white">
                    <i class="fa-solid fa-chart-line text-emerald-500"></i> Revenue
                </h4>
                <canvas id="revenueChart" height="200"></canvas>
            </div>
            <!-- Profit Chart -->
            <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-xl p-6 rounded-3xl border shadow-2xl">
                <h4 class="font-bold mb-4 flex items-center gap-2 text-gray-900 dark:text-white">
                    <i class="fa-solid fa-chart-line text-purple-500"></i> Profit
                </h4>
                <canvas id="profitChart" height="200"></canvas>
            </div>
            <!-- Status Pie -->
            <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-xl p-6 rounded-3xl border shadow-2xl">
                <h4 class="font-bold mb-4 flex items-center gap-2 text-gray-900 dark:text-white">
                    <i class="fa-solid fa-chart-pie text-blue-500"></i> Orders Status
                </h4>
                <canvas id="statusPieChart" height="200"></canvas>
            </div>
        </div>

    </div> <!-- End Analytics Tab Content -->

    <!-- Orders Tab Content -->
    <div id="content-orders" class="hidden transition-opacity duration-300 opacity-0">
        @php
        $recentOrders = \App\Models\Order::with(['customer', 'product'])->where('vendor_id', $vendor->id)->orderBy('created_at', 'desc')->get();
        @endphp
        <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-xl rounded-3xl border shadow-2xl overflow-hidden mt-2">
            <div class="p-6 border-b border-gray-100 dark:border-slate-700 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white"><i class="fa-solid fa-box-open mr-2 text-orange-500"></i> Recent Orders</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead class="bg-gray-50/50 dark:bg-slate-700/30 text-gray-700 dark:text-gray-300 uppercase text-xs">
                        <tr>
                            <th scope="col" class="px-6 py-4">Order ID</th>
                            <th scope="col" class="px-6 py-4">Product</th>
                            <th scope="col" class="px-6 py-4">Customer</th>
                            <th scope="col" class="px-6 py-4">Date</th>
                            <th scope="col" class="px-6 py-4">Amount</th>
                            <th scope="col" class="px-6 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @forelse($recentOrders as $order)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $order->order_no ?? $order->id }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-slate-700 flex items-center justify-center overflow-hidden">
                                        @if($order->product && $order->product->image)
                                        <img src="{{ asset('storage/app/public/' .$order->product->image) }}" class="w-full h-full object-cover">
                                        @else
                                        <i class="fa-solid fa-box text-gray-400"></i>
                                        @endif
                                    </div>
                                    <span class="truncate max-w-[150px] inline-block" title="{{ $order->product->name ?? 'N/A' }}">
                                        {{ $order->product->product_name ?? 'N/A' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                {{ ucfirst($order->customer->first_name ?? 'N/A') }}
                                {{ ucfirst($order->customer->last_name ?? '') }}
                            </td>
                            <td class="px-6 py-4">{{ $order->created_at->format('d M Y, h:i A') }}</td>
                            <td class="px-6 py-4 font-medium text-emerald-600 dark:text-emerald-400">₹{{ number_format($order->total_price, 0) }}</td>
                            <td class="px-6 py-4">
                                @php
                                $statusColor = match($order->status) {
                                'delivered' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300',
                                'cancelled', 'failed_delivery', 'returned' => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300',
                                'pending' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/50 dark:text-orange-300',
                                default => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300',
                                };
                                @endphp
                                <span class="px-2 py-1 text-[10px] uppercase tracking-wider font-bold rounded-full {{ $statusColor }}">
                                    {{ str_replace('_', ' ', $order->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <i class="fa-solid fa-box-open text-4xl mb-3"></i>
                                    <p>No recent orders found.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- End Orders Tab Content -->

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function switchTab(tab) {
        const tabAnalytics = document.getElementById('tab-analytics');
        const contentAnalytics = document.getElementById('content-analytics');
        const tabOrders = document.getElementById('tab-orders');
        const contentOrders = document.getElementById('content-orders');

        const activeTabClass = "whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors border-orange-500 text-orange-600 dark:text-orange-500";
        const inactiveTabClass = "whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300";

        if (tab === 'analytics') {
            tabAnalytics.className = activeTabClass;
            tabOrders.className = inactiveTabClass;
            
            contentOrders.classList.add('hidden');
            contentOrders.classList.remove('opacity-100');
            contentOrders.classList.add('opacity-0');
            
            contentAnalytics.classList.remove('hidden');
            setTimeout(() => {
                contentAnalytics.classList.remove('opacity-0');
                contentAnalytics.classList.add('opacity-100');
            }, 50);
        } else {
            tabOrders.className = activeTabClass;
            tabAnalytics.className = inactiveTabClass;
            
            contentAnalytics.classList.add('hidden');
            contentAnalytics.classList.remove('opacity-100');
            contentAnalytics.classList.add('opacity-0');
            
            contentOrders.classList.remove('hidden');
            setTimeout(() => {
                contentOrders.classList.remove('opacity-0');
                contentOrders.classList.add('opacity-100');
            }, 50);
        }
    }
</script>

<script>
    @if(isset($months) && isset($revenues) && isset($profits))
    document.addEventListener('DOMContentLoaded', function() {
        // Revenue Chart
        new Chart(document.getElementById('revenueChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: {!! json_encode($months) !!},
                datasets: [{
                    label: 'Revenue',
                    data: {!! json_encode($revenues) !!},
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Profit Chart
        new Chart(document.getElementById('profitChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: {!! json_encode($months) !!},
                datasets: [{
                    label: 'Profit',
                    data: {!! json_encode($profits) !!},
                    borderColor: '#8b5cf6',
                    backgroundColor: 'rgba(139, 92, 246, 0.1)',
                    fill: false,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
    @endif

    @if(isset($statusCounts))
    new Chart(document.getElementById('statusPieChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($statusCounts->toArray())) !!},
            datasets: [{
                data: {!! json_encode(array_values($statusCounts->toArray())) !!},
                backgroundColor: ['#f59e0b', '#10b981', '#3b82f6', '#ef4444', '#8b5cf6', '#ec4899', '#06b6d4', '#eab308']
            }]
        },
        options: {
            responsive: true
        }
    });
    @endif
</script>
@endsection