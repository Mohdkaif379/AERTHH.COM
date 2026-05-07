@extends('layout.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h3 class="text-sm font-medium text-gray-700 flex items-center space-x-2">
                <i class="fas fa-list text-slate-500 text-sm"></i>
                <span>All Orders</span>
            </h3>
            <p class="text-[10px] text-gray-400">Browse all orders across <span class="font-medium text-slate-600">all statuses</span></p>
        </div>

        <div class="w-full lg:w-[360px]">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input
                    type="text"
                    id="allOrderSearch"
                    placeholder="Search order, customer, product..."
                    class="w-full pl-8 pr-3 py-2 bg-white border border-gray-200 rounded-lg focus:border-slate-300 focus:outline-none focus:ring-1 focus:ring-slate-100 text-xs"
                >
            </div>
        </div>
    </div>

    {{-- Status Filter Tabs --}}
    <div class="overflow-x-auto no-scrollbar">
        <div class="flex items-center space-x-1 p-1 bg-slate-100/50 rounded-xl w-max">
            @php
                $currentStatus = $status ?? 'all';
                $tabs = [
                    'all' => ['label' => 'All Orders', 'icon' => 'fa-list'],
                    'pending' => ['label' => 'Pending', 'icon' => 'fa-clock'],
                    'confirmed' => ['label' => 'Confirmed', 'icon' => 'fa-check-circle'],
                    'packaging' => ['label' => 'Packaging', 'icon' => 'fa-box'],
                    'out_for_delivery' => ['label' => 'Out For Delivery', 'icon' => 'fa-truck'],
                    'delivered' => ['label' => 'Delivered', 'icon' => 'fa-check-double'],
                    'returned' => ['label' => 'Returned', 'icon' => 'fa-undo-alt'],
                    'failed_delivery' => ['label' => 'Failed Delivery', 'icon' => 'fa-exclamation-triangle'],
                    'cancelled' => ['label' => 'Cancelled', 'icon' => 'fa-times-circle'],
                ];
            @endphp

            @foreach($tabs as $key => $tab)
                <a href="{{ route('admin.all-orders.index', ['status' => $key]) }}" 
                   class="flex items-center space-x-2 px-4 py-2 rounded-lg text-[10px] font-bold uppercase tracking-wider transition-all duration-300 {{ $currentStatus === $key ? 'bg-white text-slate-700 shadow-sm' : 'text-gray-500 hover:text-slate-600 hover:bg-white/50' }}">
                    <i class="fas {{ $tab['icon'] }} {{ $currentStatus === $key ? 'text-slate-500' : 'text-gray-400' }}"></i>
                    <span>{{ $tab['label'] }}</span>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
    <div class="m-4 p-3 bg-green-50 border border-green-200 rounded-lg">
        <p class="text-xs text-green-600 flex items-center font-bold">
            <i class="fas fa-check-circle mr-2 text-sm"></i>
            {{ session('success') }}
        </p>
    </div>
    @endif

    <div class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-4 sm:px-6 py-4 bg-gradient-to-r from-slate-50 to-gray-50 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <h3 class="text-sm font-semibold text-gray-700 flex items-center space-x-2">
                <i class="fas fa-shopping-cart text-slate-500 text-sm"></i>
                <span>Order History</span>
            </h3>

            <span class="text-[10px] text-gray-500">
                Total: {{ $orders->total() }} orders
            </span>
        </div>

        @if($orders->count() > 0)
            <div class="md:hidden divide-y divide-gray-100" id="allOrderMobileList">
                @foreach($orders as $index => $order)
                    @php
                        $customerName = trim(($order->customer->first_name ?? '') . ' ' . ($order->customer->last_name ?? '')) ?: 'Unknown Customer';
                        $productName = $order->product->product_name ?? 'Unknown Product';
                        $vendorName = $order->vendor->name ?? 'Unknown Vendor';
                        $statusClass = match($order->status) {
                            'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-100',
                            'confirmed' => 'bg-blue-50 text-blue-700 border-blue-100',
                            'packaging' => 'bg-purple-50 text-purple-700 border-purple-100',
                            'out_for_delivery' => 'bg-indigo-50 text-indigo-700 border-indigo-100',
                            'delivered' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                            'returned' => 'bg-orange-50 text-orange-700 border-orange-100',
                            'failed_delivery' => 'bg-rose-50 text-rose-700 border-rose-100',
                            'cancelled' => 'bg-red-50 text-red-700 border-red-100',
                            default => 'bg-gray-50 text-gray-700 border-gray-100',
                        };
                    @endphp
                    <div class="p-4 space-y-3 all-order-card" data-search="{{ strtolower($order->order_no.' '.$customerName.' '.$productName.' '.$vendorName.' '.$order->status) }}">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-[10px] uppercase tracking-wide text-gray-400">Order #{{ ($orders->currentPage() - 1) * $orders->perPage() + $index + 1 }}</p>
                                <h4 class="text-sm font-semibold text-gray-800">{{ $order->order_no ?? 'N/A' }}</h4>
                            </div>
                            <span class="px-2 py-1 rounded-full text-[10px] font-bold {{ $statusClass }} border uppercase tracking-tighter shadow-sm">
                                {{ str_replace('_', ' ', $order->status) }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                            <div>
                                <p class="text-gray-400">Customer</p>
                                <p class="text-gray-700 font-medium">{{ $customerName }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400">Product</p>
                                <p class="text-gray-700 font-medium">{{ $productName }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400">Vendor</p>
                                <p class="text-gray-700 font-medium">{{ $vendorName }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400">Total</p>
                                <p class="text-gray-700 font-medium">₹{{ number_format((float) $order->total_price, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400">Qty</p>
                                <p class="text-gray-700 font-medium">{{ $order->quantity }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400">Created</p>
                                <p class="text-gray-700 font-medium">{{ optional($order->created_at)->format('d M Y, h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-xs">
                    <thead>
                        <tr class="bg-gray-50 border-y border-gray-100">
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Sr.No</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Order No</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Customer</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Product</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Vendor</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Qty</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Total</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Status</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Created</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($orders as $index => $order)
                            @php
                                $customerName = trim(($order->customer->first_name ?? '') . ' ' . ($order->customer->last_name ?? '')) ?: 'Unknown Customer';
                                $productName = $order->product->product_name ?? 'Unknown Product';
                                $vendorName = $order->vendor->name ?? 'Unknown Vendor';
                                $statusClass = match($order->status) {
                                    'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-100',
                                    'confirmed' => 'bg-blue-50 text-blue-700 border-blue-100',
                                    'packaging' => 'bg-purple-50 text-purple-700 border-purple-100',
                                    'out_for_delivery' => 'bg-indigo-50 text-indigo-700 border-indigo-100',
                                    'delivered' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                    'returned' => 'bg-orange-50 text-orange-700 border-orange-100',
                                    'failed_delivery' => 'bg-rose-50 text-rose-700 border-rose-100',
                                    'cancelled' => 'bg-red-50 text-red-700 border-red-100',
                                    default => 'bg-gray-50 text-gray-700 border-gray-100',
                                };
                            @endphp
                            <tr class="hover:bg-slate-50 transition all-order-row" data-search="{{ strtolower($order->order_no.' '.$customerName.' '.$productName.' '.$vendorName.' '.$order->status) }}">
                                <td class="px-4 py-3 text-gray-600">
                                    {{ ($orders->currentPage() - 1) * $orders->perPage() + $index + 1 }}
                                </td>
                                <td class="px-4 py-3 text-gray-700 font-medium">
                                    {{ $order->order_no ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3 text-gray-700">
                                    {{ $customerName }}
                                </td>
                                <td class="px-4 py-3 text-gray-700">
                                    {{ $productName }}
                                </td>
                                <td class="px-4 py-3 text-gray-700">
                                    {{ $vendorName }}
                                </td>
                                <td class="px-4 py-3 text-gray-700">
                                    {{ $order->quantity }}
                                </td>
                                <td class="px-4 py-3 text-gray-700">
                                    ₹{{ number_format((float) $order->total_price, 2) }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded-full text-[10px] font-bold {{ $statusClass }} border uppercase tracking-tighter shadow-sm">
                                        {{ str_replace('_', ' ', $order->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    {{ optional($order->created_at)->format('d M Y, h:i A') }}
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $assignedId = $order->deliveryMan->first()->delivery_man_id ?? '';
                                    @endphp
                                    <button 
                                        type="button"
                                        onclick="openAssignModal('{{ $order->id }}', '{{ $order->order_no }}', '{{ $assignedId }}')"
                                        class="px-3 py-1 bg-slate-800 text-white text-[10px] font-bold rounded-lg hover:bg-slate-700 transition shadow-sm flex items-center space-x-1"
                                    >
                                        <i class="fas fa-user-plus"></i>
                                        <span>Assign</span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div id="allOrderNoResult" class="hidden px-6 py-16 text-center text-gray-400">
                <i class="fas fa-search text-3xl mb-3 block text-gray-300"></i>
                No matching orders found
            </div>

            <div class="px-4 sm:px-6 py-4 border-t border-gray-100" id="allOrderPagination">
                {{ $orders->links() }}
            </div>
        @else
            <div class="px-6 py-16 text-center text-gray-400" id="allOrderEmptyState">
                <i class="fas fa-inbox text-3xl mb-3 block text-gray-300"></i>
                No orders found in the system
            </div>
        @endif
    </div>
</div>

{{-- Assign Delivery Man Modal --}}
<div id="assignModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" onclick="closeAssignModal()"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-slate-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-truck-loading text-slate-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">
                            Assign Delivery Man
                        </h3>
                        <div class="mt-2">
                            <p class="text-xs text-gray-500">
                                Select a delivery man for Order <span id="modalOrderNo" class="font-bold text-slate-700"></span>
                            </p>
                        </div>

                        <form id="assignForm" action="{{ route('admin.order-assign.store') }}" method="POST" class="mt-4">
                            @csrf
                            <input type="hidden" name="order_id" id="modalOrderId">
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="delivery_man_id" class="block text-[10px] font-bold text-gray-700 uppercase tracking-wider mb-1">Select Delivery Man</label>
                                    <select 
                                        name="delivery_man_id" 
                                        id="delivery_man_id" 
                                        required
                                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:border-slate-300 focus:outline-none focus:ring-1 focus:ring-slate-100 text-xs transition-all"
                                    >
                                        <option value="">-- Choose Delivery Man --</option>
                                        @foreach($deliveryMen as $dm)
                                            <option value="{{ $dm->id }}">{{ $dm->full_name }} ({{ $dm->mobile }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mt-6 flex flex-col sm:flex-row gap-2">
                                <button 
                                    type="submit" 
                                    class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2.5 bg-slate-900 text-xs font-bold text-white hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-all sm:order-2"
                                >
                                    Assign Now
                                </button>
                                <button 
                                    type="button" 
                                    onclick="closeAssignModal()"
                                    class="w-full inline-flex justify-center rounded-xl border border-gray-200 shadow-sm px-4 py-2.5 bg-white text-xs font-bold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-all sm:order-1"
                                >
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('allOrderSearch');
        if (!searchInput) return;

        const rows = Array.from(document.querySelectorAll('.all-order-row'));
        const cards = Array.from(document.querySelectorAll('.all-order-card'));
        const pagination = document.getElementById('allOrderPagination');
        const noResultState = document.getElementById('allOrderNoResult');

        const applyFilter = () => {
            const query = searchInput.value.trim().toLowerCase();
            let visibleCount = 0;

            const match = (el) => {
                const haystack = el.getAttribute('data-search') || '';
                const isVisible = haystack.includes(query);
                el.style.display = isVisible ? '' : 'none';
                if (isVisible) visibleCount++;
            };

            rows.forEach(match);
            cards.forEach(match);

            if (pagination) {
                pagination.classList.toggle('hidden', query.length > 0);
            }

            if (noResultState) {
                noResultState.classList.toggle('hidden', !(query.length > 0 && visibleCount === 0));
            }
        };

        searchInput.addEventListener('input', applyFilter);
    });

    function openAssignModal(orderId, orderNo, assignedId) {
        document.getElementById('modalOrderId').value = orderId;
        document.getElementById('modalOrderNo').innerText = orderNo;
        
        // Filter dropdown
        const select = document.getElementById('delivery_man_id');
        const options = select.options;
        
        for (let i = 0; i < options.length; i++) {
            if (options[i].value === assignedId && assignedId !== '') {
                options[i].hidden = true;
                options[i].disabled = true;
                if (select.value === assignedId) select.value = '';
            } else {
                options[i].hidden = false;
                options[i].disabled = false;
            }
        }

        document.getElementById('assignModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeAssignModal() {
        document.getElementById('assignModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>
@endpush
