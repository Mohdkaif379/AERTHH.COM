@extends('delivery.layout.navbar')

@section('content')
<div class="space-y-6">
    {{-- Alerts --}}
    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm animate-fade-in-down">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-emerald-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-bold text-emerald-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-xl shadow-sm animate-fade-in-down">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-rose-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-xs font-bold text-rose-800">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h3 class="text-sm font-medium text-gray-700 flex items-center space-x-2">
                <i class="fas fa-truck-loading text-[#FB7185] text-sm"></i>
                <span class="dark:text-white light:text-gray-800">My Assigned Orders</span>
            </h3>
            <p class="text-[10px] text-gray-400">List of orders currently assigned to you for delivery</p>
        </div>

        <div class="w-full lg:w-[360px]">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input
                    type="text"
                    id="orderSearch"
                    placeholder="Search order, customer, product..."
                    class="w-full pl-8 pr-3 py-2 bg-white dark:bg-black/30 border border-slate-100 dark:border-[#22152a] rounded-lg focus:border-[#FB7185] focus:outline-none focus:ring-1 focus:ring-[#FB7185]/10 text-xs dark:text-white transition-all"
                >
            </div>
        </div>
    </div>

    {{-- Orders List --}}
    <div class="bg-white dark:bg-black/30 rounded-xl border border-slate-100 dark:border-[#22152a] shadow-sm overflow-hidden">
        <div class="px-4 py-4 bg-gradient-to-r from-slate-50 to-gray-50 dark:from-black/50 dark:to-black/30 border-b border-slate-100 dark:border-[#22152a]">
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200 flex items-center space-x-2">
                <i class="fas fa-list text-[#FB7185] text-sm"></i>
                <span>Assignment History</span>
            </h3>
        </div>

        @if($assignments->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-black/50 border-y border-gray-100 dark:border-[#22152a]">
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Sr.No</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Order No</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Customer</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Address</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Product</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Total Amount</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Assign Status</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Order Status</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Assigned At</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-[#22152a]">
                        @foreach($assignments as $index => $assign)
                            @php
                                $order = $assign->order;
                                $customerName = ucwords(strtolower(trim(($order->customer->first_name ?? '') . ' ' . ($order->customer->last_name ?? '')) ?: 'Unknown Customer'));
                                $productName = $order->product->product_name ?? 'Unknown Product';
                                $address = $order->customer->addresses->first();
                                $addressString = $address ? "{$address->address_line}, {$address->city}, {$address->state}" : '';
                                
                                $assignStatusClass = match($assign->status) {
                                    'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-100',
                                    'accepted' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                    'rejected' => 'bg-rose-50 text-rose-700 border-rose-100',
                                    default => 'bg-gray-50 text-gray-700 border-gray-100',
                                };

                                $orderStatusClass = match($order->status) {
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
                                
                                $searchData = strtolower(($order->order_no ?? '') . ' ' . $customerName . ' ' . $productName . ' ' . $addressString . ' ' . $order->status);
                            @endphp
                            <tr class="hover:bg-slate-50 dark:hover:bg-[#F43F5E]/5 transition order-row" data-search="{{ $searchData }}">
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                                    {{ ($assignments->currentPage() - 1) * $assignments->perPage() + $index + 1 }}
                                </td>
                                <td class="px-4 py-3 text-[#FB7185] font-bold">
                                    {{ $order->order_no ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                                    {{ $customerName }}
                                </td>
                                <td class="px-4 py-3 text-gray-700 dark:text-gray-300 max-w-[200px]">
                                    @php
                                        $address = $order->customer->addresses->first();
                                    @endphp
                                    @if($address)
                                        @php
                                            $fullAddress = "{$address->address_line}, {$address->city}, {$address->state} - {$address->zip_code}, {$address->country}";
                                        @endphp
                                        <button 
                                            type="button" 
                                            onclick="showFullAddress('{{ addslashes($fullAddress) }}', '{{ $customerName }}')"
                                            class="text-left hover:text-[#FB7185] transition-colors"
                                        >
                                            <p class="truncate font-medium underline decoration-dotted underline-offset-4" title="Click to view full address">
                                                {{ $address->address_line }}
                                            </p>
                                        </button>
                                    @else
                                        <span class="text-gray-400">No Address</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                                    {{ $productName }}
                                </td>
                                <td class="px-4 py-3 text-gray-700 dark:text-gray-300 font-semibold">
                                    ₹{{ number_format((float) $order->total_price, 2) }}
                                </td>
                                <td class="px-4 py-3">
                                    @if($assign->status == 'pending')
                                        <button 
                                            type="button" 
                                            onclick="openStatusModal({{ $assign->id }}, '{{ $assign->status }}')"
                                            class="hover:scale-105 transition-transform"
                                        >
                                            <span class="px-2 py-1 rounded-full text-[10px] font-bold {{ $assignStatusClass }} border uppercase tracking-tighter shadow-sm cursor-pointer" title="Click to update status">
                                                {{ $assign->status }}
                                            </span>
                                        </button>
                                    @else
                                        <span class="px-2 py-1 rounded-full text-[10px] font-bold {{ $assignStatusClass }} border uppercase tracking-tighter shadow-sm opacity-80" title="Status updated">
                                            {{ $assign->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($assign->status == 'accepted' && !in_array($order->status, ['delivered', 'failed_delivery']))
                                        <button 
                                            type="button" 
                                            onclick="openDeliveryModal({{ $order->id }}, '{{ $order->order_no }}', '{{ $order->status }}')"
                                            class="hover:scale-105 transition-transform"
                                        >
                                            <span class="px-2 py-1 rounded-full text-[10px] font-bold {{ $orderStatusClass }} border uppercase tracking-tighter shadow-sm cursor-pointer" title="Click to update delivery status">
                                                {{ str_replace('_', ' ', $order->status) }}
                                            </span>
                                        </button>
                                    @else
                                        <span class="px-2 py-1 rounded-full text-[10px] font-bold {{ $orderStatusClass }} border uppercase tracking-tighter shadow-sm opacity-80">
                                            {{ str_replace('_', ' ', $order->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                                    {{ $assign->assigned_at ? \Carbon\Carbon::parse($assign->assigned_at)->format('d M Y, h:i A') : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-4 sm:px-6 py-4 border-t border-gray-100 dark:border-[#22152a]">
                {{ $assignments->links() }}
            </div>
        @else
            <div class="px-6 py-16 text-center text-gray-400">
                <i class="fas fa-inbox text-3xl mb-3 block text-gray-300"></i>
                No assigned orders found
            </div>
        @endif
    </div>
</div>

{{-- Full Address Modal --}}
<div id="addressModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" onclick="closeAddressModal()"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white dark:bg-[#1a1121] rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border dark:border-[#22152a]">
            <div class="bg-white dark:bg-[#1a1121] px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-slate-100 dark:bg-black/30 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-map-marker-alt text-[#FB7185]"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-bold text-gray-900 dark:text-white" id="modal-title">
                            Customer Shipping Address
                        </h3>
                        <div class="mt-4 p-4 bg-slate-50 dark:bg-black/20 rounded-xl border border-slate-100 dark:border-[#22152a]">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Customer Name</p>
                            <p id="modalCustomerName" class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-4"></p>
                            
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Full Address</p>
                            <p id="modalFullAddress" class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed"></p>
                        </div>
                        
                        <div class="mt-6">
                            <button 
                                type="button"
                                onclick="closeAddressModal()"
                                class="w-full inline-flex justify-center rounded-xl border border-gray-200 dark:border-[#22152a] shadow-sm px-4 py-2.5 bg-white dark:bg-black/30 text-xs font-bold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-[#F43F5E]/5 transition-all"
                            >
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Status Update Modal --}}
<div id="statusModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" onclick="closeStatusModal()"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white dark:bg-[#1a1121] rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border dark:border-[#22152a]">
            <form id="statusForm" method="POST">
                @csrf
                <div class="bg-white dark:bg-[#1a1121] px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-slate-100 dark:bg-black/30 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-tasks text-[#FB7185]"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-bold text-gray-900 dark:text-white" id="modal-title">
                                Update Assignment Status
                            </h3>
                            <div class="mt-4">
                                <p class="text-xs text-gray-500 mb-4 text-center sm:text-left">Choose whether you want to accept or reject this delivery assignment.</p>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <label class="relative flex flex-col items-center p-4 border rounded-xl cursor-pointer hover:bg-slate-50 dark:hover:bg-[#F43F5E]/5 transition-all group has-[:checked]:border-[#FB7185] has-[:checked]:bg-[#FB7185]/5 dark:border-[#22152a]">
                                        <input type="radio" name="status" value="accepted" class="hidden peer">
                                        <i class="fas fa-check-circle text-2xl text-gray-300 peer-checked:text-emerald-500 mb-2"></i>
                                        <span class="text-xs font-bold text-gray-600 dark:text-gray-400 peer-checked:text-[#FB7185]">Accept</span>
                                    </label>

                                    <label class="relative flex flex-col items-center p-4 border rounded-xl cursor-pointer hover:bg-slate-50 dark:hover:bg-[#F43F5E]/5 transition-all group has-[:checked]:border-[#FB7185] has-[:checked]:bg-[#FB7185]/5 dark:border-[#22152a]">
                                        <input type="radio" name="status" value="rejected" class="hidden peer">
                                        <i class="fas fa-times-circle text-2xl text-gray-300 peer-checked:text-rose-500 mb-2"></i>
                                        <span class="text-xs font-bold text-gray-600 dark:text-gray-400 peer-checked:text-[#FB7185]">Reject</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-black/20 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-3 border-t dark:border-[#22152a]">
                    <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-gradient-to-r from-[#F43F5E] to-[#BE123C] text-xs font-bold text-white hover:opacity-90 transition-all sm:ml-3 sm:w-auto">
                        Update Status
                    </button>
                    <button type="button" onclick="closeStatusModal()" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-200 dark:border-[#22152a] shadow-sm px-4 py-2 bg-white dark:bg-black/30 text-xs font-bold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-[#F43F5E]/5 transition-all sm:mt-0 sm:w-auto">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
    </div>
</div>

{{-- Delivery Confirmation Modal --}}
<div id="deliveryModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" onclick="closeDeliveryModal()"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white dark:bg-[#1a1121] rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border dark:border-[#22152a]">
            <form id="deliveryForm" method="POST">
                @csrf
                <div class="bg-white dark:bg-[#1a1121] px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-emerald-100 dark:bg-emerald-900/30 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-shipping-fast text-emerald-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-bold text-gray-900 dark:text-white" id="modal-title">
                                Update Delivery Progress
                            </h3>
                            <div class="mt-4">
                                <p class="text-xs text-gray-500 mb-4">Update the current status for order <span id="modalOrderNo" class="font-bold text-[#FB7185]"></span>.</p>
                                
                                <div id="statusOptions" class="space-y-3">
                                    {{-- Out for Delivery Option --}}
                                    <label id="optionOutForDelivery" class="relative flex items-center p-3 border rounded-xl cursor-pointer hover:bg-slate-50 dark:hover:bg-[#F43F5E]/5 transition-all group has-[:checked]:border-[#FB7185] has-[:checked]:bg-[#FB7185]/5 dark:border-[#22152a]">
                                        <input type="radio" name="status" value="out_for_delivery" class="hidden peer">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-indigo-50 dark:bg-indigo-900/20 flex items-center justify-center text-indigo-600">
                                                <i class="fas fa-truck-loading"></i>
                                            </div>
                                            <div>
                                                <p class="text-[11px] font-bold text-gray-700 dark:text-gray-300">Out for Delivery</p>
                                                <p class="text-[9px] text-gray-400">Order is on its way to the customer</p>
                                            </div>
                                        </div>
                                        <i class="fas fa-check-circle ml-auto text-gray-200 peer-checked:text-[#FB7185]"></i>
                                    </label>

                                    {{-- Delivered Option --}}
                                    <label id="optionDelivered" class="relative flex items-center p-3 border rounded-xl cursor-pointer hover:bg-slate-50 dark:hover:bg-[#F43F5E]/5 transition-all group has-[:checked]:border-[#FB7185] has-[:checked]:bg-[#FB7185]/5 dark:border-[#22152a]">
                                        <input type="radio" name="status" value="delivered" class="hidden peer">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center text-emerald-600">
                                                <i class="fas fa-check-double"></i>
                                            </div>
                                            <div>
                                                <p class="text-[11px] font-bold text-gray-700 dark:text-gray-300">Delivered</p>
                                                <p class="text-[9px] text-gray-400">Order has been successfully handed over</p>
                                            </div>
                                        </div>
                                        <i class="fas fa-check-circle ml-auto text-gray-200 peer-checked:text-[#FB7185]"></i>
                                    </label>

                                    {{-- Failed Option --}}
                                    <label id="optionFailed" class="relative flex items-center p-3 border rounded-xl cursor-pointer hover:bg-slate-50 dark:hover:bg-[#F43F5E]/5 transition-all group has-[:checked]:border-[#FB7185] has-[:checked]:bg-[#FB7185]/5 dark:border-[#22152a]">
                                        <input type="radio" name="status" value="failed_delivery" class="hidden peer">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-rose-50 dark:bg-rose-900/20 flex items-center justify-center text-rose-600">
                                                <i class="fas fa-times-circle"></i>
                                            </div>
                                            <div>
                                                <p class="text-[11px] font-bold text-gray-700 dark:text-gray-300">Failed Delivery</p>
                                                <p class="text-[9px] text-gray-400">Unable to deliver the order</p>
                                            </div>
                                        </div>
                                        <i class="fas fa-check-circle ml-auto text-gray-200 peer-checked:text-[#FB7185]"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-black/20 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-3 border-t dark:border-[#22152a]">
                    <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-gradient-to-r from-[#F43F5E] to-[#BE123C] text-xs font-bold text-white hover:opacity-90 transition-all sm:ml-3 sm:w-auto uppercase tracking-wider">
                        Confirm Status
                    </button>
                    <button type="button" onclick="closeDeliveryModal()" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-200 dark:border-[#22152a] shadow-sm px-4 py-2 bg-white dark:bg-black/30 text-xs font-bold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-[#F43F5E]/5 transition-all sm:mt-0 sm:w-auto">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('orderSearch');
        const rows = document.querySelectorAll('.order-row');
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

    function showFullAddress(address, customerName) {
        document.getElementById('modalFullAddress').innerText = address;
        document.getElementById('modalCustomerName').innerText = customerName;
        document.getElementById('addressModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeAddressModal() {
        document.getElementById('addressModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function openStatusModal(id, currentStatus) {
        const form = document.getElementById('statusForm');
        form.action = `/delivery/my-assigned-orders/${id}/update-status`;
        
        // Pre-select current status if it's accepted or rejected
        const radios = form.querySelectorAll('input[name="status"]');
        radios.forEach(radio => {
            if (radio.value === currentStatus) {
                radio.checked = true;
            } else {
                radio.checked = false;
            }
        });

        document.getElementById('statusModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeStatusModal() {
        document.getElementById('statusModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function openDeliveryModal(orderId, orderNo, currentStatus) {
        const form = document.getElementById('deliveryForm');
        form.action = `/delivery/my-assigned-orders/order/${orderId}/update-delivery-status`;
        document.getElementById('modalOrderNo').innerText = orderNo;
        
        // Hide/Show options based on current status
        const optionOut = document.getElementById('optionOutForDelivery');
        const optionDelivered = document.getElementById('optionDelivered');
        const optionFailed = document.getElementById('optionFailed');

        // Reset selections
        form.querySelectorAll('input[name="status"]').forEach(r => r.checked = false);

        if (currentStatus === 'out_for_delivery') {
            optionOut.classList.add('hidden');
            optionDelivered.classList.remove('hidden');
            optionFailed.classList.remove('hidden');
        } else {
            optionOut.classList.remove('hidden');
            optionDelivered.classList.add('hidden');
            optionFailed.classList.add('hidden');
        }

        document.getElementById('deliveryModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeDeliveryModal() {
        document.getElementById('deliveryModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>
@endpush
