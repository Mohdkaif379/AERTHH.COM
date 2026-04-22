@extends('vendor.layout.navbar')

@section('content')
<div class="max-w-7xl mx-auto px-1 sm:px-2 lg:px-4 py-2 dark:from-gray-900 dark:to-gray-800 min-h-screen">

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold bg-orange-500 dark:from-white dark:to-gray-200 bg-clip-text text-transparent mb-2">Order Insights</h1>
        <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl">Analytics and trends for your store performance (Last 7 days)</p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="group bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl p-6 rounded-2xl border border-gray-200/50 dark:border-gray-700/50 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between mb-2">
                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Orders</h4>
                <i class="fa fa-shopping-cart text-orange-500 text-xl group-hover:rotate-12 transition-transform"></i>
            </div>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalOrders ?? 0 }}</p>
        </div>

        <div class="group bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl p-6 rounded-2xl border border-gray-200/50 dark:border-gray-700/50 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between mb-2">
                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Today's Orders</h4>
                <i class="fa fa-calendar-day text-emerald-500 text-xl group-hover:scale-110 transition-transform"></i>
            </div>
            <p class="text-3xl font-bold text-emerald-600 dark:text-emerald-400">{{ $counts[array_key_last($counts)] ?? 0 }}</p>
        </div>

        <div class="group bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl p-6 rounded-2xl border border-gray-200/50 dark:border-gray-700/50 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between mb-2">
                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Avg Daily</h4>
                <i class="fa fa-chart-line text-blue-500 text-xl group-hover:animate-pulse"></i>
            </div>
            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ round($avgDailyOrders ?? 0, 1) }}</p>
        </div>
    </div>

    <!-- Charts Section - Single Row -->
    <div class="flex flex-col lg:flex-row gap-6 mb-8">
        <!-- Orders Trend Chart (65%) -->
        <div class="flex-[2] bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl p-6 rounded-2xl border border-gray-200/50 dark:border-gray-700/50 shadow-lg min-h-[360px]">
            <div class="flex items-center justify-between mb-6">
                <h4 class="text-xl font-semibold text-gray-900 dark:text-white">Orders Trend (Last 7 Days)</h4>
                <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                    <span class="w-3 h-3 bg-orange-500 rounded-full"></span>
                    Daily Orders
                </div>
            </div>
            <div style="position: relative; height: 280px;">
                <canvas id="orderChart"></canvas>
            </div>
        </div>

        <!-- Status Pie Chart (35%) -->
        <div class="flex-[1.5] bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl p-6 rounded-2xl border border-gray-200/50 dark:border-gray-700/50 shadow-lg min-h-[360px]">
            <div class="flex items-center justify-between mb-6">
                <h4 class="text-xl font-semibold text-gray-900 dark:text-white">Order Status</h4>
            </div>
            <div style="position: relative; height: 280px; max-height: 280px;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Line chart - daily orders
    var canvas = document.getElementById('orderChart');
    if (canvas) {
        var ctx = canvas.getContext('2d');
        @if(isset($dates) && isset($counts) && count($dates) > 0)
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($dates),
                datasets: [{
                    label: 'Daily Orders',
                    data: @json($counts),
                    borderColor: '#f97316',
                    backgroundColor: 'rgba(249, 115, 22, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 6,
                    pointHoverRadius: 9,
                    pointBackgroundColor: '#f97316',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {stepSize: 1}
                    }
                }
            }
        });
        @endif
    }

    // Pie chart - status distribution
    var statusCanvas = document.getElementById('statusChart');
    if (statusCanvas) {
        var statusCtx = statusCanvas.getContext('2d');
        @if(isset($statusOrders) && !empty($statusOrders))
        var statusData = @json($statusOrders);
        var statusColors = {
            'pending': '#f59e0b',
            'confirmed': '#10b981', 
            'packaging': '#3b82f6',
            'out_for_delivery': '#06b6d4',
            'delivered': '#059669',
            'cancelled': '#ef4444',
            'returned': '#8b5cf6',
            'failed_delivery': '#dc2626',
            'rejected': '#991b1b'
        };
        var statusLabels = Object.keys(statusData);
        var statusValues = Object.values(statusData);
        
        var pieChart = new Chart(statusCtx, {
            type: 'pie',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusValues,
                    backgroundColor: statusLabels.map(function(status) { return statusColors[status] || '#6b7280'; }),
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var total = context.dataset.data.reduce((a, b) => a + b, 0);
                                var percentage = ((context.parsed / total) * 100).toFixed(1);
                                return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
        @else
        statusCtx.fillStyle = 'rgba(156, 163, 175, 0.5)';
        statusCtx.fillRect(0, 0, statusCanvas.width, statusCanvas.height);
        statusCtx.fillStyle = 'rgb(107, 114, 128)';
        statusCtx.font = '16px sans-serif';
        statusCtx.textAlign = 'center';
        statusCtx.textBaseline = 'middle';
        statusCtx.fillText('No status data', statusCanvas.width / 2, statusCanvas.height / 2);
        @endif
    }
});
</script>
@endsection

