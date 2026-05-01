@extends('layout.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back, Admin')

@section('content')
<div class="space-y-6">
    {{-- Main Tabs Navigation --}}
    <div class="relative">
        <div class="flex items-center space-x-1 overflow-x-auto no-scrollbar pb-3">
            <button onclick="switchTab('analytics')" id="tab-analytics" class="tab-btn px-6 py-2 rounded-xl text-[11px] font-bold uppercase tracking-wider transition-all duration-300 flex items-center space-x-2 bg-indigo-50 text-indigo-600 shadow-sm">
                <i class="fas fa-chart-line text-[10px]"></i>
                <span>Analytics</span>
            </button>
            <button onclick="switchTab('recent-orders')" id="tab-recent-orders" class="tab-btn px-6 py-2 rounded-xl text-[11px] font-bold uppercase tracking-wider transition-all duration-300 flex items-center space-x-2 text-slate-400 hover:text-slate-600 hover:bg-slate-50">
                <i class="fas fa-shopping-bag text-[10px]"></i>
                <span>Recent Orders</span>
            </button>
            <button onclick="switchTab('withdrawals')" id="tab-withdrawals" class="tab-btn px-6 py-2 rounded-xl text-[11px] font-bold uppercase tracking-wider transition-all duration-300 flex items-center space-x-2 text-slate-400 hover:text-slate-600 hover:bg-slate-50">
                <i class="fas fa-wallet text-[10px]"></i>
                <span>Withdrawals</span>
            </button>
            <button onclick="switchTab('vendors')" id="tab-vendors" class="tab-btn px-6 py-2 rounded-xl text-[11px] font-bold uppercase tracking-wider transition-all duration-300 flex items-center space-x-2 text-slate-400 hover:text-slate-600 hover:bg-slate-50">
                <i class="fas fa-store text-[10px]"></i>
                <span>Vendors</span>
            </button>
            <button onclick="switchTab('customers')" id="tab-customers" class="tab-btn px-6 py-2 rounded-xl text-[11px] font-bold uppercase tracking-wider transition-all duration-300 flex items-center space-x-2 text-slate-400 hover:text-slate-600 hover:bg-slate-50">
                <i class="fas fa-users text-[10px]"></i>
                <span>Customers</span>
            </button>
            <button onclick="switchTab('products')" id="tab-products" class="tab-btn px-6 py-2 rounded-xl text-[11px] font-bold uppercase tracking-wider transition-all duration-300 flex items-center space-x-2 text-slate-400 hover:text-slate-600 hover:bg-slate-50">
                <i class="fas fa-box text-[10px]"></i>
                <span>Products</span>
            </button>
        </div>
        <hr class="border-slate-100 absolute bottom-0 left-0 right-0">
    </div>

    {{-- Analytics Tab --}}
    <div id="content-analytics" class="tab-content space-y-6">
        {{-- Top Stats Grid inside Analytics --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white border border-slate-100 rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow group">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[11px] uppercase tracking-wider text-slate-400 font-bold">Total Vendors</p>
                        <p class="text-3xl font-bold text-slate-800 leading-tight mt-1">{{ number_format($stats['vendors']['total'] ?? 0) }}</p>
                    </div>
                    <span class="h-12 w-12 flex items-center justify-center rounded-xl bg-cyan-50 text-cyan-500 group-hover:bg-cyan-500 group-hover:text-white transition-all duration-300">
                        <i class="fas fa-store text-lg"></i>
                    </span>
                </div>
            </div>
            <div class="bg-white border border-slate-100 rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow group">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[11px] uppercase tracking-wider text-slate-400 font-bold">Total Customers</p>
                        <p class="text-3xl font-bold text-slate-800 leading-tight mt-1">{{ number_format($stats['customers']['total'] ?? 0) }}</p>
                    </div>
                    <span class="h-12 w-12 flex items-center justify-center rounded-xl bg-emerald-50 text-emerald-500 group-hover:bg-emerald-500 group-hover:text-white transition-all duration-300">
                        <i class="fas fa-users text-lg"></i>
                    </span>
                </div>
            </div>
            <div class="bg-white border border-slate-100 rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow group">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[11px] uppercase tracking-wider text-slate-400 font-bold">Total Products</p>
                        <p class="text-3xl font-bold text-slate-800 leading-tight mt-1">{{ number_format($stats['products']['total'] ?? 0) }}</p>
                    </div>
                    <span class="h-12 w-12 flex items-center justify-center rounded-xl bg-blue-50 text-blue-500 group-hover:bg-blue-500 group-hover:text-white transition-all duration-300">
                        <i class="fas fa-layer-group text-lg"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            {{-- Analytics Graph Card --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Orders Graph --}}
                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                        <div>
                            <h3 class="text-sm font-bold text-slate-700 uppercase tracking-tight">Orders Trend</h3>
                            <p class="text-[10px] text-slate-400 mt-1 uppercase">
                                @if($orderFilter === 'daily') Daily - {{ date('F Y') }}
                                @elseif($orderFilter === 'weekly') Last 7 Days
                                @elseif($orderFilter === 'monthly') Monthly - {{ date('Y') }}
                                @elseif($orderFilter === 'yearly') Last 5 Years
                                @endif
                            </p>
                        </div>
    
                        <div class="flex items-center p-1 bg-slate-50 border border-slate-100 rounded-xl self-start sm:self-center">
                            @foreach(['daily', 'weekly', 'monthly', 'yearly'] as $t)
                                <a href="{{ route('admin.dashboard', ['order_filter' => $t, 'withdrawal_filter' => $withdrawalFilter]) }}" 
                                   class="px-4 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-wider transition-all duration-300 {{ $orderFilter === $t ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-400 hover:text-slate-600 hover:bg-white/50' }}">
                                    {{ $t }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="h-[300px]">
                        <canvas id="ordersChart"></canvas>
                    </div>
                </div>

                {{-- Withdrawals Graph --}}
                <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                        <div>
                            <h3 class="text-sm font-bold text-slate-700 uppercase tracking-tight">Withdrawal Trend</h3>
                            <p class="text-[10px] text-slate-400 mt-1 uppercase">
                                @if($withdrawalFilter === 'daily') Daily - {{ date('F Y') }}
                                @elseif($withdrawalFilter === 'weekly') Last 7 Days
                                @elseif($withdrawalFilter === 'monthly') Monthly - {{ date('Y') }}
                                @elseif($withdrawalFilter === 'yearly') Last 5 Years
                                @endif
                            </p>
                        </div>

                        <div class="flex items-center p-1 bg-slate-50 border border-slate-100 rounded-xl self-start sm:self-center">
                            @foreach(['daily', 'weekly', 'monthly', 'yearly'] as $t)
                                <a href="{{ route('admin.dashboard', ['order_filter' => $orderFilter, 'withdrawal_filter' => $t]) }}" 
                                   class="px-4 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-wider transition-all duration-300 {{ $withdrawalFilter === $t ? 'bg-white text-cyan-600 shadow-sm' : 'text-slate-400 hover:text-slate-600 hover:bg-white/50' }}">
                                    {{ $t }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="h-[300px]">
                        <canvas id="withdrawalsChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Order Overview Panel --}}
            <div class="bg-white border border-slate-100 rounded-2xl p-4 shadow-sm">
                <h3 class="text-xs font-bold text-slate-700 uppercase tracking-tight mb-4 flex items-center px-2">
                    <i class="fas fa-clipboard-list mr-2 text-slate-400"></i>
                    Status Overview
                </h3>
                <div class="space-y-1.5">
                    @php
                        $orderTabs = [
                            'all' => ['label' => 'Total Orders', 'color' => 'slate', 'icon' => 'fa-shopping-cart'],
                            'pending' => ['label' => 'Pending', 'color' => 'yellow', 'icon' => 'fa-clock'],
                            'confirmed' => ['label' => 'Confirmed', 'color' => 'blue', 'icon' => 'fa-check-circle'],
                            'packaging' => ['label' => 'Packaging', 'color' => 'purple', 'icon' => 'fa-box'],
                            'out_for_delivery' => ['label' => 'Out Delivery', 'color' => 'indigo', 'icon' => 'fa-truck'],
                            'delivered' => ['label' => 'Delivered', 'color' => 'emerald', 'icon' => 'fa-check-double'],
                            'returned' => ['label' => 'Returned', 'color' => 'orange', 'icon' => 'fa-undo-alt'],
                            'failed_delivery' => ['label' => 'Failed Deliv.', 'color' => 'rose', 'icon' => 'fa-exclamation-triangle'],
                            'cancelled' => ['label' => 'Cancelled', 'color' => 'red', 'icon' => 'fa-times-circle'],
                        ];
                    @endphp

                    @foreach($orderTabs as $key => $tab)
                        @php
                            $count = $stats['orders'][$key] ?? 0;
                            $colorClass = match($tab['color']) {
                                'slate' => 'bg-slate-50 text-slate-600',
                                'yellow' => 'bg-yellow-50 text-yellow-600',
                                'blue' => 'bg-blue-50 text-blue-600',
                                'purple' => 'bg-purple-50 text-purple-600',
                                'indigo' => 'bg-indigo-50 text-indigo-600',
                                'emerald' => 'bg-emerald-50 text-emerald-600',
                                'orange' => 'bg-orange-50 text-orange-600',
                                'rose' => 'bg-rose-50 text-rose-600',
                                'red' => 'bg-red-50 text-red-600',
                                default => 'bg-gray-50 text-gray-600',
                            };
                        @endphp
                        <div class="flex items-center justify-between p-2 rounded-xl border border-slate-50 hover:border-slate-200 transition-colors group cursor-default">
                            <div class="flex items-center space-x-2.5">
                                <div class="h-7 w-7 rounded-lg {{ $colorClass }} flex items-center justify-center shadow-sm">
                                    <i class="fas {{ $tab['icon'] }} text-[10px]"></i>
                                </div>
                                <span class="text-[11px] font-semibold text-slate-600 tracking-tight group-hover:text-slate-900">{{ $tab['label'] }}</span>
                            </div>
                            <span class="text-[11px] font-bold text-slate-800 {{ $count > 0 ? '' : 'opacity-30' }}">{{ number_format($count) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Orders Tab --}}
    <div id="content-recent-orders" class="tab-content hidden space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm flex items-center justify-between group">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Total Orders</p>
                    <p class="text-2xl font-bold text-slate-800">{{ number_format($stats['orders']['all']) }}</p>
                </div>
                <div class="h-10 w-10 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-indigo-500 group-hover:text-white transition-all duration-300">
                    <i class="fas fa-shopping-cart text-sm"></i>
                </div>
            </div>
            <div class="bg-white border border-emerald-100 rounded-2xl p-5 shadow-sm bg-emerald-50/10 flex items-center justify-between group">
                <div>
                    <p class="text-[10px] font-bold text-emerald-600 uppercase mb-1">Today's Orders</p>
                    <p class="text-2xl font-bold text-emerald-700">{{ number_format($stats['orders']['today']) }}</p>
                </div>
                <div class="h-10 w-10 rounded-xl bg-emerald-100 text-emerald-500 flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-white transition-all duration-300">
                    <i class="fas fa-calendar-day text-sm"></i>
                </div>
            </div>
            <div class="bg-white border border-amber-100 rounded-2xl p-5 shadow-sm bg-amber-50/10 flex items-center justify-between group">
                <div>
                    <p class="text-[10px] font-bold text-amber-600 uppercase mb-1">Pending Orders</p>
                    <p class="text-2xl font-bold text-amber-700">{{ number_format($stats['orders']['pending']) }}</p>
                </div>
                <div class="h-10 w-10 rounded-xl bg-amber-100 text-amber-500 flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-all duration-300">
                    <i class="fas fa-spinner fa-spin-pulse text-sm"></i>
                </div>
            </div>
        </div>
        <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 bg-slate-50/50 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-sm font-bold text-slate-700 uppercase tracking-tight">Latest Transactions</h3>
                <a href="#" class="text-[10px] font-bold text-indigo-600 hover:text-indigo-700 uppercase tracking-widest">View All Orders</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50/30 text-slate-500 uppercase tracking-tighter font-bold border-b border-slate-100">
                            <th class="px-6 py-4">Order ID</th>
                            <th class="px-6 py-4">Customer</th>
                            <th class="px-6 py-4">Product</th>
                            <th class="px-6 py-4">Amount</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($recentOrders as $order)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-bold text-slate-800">{{ $order->order_no }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $order->customer->first_name ?? 'N/A' }} {{ $order->customer->last_name ?? '' }}</td>
                            <td class="px-6 py-4 text-slate-600 truncate max-w-[150px]">{{ $order->product->product_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 font-bold text-indigo-600">₹{{ number_format($order->total_price, 2) }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = match($order->status) {
                                        'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                        'confirmed' => 'bg-blue-50 text-blue-600 border-blue-100',
                                        'packaging' => 'bg-purple-50 text-purple-600 border-purple-100',
                                        'out_for_delivery' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                        'delivered' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'returned' => 'bg-orange-50 text-orange-600 border-orange-100',
                                        'failed_delivery' => 'bg-rose-50 text-rose-600 border-rose-100',
                                        'cancelled' => 'bg-red-50 text-red-600 border-red-100',
                                        default => 'bg-slate-50 text-slate-600 border-slate-100',
                                    };
                                @endphp
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-tighter {{ $statusColors }} border">
                                    {{ str_replace('_', ' ', $order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right text-slate-400">{{ optional($order->created_at)->format('d M, h:i A') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Withdrawals Tab --}}
    <div id="content-withdrawals" class="tab-content hidden space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm flex items-center justify-between group">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Total Requests</p>
                    <p class="text-2xl font-bold text-slate-800">{{ number_format($stats['withdrawals']['total']) }}</p>
                </div>
                <div class="h-10 w-10 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-slate-500 group-hover:text-white transition-all duration-300">
                    <i class="fas fa-wallet text-sm"></i>
                </div>
            </div>
            <div class="bg-white border border-amber-100 rounded-2xl p-5 shadow-sm bg-amber-50/10 flex items-center justify-between group">
                <div>
                    <p class="text-[10px] font-bold text-amber-600 uppercase mb-1">Pending Requests</p>
                    <p class="text-2xl font-bold text-amber-700">{{ number_format($stats['withdrawals']['pending']) }}</p>
                </div>
                <div class="h-10 w-10 rounded-xl bg-amber-100 text-amber-500 flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-all duration-300">
                    <i class="fas fa-clock text-sm"></i>
                </div>
            </div>
            <div class="bg-white border border-emerald-100 rounded-2xl p-5 shadow-sm bg-emerald-50/10 flex items-center justify-between group">
                <div>
                    <p class="text-[10px] font-bold text-emerald-600 uppercase mb-1">Approved Payouts</p>
                    <p class="text-2xl font-bold text-emerald-700">{{ number_format($stats['withdrawals']['approved']) }}</p>
                </div>
                <div class="h-10 w-10 rounded-xl bg-emerald-100 text-emerald-500 flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-white transition-all duration-300">
                    <i class="fas fa-check-circle text-sm"></i>
                </div>
            </div>
            <div class="bg-white border border-rose-100 rounded-2xl p-5 shadow-sm bg-rose-50/10 flex items-center justify-between group">
                <div>
                    <p class="text-[10px] font-bold text-rose-600 uppercase mb-1">Rejected Requests</p>
                    <p class="text-2xl font-bold text-rose-700">{{ number_format($stats['withdrawals']['rejected']) }}</p>
                </div>
                <div class="h-10 w-10 rounded-xl bg-rose-100 text-rose-500 flex items-center justify-center group-hover:bg-rose-500 group-hover:text-white transition-all duration-300">
                    <i class="fas fa-times-circle text-sm"></i>
                </div>
            </div>
        </div>

        <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 bg-slate-50/50 border-b border-slate-100">
                <h3 class="text-sm font-bold text-slate-700 uppercase tracking-tight">Recent Payout Requests</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50/30 text-slate-500 uppercase tracking-tighter font-bold border-b border-slate-100">
                            <th class="px-6 py-4">Vendor</th>
                            <th class="px-6 py-4">Amount</th>
                            <th class="px-6 py-4">Method</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-right">Requested On</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($recentWithdrawals as $withdrawal)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-bold text-slate-800">{{ $withdrawal->vendor->shop_name ?? $withdrawal->vendor->name }}</p>
                                <p class="text-[10px] text-slate-400">{{ $withdrawal->account_holder_name }}</p>
                            </td>
                            <td class="px-6 py-4 font-bold text-indigo-600">₹{{ number_format($withdrawal->amount, 2) }}</td>
                            <td class="px-6 py-4 text-slate-600">
                                <span class="capitalize">{{ str_replace('_', ' ', $withdrawal->payment_type) }}</span>
                                <p class="text-[10px] text-slate-400">{{ $withdrawal->account_number ?? $withdrawal->upi_id }}</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($withdrawal->status === 'approved')
                                    <span class="text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-tighter border border-emerald-100">Approved</span>
                                @elseif($withdrawal->status === 'rejected')
                                    <span class="text-rose-500 bg-rose-50 px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-tighter border border-rose-100">Rejected</span>
                                @else
                                    <span class="text-amber-500 bg-amber-50 px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-tighter border border-amber-100">Pending</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right text-slate-400">{{ optional($withdrawal->created_at)->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Vendors Tab --}}
    <div id="content-vendors" class="tab-content hidden space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm flex items-center justify-between group">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Total Vendors</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $stats['vendors']['total'] }}</p>
                </div>
                <div class="h-10 w-10 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-slate-500 group-hover:text-white transition-all duration-300">
                    <i class="fas fa-store text-sm"></i>
                </div>
            </div>
            <div class="bg-white border border-emerald-100 rounded-2xl p-5 shadow-sm bg-emerald-50/10 flex items-center justify-between group">
                <div>
                    <p class="text-[10px] font-bold text-emerald-600 uppercase mb-1">Active Vendors</p>
                    <p class="text-2xl font-bold text-emerald-700">{{ $stats['vendors']['active'] }}</p>
                </div>
                <div class="h-10 w-10 rounded-xl bg-emerald-100 text-emerald-500 flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-white transition-all duration-300">
                    <i class="fas fa-check-circle text-sm"></i>
                </div>
            </div>
            <div class="bg-white border border-amber-100 rounded-2xl p-5 shadow-sm bg-amber-50/10 flex items-center justify-between group">
                <div>
                    <p class="text-[10px] font-bold text-amber-600 uppercase mb-1">Pending Approval</p>
                    <p class="text-2xl font-bold text-amber-700">{{ $stats['vendors']['pending'] }}</p>
                </div>
                <div class="h-10 w-10 rounded-xl bg-amber-100 text-amber-500 flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-all duration-300">
                    <i class="fas fa-clock text-sm"></i>
                </div>
            </div>
        </div>
        <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 bg-slate-50/50 border-b border-slate-100">
                <h3 class="text-sm font-bold text-slate-700 uppercase tracking-tight">Recent Vendors</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50/30 text-slate-500 uppercase tracking-tighter font-bold border-b border-slate-100">
                            <th class="px-6 py-4">Image</th>
                            <th class="px-6 py-4">Shop Details</th>
                            <th class="px-6 py-4">Contact</th>
                            <th class="px-6 py-4">Products</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-right">Joined</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($recentVendors as $vendor)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-3">
                                <img src="{{ $vendor->image ? asset('storage/' . $vendor->image) : 'https://ui-avatars.com/api/?name=' . urlencode($vendor->shop_name ?? $vendor->name) . '&background=random' }}" 
                                     alt="Vendor" 
                                     class="h-8 w-8 rounded-full object-cover border border-slate-100 shadow-sm">
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-bold text-slate-800">{{ $vendor->shop_name ?? $vendor->name }}</p>
                                <p class="text-[10px] text-slate-400">{{ $vendor->email }}</p>
                            </td>
                            <td class="px-6 py-4 text-slate-600 font-medium">{{ $vendor->phone ?? 'N/A' }}</td>
                            <td class="px-6 py-4">
                                <span class="bg-blue-50 text-blue-600 px-2 py-0.5 rounded-lg font-bold text-[10px]">
                                    {{ $vendor->products_count }} Products
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($vendor->status)
                                    <span class="text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-tighter border border-emerald-100">Active</span>
                                @else
                                    <span class="text-amber-500 bg-amber-50 px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-tighter border border-amber-100">Pending</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right text-slate-400">{{ optional($vendor->created_at)->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Customers Tab --}}
    <div id="content-customers" class="tab-content hidden space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm flex items-center justify-between group">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Total Customers</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $stats['customers']['total'] }}</p>
                </div>
                <div class="h-10 w-10 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-slate-500 group-hover:text-white transition-all duration-300">
                    <i class="fas fa-users text-sm"></i>
                </div>
            </div>
            <div class="bg-white border border-emerald-100 rounded-2xl p-5 shadow-sm bg-emerald-50/10 flex items-center justify-between group">
                <div>
                    <p class="text-[10px] font-bold text-emerald-600 uppercase mb-1">Active Customers</p>
                    <p class="text-2xl font-bold text-emerald-700">{{ $stats['customers']['active'] }}</p>
                </div>
                <div class="h-10 w-10 rounded-xl bg-emerald-100 text-emerald-500 flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-white transition-all duration-300">
                    <i class="fas fa-user-check text-sm"></i>
                </div>
            </div>
            <div class="bg-white border border-rose-100 rounded-2xl p-5 shadow-sm bg-rose-50/10 flex items-center justify-between group">
                <div>
                    <p class="text-[10px] font-bold text-rose-600 uppercase mb-1">Inactive/Blocked</p>
                    <p class="text-2xl font-bold text-rose-700">{{ $stats['customers']['inactive'] }}</p>
                </div>
                <div class="h-10 w-10 rounded-xl bg-rose-100 text-rose-500 flex items-center justify-center group-hover:bg-rose-500 group-hover:text-white transition-all duration-300">
                    <i class="fas fa-user-slash text-sm"></i>
                </div>
            </div>
        </div>
        <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 bg-slate-50/50 border-b border-slate-100">
                <h3 class="text-sm font-bold text-slate-700 uppercase tracking-tight">Recent Customers</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50/30 text-slate-500 uppercase tracking-tighter font-bold border-b border-slate-100">
                            <th class="px-6 py-4">Image</th>
                            <th class="px-6 py-4">Name</th>
                            <th class="px-6 py-4">Contact</th>
                            <th class="px-6 py-4">Orders</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-right">Registered</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($recentCustomers as $customer)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-3">
                                <img src="{{ $customer->profile_image ?? 'https://ui-avatars.com/api/?name=' . urlencode($customer->first_name . ' ' . $customer->last_name) . '&background=random' }}" 
                                     alt="Customer" 
                                     class="h-8 w-8 rounded-full object-cover border border-slate-100 shadow-sm">
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-bold text-slate-800">{{ $customer->first_name }} {{ $customer->last_name }}</p>
                                <p class="text-[10px] text-slate-400">{{ $customer->email }}</p>
                            </td>
                            <td class="px-6 py-4 text-slate-600 font-medium">{{ $customer->phone ?? 'N/A' }}</td>
                            <td class="px-6 py-4">
                                <span class="bg-indigo-50 text-indigo-600 px-2 py-0.5 rounded-lg font-bold text-[10px]">
                                    {{ $customer->orders_count }} Orders
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($customer->status)
                                    <span class="text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-tighter border border-emerald-100">Active</span>
                                @else
                                    <span class="text-rose-500 bg-rose-50 px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-tighter border border-rose-100">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right text-slate-400">{{ optional($customer->created_at)->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Products Tab --}}
    <div id="content-products" class="tab-content hidden space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm flex items-center justify-between group">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Total Products</p>
                    <p class="text-2xl font-bold text-slate-800">{{ $stats['products']['total'] }}</p>
                </div>
                <div class="h-10 w-10 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-slate-500 group-hover:text-white transition-all duration-300">
                    <i class="fas fa-box text-sm"></i>
                </div>
            </div>
            <div class="bg-white border border-emerald-100 rounded-2xl p-5 shadow-sm bg-emerald-50/10 flex items-center justify-between group">
                <div>
                    <p class="text-[10px] font-bold text-emerald-600 uppercase mb-1">Approved Products</p>
                    <p class="text-2xl font-bold text-emerald-700">{{ $stats['products']['approved'] }}</p>
                </div>
                <div class="h-10 w-10 rounded-xl bg-emerald-100 text-emerald-500 flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-white transition-all duration-300">
                    <i class="fas fa-clipboard-check text-sm"></i>
                </div>
            </div>
            <div class="bg-white border border-rose-100 rounded-2xl p-5 shadow-sm bg-rose-50/10 flex items-center justify-between group">
                <div>
                    <p class="text-[10px] font-bold text-rose-600 uppercase mb-1">Rejected Products</p>
                    <p class="text-2xl font-bold text-rose-700">{{ $stats['products']['rejected'] }}</p>
                </div>
                <div class="h-10 w-10 rounded-xl bg-rose-100 text-rose-500 flex items-center justify-center group-hover:bg-rose-500 group-hover:text-white transition-all duration-300">
                    <i class="fas fa-times-circle text-sm"></i>
                </div>
            </div>
        </div>
        <div class="bg-white border border-slate-100 rounded-2xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 bg-slate-50/50 border-b border-slate-100">
                <h3 class="text-sm font-bold text-slate-700 uppercase tracking-tight">Newly Added Products</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50/30 text-slate-500 uppercase tracking-tighter font-bold border-b border-slate-100">
                            <th class="px-6 py-4">Image</th>
                            <th class="px-6 py-4">Product Name</th>
                            <th class="px-6 py-4">Vendor</th>
                            <th class="px-6 py-4">Price</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-right">Added On</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($recentProducts as $product)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-3">
                                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://ui-avatars.com/api/?name=' . urlencode($product->product_name) . '&background=random' }}" 
                                     alt="Product" 
                                     class="h-10 w-10 rounded-lg object-cover border border-slate-100 shadow-sm">
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-800 truncate max-w-[200px]">{{ $product->product_name }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $product->vendor->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 font-bold text-indigo-600">
                                ₹{{ number_format($product->unit_price + $product->shipping_cost + $product->tax_amount, 2) }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($product->vendor_product_status === 'approved')
                                    <span class="text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-tighter border border-emerald-100">Approved</span>
                                @elseif($product->vendor_product_status === 'rejected')
                                    <span class="text-rose-500 bg-rose-50 px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-tighter border border-rose-100">Rejected</span>
                                @else
                                    <span class="text-amber-500 bg-amber-50 px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-tighter border border-amber-100">{{ $product->vendor_product_status ?? 'Pending' }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right text-slate-400">{{ optional($product->created_at)->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function switchTab(tabId) {
        // Update Buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('bg-indigo-50', 'text-indigo-600', 'shadow-sm');
            btn.classList.add('text-slate-400', 'hover:text-slate-600', 'hover:bg-slate-50');
        });
        const activeBtn = document.getElementById('tab-' + tabId);
        if(activeBtn) {
            activeBtn.classList.add('bg-indigo-50', 'text-indigo-600', 'shadow-sm');
            activeBtn.classList.remove('text-slate-400', 'hover:text-slate-600', 'hover:bg-slate-50');
        }

        // Update Content
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });
        const activeContent = document.getElementById('content-' + tabId);
        if(activeContent) {
            activeContent.classList.remove('hidden');
        }

        // Store active tab in session storage
        sessionStorage.setItem('admin_dashboard_active_tab', tabId);
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Restore last active tab
        const lastTab = sessionStorage.getItem('admin_dashboard_active_tab');
        if (lastTab && document.getElementById('tab-' + lastTab)) {
            switchTab(lastTab);
        }

        // Common Chart Config
        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(30, 41, 59, 0.9)',
                    titleFont: { size: 12, weight: 'bold' },
                    bodyFont: { size: 12 },
                    padding: 12,
                    cornerRadius: 12,
                    displayColors: true,
                    usePointStyle: true,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(226, 232, 240, 0.4)', drawBorder: false, borderDash: [5, 5] },
                    ticks: { font: { size: 10, weight: '500' }, color: '#64748b', padding: 10 }
                },
                x: {
                    grid: { display: true, color: 'rgba(226, 232, 240, 0.4)', borderDash: [5, 5] },
                    ticks: { font: { size: 10, weight: '500' }, color: '#64748b', padding: 10 }
                }
            }
        };

        const getGradient = (ctx, chartArea, color) => {
            if (!chartArea) return null;
            const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
            gradient.addColorStop(0, color + '00');
            gradient.addColorStop(1, color + '20');
            return gradient;
        };

        // Orders Chart
        const ordersCtx = document.getElementById('ordersChart').getContext('2d');
        new Chart(ordersCtx, {
            type: 'bar',
            data: {
                labels: @json($orderLabels),
                datasets: [
                    @foreach($orderDatasets as $key => $ds)
                    {
                        label: '{{ $ds["label"] }}',
                        data: @json($ds["data"]),
                        borderColor: '{{ $ds["color"] }}',
                        backgroundColor: (context) => getGradient(context.chart.ctx, context.chart.chartArea, '{{ $ds["color"] }}'),
                        borderWidth: 1,
                        borderRadius: 4,
                        barThickness: 'flex',
                        maxBarThickness: 30,
                        hidden: {{ $key === 'total' ? 'false' : 'true' }}
                    },
                    @endforeach
                ]
            },
            options: chartOptions
        });

        // Withdrawals Chart
        const withdrawalsCtx = document.getElementById('withdrawalsChart').getContext('2d');
        new Chart(withdrawalsCtx, {
            type: 'line',
            data: {
                labels: @json($withdrawalLabels),
                datasets: [
                    @foreach($withdrawalDatasets as $key => $ds)
                    {
                        label: '{{ $ds["label"] }}',
                        data: @json($ds["data"]),
                        borderColor: '{{ $ds["color"] }}',
                        backgroundColor: (context) => getGradient(context.chart.ctx, context.chart.chartArea, '{{ $ds["color"] }}'),
                        fill: true,
                        tension: 0.4,
                        pointRadius: 2,
                        pointBackgroundColor: '{{ $ds["color"] }}',
                        borderWidth: {{ $key === 'total' ? 3 : 2 }},
                        hidden: {{ $key === 'total' ? 'false' : 'true' }}
                    },
                    @endforeach
                ]
            },
            options: chartOptions
        });
    });
</script>
@endpush
