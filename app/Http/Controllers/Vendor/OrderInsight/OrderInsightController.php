<?php

namespace App\Http\Controllers\Vendor\OrderInsight;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
use DB;

class OrderInsightController extends Controller
{
    public function index()
    {
        $vendor = session('vendor');

        if (!$vendor) {
            return redirect()->route('vendor.login')->with('error', 'Please login first');
        }

        $startDate = Carbon::now()->subDays(6);

        // Daily trend (last 7 days)
        $orders = Order::where('vendor_id', $vendor['id'])
            ->whereDate('created_at', '>=', $startDate)
            ->orderBy('created_at', 'desc')
            ->select('id', 'vendor_id', 'created_at', 'total_price')
            ->get()
            ->groupBy(function ($order) {
                return $order->created_at->format('Y-m-d');
            });

        $dates = [];
        $counts = [];
        $totalRevenue = 0;
        $totalOrders = 0;

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dates[] = Carbon::parse($date)->format('M d');
            $dayOrders = $orders->get($date, collect());
            $dayCount = $dayOrders->count();
            $counts[] = $dayCount;
            $totalOrders += $dayCount;
            $totalRevenue += $dayOrders->sum('total_price');
        }

        $avgDailyOrders = $totalOrders / 7;

        // Status wise orders (all time for this vendor)
        $statusOrders = Order::where('vendor_id', $vendor['id'])
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return view('vendor.order-insight.index', compact(
            'dates',
            'counts',
            'totalRevenue',
            'totalOrders',
            'avgDailyOrders',
            'statusOrders'
        ));
    }
}

