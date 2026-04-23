@extends('vendor.layout.navbar')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen dark:from-slate-900 dark:to-slate-800 p-2">

    <!-- Welcome -->
    <div class="mb-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">
                Welcome, {{ $vendor->name ?? 'Vendor' }}
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
            <div class="bg-gradient-to-br from-emerald-400 to-teal-400 p-4 rounded-2xl text-white shadow-xl hover:shadow-2xl transition-all">
                <div class="flex items-center gap-2 mb-2">
                    <div class="p-2 bg-white/30 rounded-xl">
                        <i class="fa-solid fa-coins text-xl"></i>
                    </div>
                    <span class="text-xs font-bold uppercase tracking-wide">Revenue</span>
                </div>
                <div class="text-2xl font-bold">₹{{ number_format($revenue ?? 0, 0) }}</div>
            </div>
            <!-- Profit -->
            <div class="bg-gradient-to-br from-purple-400 to-indigo-400 p-4 rounded-2xl text-white shadow-xl hover:shadow-2xl transition-all">
                <div class="flex items-center gap-2 mb-2">
                    <div class="p-2 bg-white/30 rounded-xl">
                        <i class="fa-solid fa-chart-line text-xl"></i>
                    </div>
                    <span class="text-xs font-bold uppercase tracking-wide">Profit</span>
                </div>
                <div class="text-2xl font-bold">₹{{ number_format($profit ?? 0, 0) }}</div>
            </div>
            <!-- Orders -->
            <div class="bg-gradient-to-br from-blue-400 to-cyan-400 p-4 rounded-2xl text-white shadow-xl hover:shadow-2xl transition-all">
                <div class="flex items-center gap-2 mb-2">
                    <div class="p-2 bg-white/30 rounded-xl">
                        <i class="fa-solid fa-shopping-cart text-xl"></i>
                    </div>
                    <span class="text-xs font-bold uppercase tracking-wide">Orders</span>
                </div>
                <div class="text-2xl font-bold">{{ \App\Models\Order::where('vendor_id', $vendor->id)->count() ?? 0 }}</div>
            </div>
            <!-- Pending -->
            <div class="bg-gradient-to-br from-orange-400 to-red-400 p-4 rounded-2xl text-white shadow-xl hover:shadow-2xl transition-all">
                <div class="flex items-center gap-2 mb-2">
                    <div class="p-2 bg-white/30 rounded-xl">
                        <i class="fa-solid fa-clock text-xl"></i>
                    </div>
                    <span class="text-xs font-bold uppercase tracking-wide">Pending</span>
                </div>
                <div class="text-2xl font-bold">{{ $statusCounts['pending'] ?? 0 }}</div>
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

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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