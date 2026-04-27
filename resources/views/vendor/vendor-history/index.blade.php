@extends('vendor.layout.navbar')

@section('content')
<div class="space-y-6">
    @php
        $statusCounts = $orders->getCollection()->groupBy('status')->map->count();
        $totalOrders = $orders->total();
    @endphp

    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">History</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Only your delivered, cancelled, returned, and failed delivery orders</p>
        </div>
        <div class="relative">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            <input type="text" id="historySearch" placeholder="Search order, product, customer..."
                   class="w-full sm:w-80 pl-8 pr-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-400 text-sm">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        @foreach (['delivered' => 'Delivered', 'cancelled' => 'Cancelled', 'returned' => 'Returned', 'failed_delivery' => 'Failed Delivery'] as $key => $label)
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm p-5">
                <p class="text-[11px] uppercase tracking-wide text-gray-400 font-semibold">{{ $label }}</p>
                <div class="mt-2 flex items-end justify-between gap-3">
                    <div>
                        <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $statusCounts[$key] ?? 0 }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Orders</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center
                        @if($key === 'delivered') bg-emerald-100 dark:bg-emerald-900/30
                        @elseif($key === 'cancelled') bg-rose-100 dark:bg-rose-900/30
                        @elseif($key === 'returned') bg-violet-100 dark:bg-violet-900/30
                        @else bg-red-100 dark:bg-red-900/30 @endif">
                        <i class="fas fa-box text-sm
                            @if($key === 'delivered') text-emerald-600 dark:text-emerald-300
                            @elseif($key === 'cancelled') text-rose-600 dark:text-rose-300
                            @elseif($key === 'returned') text-violet-600 dark:text-violet-300
                            @else text-red-600 dark:text-red-300 @endif"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden shadow-sm">
        <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-amber-50 dark:from-gray-900 dark:to-gray-800 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between gap-4">
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200">Order History List</h3>
            <div class="text-xs text-gray-400">Total {{ $totalOrders }} {{ \Illuminate\Support\Str::plural('entry', $totalOrders) }}</div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800/80 border-y border-gray-100 dark:border-gray-700">
                        <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Sr.No</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Order No</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Product</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Customer</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Status</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Created</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800" id="historyTableBody">
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
                        <tr class="history-row hover:bg-orange-50/40 dark:hover:bg-gray-800/60 transition-colors duration-200">
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $orders->firstItem() + $index }}</td>
                            <td class="px-4 py-3 font-medium text-gray-800 dark:text-white">{{ $order->order_no ?? str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shrink-0">
                                        @if(optional($order->product)->image)
                                            <img src="{{ str_starts_with($order->product->image, 'http') ? $order->product->image : asset('storage/'.$order->product->image) }}"
                                                 alt="{{ $order->product->product_name ?? 'Product' }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                <i class="fas fa-box text-xs"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-medium truncate">{{ $order->product->product_name ?? 'Unknown Product' }}</p>
                                        <p class="text-[11px] text-gray-400">Product ID #{{ str_pad($order->product_id, 4, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                                {{ trim((optional($order->customer)->first_name ?? '') . ' ' . (optional($order->customer)->last_name ?? '')) ?: 'Unknown Customer' }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-semibold {{ $badge }}">
                                    {{ ucwords(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                {{ optional($order->created_at)->format('d M Y, h:i A') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-gray-400 text-sm">
                                <i class="fas fa-box-open text-3xl mb-2 block text-gray-300 dark:text-gray-600"></i>
                                No history found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-3 bg-gray-50 dark:bg-gray-800/60 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
            <p class="text-[10px] text-gray-400">Showing {{ $orders->count() }} {{ \Illuminate\Support\Str::plural('entry', $orders->count()) }}</p>
            {{ $orders->links() }}
        </div>
    </div>
</div>

<script>
document.getElementById('historySearch')?.addEventListener('input', function () {
    const search = this.value.toLowerCase();
    document.querySelectorAll('.history-row').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(search) ? '' : 'none';
    });
});
</script>
@endsection
