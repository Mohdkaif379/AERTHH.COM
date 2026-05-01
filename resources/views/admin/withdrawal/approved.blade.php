@extends('layout.app')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-sm font-medium text-gray-700">Approved Withdrawals</h3>
            <p class="text-[10px] text-gray-400">View all successfully processed vendor payouts</p>
        </div>
    </div>

    {{-- Withdrawal List Card --}}
    <div class="bg-white rounded-xl border border-cyan-100/50 shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-cyan-50 to-emerald-50 border-b border-cyan-100/50">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-700">Approved Payouts List</h3>
                
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
                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-wider">Processed At</th>
                        <th class="px-6 py-4 text-center text-[10px] font-bold text-gray-400 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50" id="table-body">
                    @forelse($approvedWithdrawals as $index => $withdrawal)
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
                                <span class="text-[10px] text-gray-600">{{ $withdrawal->updated_at->format('d M Y') }}</span>
                                <span class="text-[9px] text-gray-400">{{ $withdrawal->updated_at->format('h:i A') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2 py-0.5 bg-emerald-50 text-emerald-600 text-[9px] font-black uppercase rounded-full border border-emerald-100">
                                <i class="fas fa-check-circle mr-1"></i> {{ $withdrawal->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-400 text-xs italic">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <i class="fas fa-receipt text-2xl text-gray-200"></i>
                                <span>No approved payouts found.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
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
</script>
@endsection
