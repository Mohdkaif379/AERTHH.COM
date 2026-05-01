@extends('vendor.layout.navbar')

@section('title', 'Wallet')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-orange-50 via-white to-amber-50 dark:from-slate-900 dark:via-slate-900 dark:to-slate-950 border border-orange-100 dark:border-orange-900/30 shadow-sm">
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-orange-200/50 dark:bg-orange-500/10 rounded-full blur-3xl"></div>
        <div class="relative p-8 sm:p-10">
            <div class="flex items-start justify-between gap-6 flex-col md:flex-row">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-white dark:bg-slate-800 shadow-lg flex items-center justify-center border border-orange-100 dark:border-slate-700">
                        <i class="fa fa-wallet text-2xl text-orange-500"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">Wallet</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Track your earnings, payouts, and available balance in one place.</p>
                    </div>
                </div>
                <div class="flex flex-col items-start sm:items-end gap-2">
                    <div class="bg-white/90 dark:bg-slate-800/80 backdrop-blur rounded-lg px-2 py-1.5 border border-white/70 dark:border-slate-700 shadow-sm">
                        <div class="text-[8px] uppercase tracking-wide text-gray-500 dark:text-gray-400">Available Balance</div>
                        <div class="text-base font-black text-orange-600 dark:text-orange-400 mt-0.5">&#8377;{{ number_format($availableBalance ?? 0, 2) }}</div>
                    </div>
                    <button type="button" class="inline-flex items-center justify-center gap-1.5 rounded-lg bg-orange-500 px-2.5 py-1.5 text-[10px] font-semibold text-white shadow-sm transition hover:bg-orange-600">
                        <i class="fa fa-arrow-up-right-from-square text-[10px]"></i>
                        Withdrawal
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-8">
                <div class="bg-white/90 dark:bg-slate-800/80 rounded-2xl p-5 border border-orange-100 dark:border-slate-700 shadow-sm">
                    <div class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Total Earnings</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white mt-2">&#8377;{{ number_format($totalEarnings ?? 0, 2) }}</div>
                </div>
                <div class="bg-white/90 dark:bg-slate-800/80 rounded-2xl p-5 border border-orange-100 dark:border-slate-700 shadow-sm">
                    <div class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Pending Payout</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white mt-2">&#8377;{{ number_format($pendingPayout ?? 0, 2) }}</div>
                </div>
                <div class="bg-white/90 dark:bg-slate-800/80 rounded-2xl p-5 border border-orange-100 dark:border-slate-700 shadow-sm">
                    <div class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">This Month Withdrawn</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white mt-2">&#8377;{{ number_format($thisMonthWithdrawn ?? 0, 2) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6 items-start">
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
            <div class="flex items-center gap-3 mb-4">
                <i class="fa fa-chart-line text-orange-500"></i>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Wallet Summary</h2>
            </div>
            <div class="space-y-4 text-sm text-gray-600 dark:text-gray-300">
                <div class="flex items-center justify-between">
                    <span>Current Balance</span>
                    <span class="font-semibold text-gray-900 dark:text-white">&#8377;{{ number_format($availableBalance ?? 0, 2) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Total Withdrawn</span>
                    <span class="font-semibold text-gray-900 dark:text-white">&#8377;{{ number_format($totalWithdrawn ?? 0, 2) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Payout Method</span>
                    <span class="font-semibold text-gray-900 dark:text-white">
                        @if($lastWithdrawal)
                            {{ $lastWithdrawal->payment_type == 'upi' ? 'UPI ID' : 'Bank Transfer' }}
                        @else
                            N/A
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
            <div class="flex items-center gap-3 mb-4">
                <i class="fa fa-clock text-orange-500"></i>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Activity</h2>
            </div>
            @if($recentWithdrawals->count() > 0)
            <div class="space-y-4">
                @foreach($recentWithdrawals as $withdrawal)
                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-800/50 rounded-xl border border-gray-100 dark:border-slate-700">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg {{ $withdrawal->payment_type == 'upi' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-600' : 'bg-purple-100 dark:bg-purple-900/30 text-purple-600' }} flex items-center justify-center">
                            <i class="fa {{ $withdrawal->payment_type == 'upi' ? 'fa-mobile-screen' : 'fa-university' }}"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900 dark:text-white">Withdrawal ({{ ucwords(str_replace('_', ' ', $withdrawal->payment_type)) }})</p>
                            <p class="text-[10px] text-gray-500">{{ $withdrawal->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-900 dark:text-white">₹{{ number_format($withdrawal->amount, 2) }}</p>
                        @php
                            $statusClasses = [
                                'pending' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                                'approved' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
                                'rejected' => 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400',
                            ];
                            $statusClass = $statusClasses[$withdrawal->status] ?? 'bg-gray-100 text-gray-700';
                        @endphp
                        <span class="inline-block px-2 py-0.5 text-[8px] font-black uppercase rounded-full {{ $statusClass }}">
                            {{ $withdrawal->status }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="rounded-xl border border-dashed border-gray-300 dark:border-gray-700 p-6 text-center text-gray-500 dark:text-gray-400">
                No withdrawal activities yet.
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
