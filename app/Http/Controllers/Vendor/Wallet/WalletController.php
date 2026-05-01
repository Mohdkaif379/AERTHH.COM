<?php

namespace App\Http\Controllers\Vendor\Wallet;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index(Request $request)
    {
        $vendor = session('vendor');
        if (!$vendor) {
            return redirect()->route('vendor.login')->with('error', 'Please login first');
        }

        $deliveredOrdersQuery = Order::where('vendor_id', $vendor['id'])
            ->where('status', 'delivered');

        $totalEarnings = (clone $deliveredOrdersQuery)
            ->get()
            ->sum(function (Order $order) {
                return (float) $order->total_price + (float) ($order->shipping_cost ?? 0);
            });

        $thisMonthEarnings = (clone $deliveredOrdersQuery)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->get()
            ->sum(function (Order $order) {
                return (float) $order->total_price + (float) ($order->shipping_cost ?? 0);
            });

        // Pending Payout: Only show pending withdrawals
        $pendingPayout = Withdrawal::where('vendor_id', $vendor['id'])
            ->where('status', 'pending')
            ->sum('amount');

        // Total Withdrawn (Approved)
        $totalWithdrawn = Withdrawal::where('vendor_id', $vendor['id'])
            ->where('status', 'approved')
            ->sum('amount');

        // This Month Withdrawn (Approved this month)
        $thisMonthWithdrawn = Withdrawal::where('vendor_id', $vendor['id'])
            ->where('status', 'approved')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        $availableBalance = $totalEarnings - ($pendingPayout + $totalWithdrawn);

        $recentWithdrawals = Withdrawal::where('vendor_id', $vendor['id'])
            ->latest()
            ->take(5)
            ->get();

        $lastWithdrawal = Withdrawal::where('vendor_id', $vendor['id'])
            ->latest()
            ->first();

        return view('vendor.wallet.index', compact(
            'totalEarnings',
            'thisMonthEarnings',
            'pendingPayout',
            'totalWithdrawn',
            'thisMonthWithdrawn',
            'availableBalance',
            'recentWithdrawals',
            'lastWithdrawal'
        ));
    }
}
