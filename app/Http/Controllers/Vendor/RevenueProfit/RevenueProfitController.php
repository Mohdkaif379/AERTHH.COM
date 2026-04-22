<?php

namespace App\Http\Controllers\Vendor\RevenueProfit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RevenueProfitController extends Controller
{
    public function index()
    {
        $vendor = Session::get('vendor');

        if (!$vendor) {
            return redirect()->route('vendor.login')->with('error', 'Please login first');
        }

        $vendorId = $vendor['id'];

        // Fetch all orders for this vendor
        $ordersQuery = Order::where('vendor_id', $vendorId)
            ->where('status', '!=', 'cancelled')
            ->select('total_price', 'shipping_cost');

        // Revenue = sum(total_price)
        $revenue = $ordersQuery->sum('total_price') ?? 0;

        // Total shipping cost
        $totalShippingCost = $ordersQuery->sum('shipping_cost') ?? 0;

        // Profit = revenue + shipping_cost (as requested)
        $profit = $revenue + $totalShippingCost;



        // Monthly breakdown (last 6 months)
        $monthlyData = Order::where('vendor_id', $vendorId)
            ->where('status', '!=', 'cancelled')
            ->whereYear('created_at', '>=', now()->subMonths(6)->year)
            ->selectRaw('
                DATE_FORMAT(created_at, "%Y-%m") as month,
                SUM(total_price) as monthly_revenue,
                SUM(shipping_cost) as monthly_shipping,
                (SUM(total_price) + COALESCE(SUM(shipping_cost), 0)) as monthly_profit

            ')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $months = [];
        $revenues = [];
        $profits = [];

        $currentMonth = now()->format('Y-m');
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('Y-m');
            $months[] = now()->subMonths($i)->format('M Y');

            $monthData = $monthlyData->where('month', $month)->first();
            $revenues[] = $monthData ? $monthData->monthly_revenue : 0;
            $profits[] = $monthData ? $monthData->monthly_profit : 0;
        }

        return view('vendor.revenue-profit.index', compact(
            'revenue',
            'totalShippingCost',
            'profit',
            'months',
            'revenues',
            'profits',
            'vendor'
        ));
    }
}
