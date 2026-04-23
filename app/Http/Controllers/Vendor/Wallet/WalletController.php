<?php

namespace App\Http\Controllers\Vendor\Wallet;

use App\Http\Controllers\Controller;
use App\Models\Order;
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

        $pendingPayout = 0;
        $availableBalance = $totalEarnings - $pendingPayout;

        return view('vendor.wallet.index', compact(
            'totalEarnings',
            'thisMonthEarnings',
            'pendingPayout',
            'availableBalance'
        ));
    }
}
