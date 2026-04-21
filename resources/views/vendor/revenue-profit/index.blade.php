@extends('vendor.layout.navbar')

@section('content')
<div class="max-w-7xl mx-auto px-1 sm:px-2 lg:px-4 py-4 dark:from-gray-900 dark:to-gray-800 min-h-screen">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-orange-600 to-orange-600 bg-clip-text text-transparent mb-2">Revenue & Profit Analytics</h1>
        <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl">Revenue and Profit trends over the last 6 months</p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Total Revenue Card -->
        <div class="group bg-gradient-to-br from-emerald-500 to-green-500 p-8 rounded-2xl shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 text-white border-0">
            <div class="flex items-center gap-3 mb-4">
                <div class="p-3 bg-white/20 rounded-xl">
                    <i class="fa-solid fa-coins text-2xl"></i>
                </div>
                <div>
                    <p class="text-white/90 text-sm font-medium uppercase tracking-wide">Total Revenue</p>
                </div>
            </div>
            <p class="text-4xl font-bold">{{ number_format($revenue ?? 0, 0) }} ₹</p>
        </div>

        <!-- Total Shipping Cost -->
        <div class="group bg-gradient-to-br from-orange-500 to-red-500 p-8 rounded-2xl shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 text-white border-0">
            <div class="flex items-center gap-3 mb-4">
                <div class="p-3 bg-white/20 rounded-xl">
                    <i class="fa-solid fa-truck text-2xl"></i>
                </div>
                <div>
                    <p class="text-white/90 text-sm font-medium uppercase tracking-wide">Shipping Cost</p>
                </div>
            </div>
            <p class="text-4xl font-bold">{{ number_format($totalShippingCost ?? 0, 0) }} ₹</p>
        </div>

        <!-- Net Profit -->
        <div class="group bg-gradient-to-br from-purple-500 to-indigo-500 p-8 rounded-2xl shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 text-white border-0">
            <div class="flex items-center gap-3 mb-4">
                <div class="p-3 bg-white/20 rounded-xl">
                    <i class="fa-solid fa-chart-line text-2xl"></i>
                </div>
                <div>
                    <p class="text-white/90 text-sm font-medium uppercase tracking-wide">Net Profit</p>
                    <p class="text-white/80 text-xs mt-1">Revenue: {{ number_format($revenue ?? 0, 0) }} + Shipping: {{ number_format($totalShippingCost ?? 0, 0) }}</p>
                </div>
            </div>
            <p class="text-4xl font-bold {{ ($profit ?? 0) > 0 ? 'text-emerald-200' : 'text-red-200' }}">{{ number_format($profit ?? 0, 0) }} ₹</p>
            @if(($profit ?? 0) > 0)
                <p class="text-emerald-200 text-sm mt-1">Margin: {{ number_format((($profit ?? 0) / ($revenue ?? 1)) * 100, 1) }}%</p>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Revenue Chart -->
        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl p-8 rounded-2xl border border-gray-200/50 dark:border-gray-700/50 shadow-lg">
            <div class="flex items-center justify-between mb-6">
                <h4 class="text-2xl font-bold text-gray-900 dark:text-white">Monthly Revenue</h4>
                <span class="flex items-center gap-2 text-emerald-600 font-medium">
                    <span class="w-3 h-3 bg-emerald-500 rounded-full"></span>
                    Revenue
                </span>
            </div>
            <div style="position: relative; height: 350px;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Profit Chart -->
        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl p-8 rounded-2xl border border-gray-200/50 dark:border-gray-700/50 shadow-lg">
            <div class="flex items-center justify-between mb-6">
                <h4 class="text-2xl font-bold text-gray-900 dark:text-white">Monthly Profit</h4>
                <span class="flex items-center gap-2 text-purple-600 font-medium">
                    <span class="w-3 h-3 bg-purple-500 rounded-full"></span>
                    Profit
                </span>
            </div>
            <div style="position: relative; height: 350px;">
                <canvas id="profitChart"></canvas>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(isset($months) && isset($revenues))
    // Revenue Chart
    var revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Revenue',
                data: @json($revenues),
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 6,
                pointHoverRadius: 9,
                pointBackgroundColor: '#10b981',
                borderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true } },
            plugins: { legend: { display: false } }
        }
    });
    @endif

    @if(isset($months) && isset($profits))
    // Profit Chart
    var profitCtx = document.getElementById('profitChart').getContext('2d');
    new Chart(profitCtx, {
        type: 'bar',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Profit',
                data: @json($profits),
                backgroundColor: 'rgba(139, 92, 246, 0.8)',
                borderColor: '#8b5cf6',
                borderRadius: 8,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true } },
            plugins: { legend: { display: false } }
        }
    });
    @endif
});
</script>
@endsection

