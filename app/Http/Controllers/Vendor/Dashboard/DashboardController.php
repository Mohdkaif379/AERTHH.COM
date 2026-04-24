<?php

namespace App\Http\Controllers\Vendor\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

 public function vendor_dashboard(Request $request)
{
    // check session
    if (!session()->has('vendor')) {
        return redirect()->route('vendor.login')
            ->with('error', 'Please login first');
    }
$vendor = \App\Models\Vendor::find(session('vendor')['id']);
    
    $vendorId = $vendor['id'];

    // Revenue, Shipping, Profit (all time)
    $ordersQuery = \App\Models\Order::where('vendor_id', $vendorId)
      ->where('status',  'delivered') // only consider completed/shipped orders for revenue
        ->select('total_price', 'shipping_cost');

    $revenue = $ordersQuery->sum('total_price') ?? 0;
    $totalShippingCost = $ordersQuery->sum('shipping_cost') ?? 0;
    $profit = $revenue + $totalShippingCost; // as per previous feedback

    // Order status counts
    $statusCounts = \App\Models\Order::where('vendor_id', $vendorId)
        ->selectRaw('status, COUNT(*) as count')
        ->groupBy('status')
        ->pluck('count', 'status');

    // Monthly revenue/profit (last 6 months)
    $monthlyData = \App\Models\Order::where('vendor_id', $vendorId)
    ->where('status',  'delivered')
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
    for ($i = 5; $i >= 0; $i--) {
        $month = now()->subMonths($i)->format('Y-m');
        $months[] = now()->subMonths($i)->format('M Y');
        
        $monthData = $monthlyData->where('month', $month)->first();
        $revenues[] = $monthData ? $monthData->monthly_revenue : 0;
        $profits[] = $monthData ? $monthData->monthly_profit : 0;
    }

    return view('vendor.dashboard.dashboard', compact(
        'vendor', 'revenue', 'totalShippingCost', 'profit', 
        'statusCounts', 'months', 'revenues', 'profits'
    ));
}

}
