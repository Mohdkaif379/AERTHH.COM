@extends('delivery.layout.navbar')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h3 class="text-sm font-medium text-gray-700 flex items-center space-x-2">
                <i class="fas fa-history text-[#FB7185] text-sm"></i>
                <span class="dark:text-white light:text-gray-800">Delivery History</span>
            </h3>
            <p class="text-[10px] text-gray-400">List of orders you have completed or attempted</p>
        </div>

        <div class="w-full lg:w-[360px]">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input
                    type="text"
                    id="historySearch"
                    placeholder="Search history..."
                    class="w-full pl-8 pr-3 py-2 bg-white dark:bg-black/30 border border-slate-100 dark:border-[#22152a] rounded-lg focus:border-[#FB7185] focus:outline-none focus:ring-1 focus:ring-[#FB7185]/10 text-xs dark:text-white transition-all"
                >
            </div>
        </div>
    </div>

    {{-- History List --}}
    <div class="bg-white dark:bg-black/30 rounded-xl border border-slate-100 dark:border-[#22152a] shadow-sm overflow-hidden">
        <div class="px-4 py-4 bg-gradient-to-r from-slate-50 to-gray-50 dark:from-black/50 dark:to-black/30 border-b border-slate-100 dark:border-[#22152a]">
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200 flex items-center space-x-2">
                <i class="fas fa-check-double text-[#FB7185] text-sm"></i>
                <span>Completed Tasks</span>
            </h3>
        </div>

        @if($history->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-black/50 border-y border-gray-100 dark:border-[#22152a]">
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Sr.No</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Order No</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Customer</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Product</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Amount</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Status</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Updated At</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-[#22152a]">
                        @foreach($history as $index => $item)
                            @php
                                $order = $item->order;
                                $customerName = ucwords(strtolower(trim(($order->customer->first_name ?? '') . ' ' . ($order->customer->last_name ?? '')) ?: 'Unknown Customer'));
                                $productName = $order->product->product_name ?? 'Unknown Product';
                                
                                $statusClass = match($order->status) {
                                    'delivered' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                    'failed_delivery' => 'bg-rose-50 text-rose-700 border-rose-100',
                                    default => 'bg-gray-50 text-gray-700 border-gray-100',
                                };
                                
                                $searchData = strtolower(($order->order_no ?? '') . ' ' . $customerName . ' ' . $productName . ' ' . $order->status);
                            @endphp
                            <tr class="hover:bg-slate-50 dark:hover:bg-[#F43F5E]/5 transition history-row" data-search="{{ $searchData }}">
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                                    {{ ($history->currentPage() - 1) * $history->perPage() + $index + 1 }}
                                </td>
                                <td class="px-4 py-3 text-[#FB7185] font-bold">
                                    {{ $order->order_no ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                                    {{ $customerName }}
                                </td>
                                <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                                    {{ $productName }}
                                </td>
                                <td class="px-4 py-3 text-gray-700 dark:text-gray-300 font-semibold">
                                    ₹{{ number_format((float) $order->total_price, 2) }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded-full text-[10px] font-bold {{ $statusClass }} border uppercase tracking-tighter shadow-sm">
                                        {{ str_replace('_', ' ', $order->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                                    {{ $order->updated_at ? \Carbon\Carbon::parse($order->updated_at)->format('d M Y, h:i A') : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-4 sm:px-6 py-4 border-t border-gray-100 dark:border-[#22152a]">
                {{ $history->links() }}
            </div>
        @else
            <div class="px-6 py-16 text-center text-gray-400">
                <i class="fas fa-history text-3xl mb-3 block text-gray-300"></i>
                No delivery history found
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('historySearch');
        const rows = document.querySelectorAll('.history-row');
        const pagination = document.querySelector('.px-4.sm\\:px-6.py-4.border-t');

        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            
            rows.forEach(row => {
                const text = row.getAttribute('data-search');
                if (text.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });

            if (pagination) {
                pagination.style.display = query.length > 0 ? 'none' : '';
            }
        });
    });
</script>
@endpush
