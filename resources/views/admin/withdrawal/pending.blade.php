@extends('layout.app')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-sm font-medium text-gray-700">Pending Withdrawals</h3>
            <p class="text-[10px] text-gray-400">Review and process vendor payout requests</p>
        </div>
    </div>

    {{-- Withdrawal List Card --}}
    <div class="bg-white rounded-xl border border-cyan-100/50 shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-cyan-50 to-emerald-50 border-b border-cyan-100/50">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-700">Pending Requests List</h3>
                
                {{-- Search --}}
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="text" 
                           id="search-input"
                           placeholder="Search vendors or IDs..."
                           class="w-56 pl-8 pr-3 py-1.5 bg-white/90 border border-gray-200 rounded-lg focus:border-cyan-300 focus:outline-none focus:ring-1 focus:ring-cyan-100 transition-all duration-300 text-xs text-gray-600 placeholder-gray-400">
                </div>
            </div>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
        <div class="m-4 p-3 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-xs text-green-600 flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </p>
        </div>
        @endif

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Sr.No</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Vendor</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Method</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Payout Details</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Requested At</th>
                        <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50" id="table-body">
                    @forelse($pendingWithdrawals as $index => $withdrawal)
                    <tr class="hover:bg-cyan-50/20 transition-all duration-200">
                        <td class="px-6 py-4 text-[11px] text-gray-500 font-medium">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-lg overflow-hidden bg-gray-100 border border-gray-100 shrink-0 shadow-sm">
                                    @if(optional($withdrawal->vendor)->image)
                                        <img src="{{ asset(str_replace(['vendor/', 'storage/app/public/'], ['', 'storage/'], $withdrawal->vendor->image)) }}" 
                                             alt="{{ $withdrawal->vendor->name }}" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-cyan-500 to-emerald-500 flex items-center justify-center text-white font-bold text-[10px]">
                                            {{ substr($withdrawal->vendor->name ?? 'V', 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-gray-700">{{ $withdrawal->vendor->name ?? 'Unknown' }}</span>
                                    <span class="text-[10px] text-gray-400">ID: #{{ $withdrawal->vendor_id }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($withdrawal->payment_type == 'upi')
                                <span class="inline-flex items-center px-2 py-1 bg-blue-50 text-blue-600 text-[9px] font-black uppercase rounded-md border border-blue-100">
                                    <i class="fas fa-mobile-screen mr-1.5"></i> UPI
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 bg-purple-50 text-purple-600 text-[9px] font-black uppercase rounded-md border border-purple-100">
                                    <i class="fas fa-university mr-1.5"></i> Bank
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col gap-0.5">
                                @if($withdrawal->payment_type == 'upi')
                                    <p class="text-[10px] text-gray-600"><span class="text-gray-400">UPI ID:</span> {{ $withdrawal->upi_id }}</p>
                                @else
                                    <p class="text-[10px] text-gray-600"><span class="text-gray-400">Bank:</span> {{ $withdrawal->bank_name }}</p>
                                    <p class="text-[10px] text-gray-600"><span class="text-gray-400">Acc No:</span> {{ $withdrawal->account_number }}</p>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-black text-emerald-600">₹{{ number_format($withdrawal->amount, 2) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-[10px] text-gray-600">{{ $withdrawal->created_at->format('d M Y') }}</span>
                                <span class="text-[9px] text-gray-400">{{ $withdrawal->created_at->format('h:i A') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center space-x-2">
                                <button type="button" 
                                        onclick="openConfirmModal('{{ route('admin.pending-withdrawals.approve', $withdrawal->id) }}', 'Approve Withdrawal', 'Are you sure you want to approve this payout request? This action will mark the request as completed.')"
                                        class="px-3 py-1.5 bg-gradient-to-r from-cyan-500 to-emerald-500 text-white text-[10px] font-bold rounded-lg hover:from-cyan-600 hover:to-emerald-600 transition-all duration-200 shadow-sm">
                                    Approve
                                </button>
                                <button type="button" 
                                        onclick="openConfirmModal('{{ route('admin.pending-withdrawals.reject', $withdrawal->id) }}', 'Reject Withdrawal', 'Are you sure you want to reject this payout request? This action cannot be undone.')"
                                        class="px-3 py-1.5 bg-gray-100 text-gray-600 text-[10px] font-bold rounded-lg hover:bg-rose-50 hover:text-rose-600 transition-all duration-200 border border-gray-200 hover:border-rose-100">
                                    Reject
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-400 text-xs italic">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <i class="fas fa-wallet text-2xl text-gray-200"></i>
                                <span>No pending withdrawal requests found.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Custom Confirmation Modal -->
<div id="confirmModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-black/40 backdrop-blur-sm" onclick="closeConfirmModal()"></div>
        
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full border border-cyan-100/50">
            <div class="bg-white px-6 pt-6 pb-4">
                <div class="flex flex-col items-center">
                    <div id="modalIconContainer" class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-cyan-50 border border-cyan-100 mb-4">
                        <i id="modalIcon" class="fas fa-question text-cyan-600"></i>
                    </div>
                    <div class="text-center">
                        <h3 id="modalTitle" class="text-sm font-bold text-gray-900 mb-2">Confirm Action</h3>
                        <p id="modalDescription" class="text-[10px] text-gray-500 leading-relaxed">Are you sure you want to proceed with this action?</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-2">
                <form id="confirmForm" method="POST">
                    @csrf
                    <button type="submit" id="modalConfirmBtn" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-gradient-to-r from-cyan-500 to-emerald-500 text-white text-[10px] font-bold hover:from-cyan-600 hover:to-emerald-600 transition-all duration-200">
                        Confirm
                    </button>
                </form>
                <button type="button" onclick="closeConfirmModal()" class="w-full inline-flex justify-center rounded-lg border border-gray-200 shadow-sm px-4 py-2 bg-white text-[10px] font-bold text-gray-700 hover:bg-gray-50 transition-all duration-200">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('search-input')?.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        const rows = document.querySelectorAll('#table-body tr');
        
        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    });

    const modal = document.getElementById('confirmModal');
    const form = document.getElementById('confirmForm');
    const title = document.getElementById('modalTitle');
    const desc = document.getElementById('modalDescription');
    const iconContainer = document.getElementById('modalIconContainer');
    const icon = document.getElementById('modalIcon');
    const confirmBtn = document.getElementById('modalConfirmBtn');

    function openConfirmModal(actionUrl, actionTitle, actionDesc) {
        form.action = actionUrl;
        title.innerText = actionTitle;
        desc.innerText = actionDesc;
        
        // Update UI based on action type
        if (actionTitle.toLowerCase().includes('reject')) {
            iconContainer.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-rose-50 border border-rose-100 mb-4';
            icon.className = 'fas fa-exclamation-triangle text-rose-600';
            confirmBtn.className = 'w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-rose-500 text-white text-[10px] font-bold hover:bg-rose-600 transition-all duration-200';
        } else {
            iconContainer.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-emerald-50 border border-emerald-100 mb-4';
            icon.className = 'fas fa-check-circle text-emerald-600';
            confirmBtn.className = 'w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-gradient-to-r from-cyan-500 to-emerald-500 text-white text-[10px] font-bold hover:from-cyan-600 hover:to-emerald-600 transition-all duration-200';
        }

        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeConfirmModal() {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
</script>
@endsection
