@extends('vendor.layout.navbar')

@section('title', 'Wallet')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="relative overflow-hidden rounded-3xl bg-orange-400 dark:from-slate-800 dark:via-slate-900 dark:to-slate-950 border border-orange-100 dark:border-orange-900/30 shadow-sm">
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-orange-200/30 dark:bg-orange-500/10 rounded-full blur-3xl"></div>
        <div class="relative p-8 sm:p-10">
            <div class="flex items-start justify-between gap-6 flex-col md:flex-row">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-white dark:bg-slate-800 shadow-lg flex items-center justify-center">
                        <i class="fa fa-wallet text-2xl text-orange-500"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">Wallet</h1>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Track your earnings, payouts, and available balance in one place.</p>
                    </div>
                </div>
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur rounded-2xl px-4 py-3 border border-white/60 dark:border-slate-700 shadow-sm">
                    <div class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Available Balance</div>
                    <div class="text-3xl font-black text-orange-600 dark:text-orange-400 mt-1">&#8377;{{ number_format($availableBalance ?? 0, 2) }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-8">
                <div class="bg-white/80 dark:bg-slate-800/80 rounded-2xl p-5 border border-white/60 dark:border-slate-700 shadow-sm">
                    <div class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Total Earnings</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white mt-2">&#8377;{{ number_format($totalEarnings ?? 0, 2) }}</div>
                </div>
                <div class="bg-white/80 dark:bg-slate-800/80 rounded-2xl p-5 border border-white/60 dark:border-slate-700 shadow-sm">
                    <div class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Pending Payout</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white mt-2">&#8377;{{ number_format($pendingPayout ?? 0, 2) }}</div>
                </div>
                <div class="bg-white/80 dark:bg-slate-800/80 rounded-2xl p-5 border border-white/60 dark:border-slate-700 shadow-sm">
                    <div class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">This Month</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white mt-2">&#8377;{{ number_format($thisMonthEarnings ?? 0, 2) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
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
                    <span>Last Payout</span>
                    <span class="font-semibold text-gray-900 dark:text-white">N/A</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Payout Method</span>
                    <span class="font-semibold text-gray-900 dark:text-white">Bank Transfer</span>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm p-6">
            <div class="flex items-center gap-3 mb-4">
                <i class="fa fa-clock text-orange-500"></i>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Activity</h2>
            </div>
            <div class="rounded-xl border border-dashed border-gray-300 dark:border-gray-700 p-6 text-center text-gray-500 dark:text-gray-400">
                No wallet transactions yet.
            </div>
        </div>
    </div>
</div>
@endsection
