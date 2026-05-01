<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\Order;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login')
                             ->with('error', 'Please login first');
        }

        $orderFilter = $request->query('order_filter', 'daily');
        $withdrawalFilter = $request->query('withdrawal_filter', 'daily');

        $stats = [
            'vendors' => [
                'total' => Vendor::count(),
                'active' => Vendor::where('status', 1)->count(),
                'pending' => Vendor::where('status', 0)->count(),
            ],
            'customers' => [
                'total' => Customer::count(),
                'active' => Customer::where('status', 1)->count(),
                'inactive' => Customer::where('status', 0)->count(),
            ],
            'products' => [
                'total' => Product::count(),
                'approved' => Product::where('vendor_product_status', 'approved')->count(),
                'rejected' => Product::where('vendor_product_status', 'rejected')->count(),
            ],
            'orders' => [
                'all' => Order::count(),
                'today' => Order::whereDate('created_at', now()->today())->count(),
                'pending' => Order::where('status', 'pending')->count(),
                'confirmed' => Order::where('status', 'confirmed')->count(),
                'packaging' => Order::where('status', 'packaging')->count(),
                'out_for_delivery' => Order::where('status', 'out_for_delivery')->count(),
                'delivered' => Order::where('status', 'delivered')->count(),
                'returned' => Order::where('status', 'returned')->count(),
                'failed_delivery' => Order::where('status', 'failed_delivery')->count(),
                'cancelled' => Order::where('status', 'cancelled')->count(),
            ],
            'withdrawals' => [
                'total' => Withdrawal::count(),
                'pending' => Withdrawal::where('status', 'pending')->count(),
                'approved' => Withdrawal::where('status', 'approved')->count(),
                'rejected' => Withdrawal::where('status', 'rejected')->count(),
            ]
        ];

        // --- Order Analytics Data ---
        $orderLabels = [];
        $orderDatasets = [
            'pending' => ['label' => 'Pending', 'color' => '#f59e0b', 'data' => []], // Amber
            'confirmed' => ['label' => 'Confirmed', 'color' => '#3b82f6', 'data' => []], // Blue
            'delivered' => ['label' => 'Delivered', 'color' => '#10b981', 'data' => []], // Emerald
            'cancelled' => ['label' => 'Cancelled', 'color' => '#ef4444', 'data' => []], // Red
            'total' => ['label' => 'Total Orders', 'color' => '#6366f1', 'data' => []], // Indigo
        ];

        $this->populateChartData(Order::query(), $orderFilter, $orderLabels, $orderDatasets);

        // --- Withdrawal Analytics Data ---
        $withdrawalLabels = [];
        $withdrawalDatasets = [
            'pending' => ['label' => 'Pending', 'color' => '#8b5cf6', 'data' => []], // Violet
            'approved' => ['label' => 'Approved', 'color' => '#14b8a6', 'data' => []], // Teal
            'rejected' => ['label' => 'Rejected', 'color' => '#f43f5e', 'data' => []], // Rose
            'total' => ['label' => 'Total Requests', 'color' => '#06b6d4', 'data' => []], // Cyan
        ];

        $this->populateChartData(Withdrawal::query(), $withdrawalFilter, $withdrawalLabels, $withdrawalDatasets);

        // Fetch Recent Data for Tabs
        $recentOrders = Order::with(['customer', 'product', 'vendor'])->latest()->take(10)->get();
        $recentCustomers = Customer::withCount('orders')->latest()->take(10)->get();
        $recentVendors = Vendor::withCount('products')->latest()->take(10)->get();
        $recentProducts = Product::with('vendor')->latest()->take(10)->get();
        $recentWithdrawals = Withdrawal::with('vendor')->latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'stats', 
            'orderLabels', 'orderDatasets', 'orderFilter',
            'withdrawalLabels', 'withdrawalDatasets', 'withdrawalFilter',
            'recentOrders', 'recentCustomers', 'recentVendors', 'recentProducts', 'recentWithdrawals'
        ));
    }

    private function populateChartData($queryBase, $filter, &$labels, &$datasets)
    {
        if ($filter === 'daily') {
            $daysInMonth = date('t');
            for ($d = 1; $d <= $daysInMonth; $d++) {
                $labels[] = 'Day ' . $d;
                foreach ($datasets as $key => &$dataset) {
                    $q = clone $queryBase;
                    $q->whereDay('created_at', $d)->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));
                    if ($key !== 'total') $q->where('status', $key);
                    $dataset['data'][] = $q->count();
                }
            }
        } elseif ($filter === 'weekly') {
            for ($i = 6; $i >= 0; $i--) {
                $date = date('Y-m-d', strtotime("-$i days"));
                $labels[] = date('D', strtotime($date));
                foreach ($datasets as $key => &$dataset) {
                    $q = clone $queryBase;
                    $q->whereDate('created_at', $date);
                    if ($key !== 'total') $q->where('status', $key);
                    $dataset['data'][] = $q->count();
                }
            }
        } elseif ($filter === 'monthly') {
            for ($m = 1; $m <= 12; $m++) {
                $labels[] = date('F', mktime(0, 0, 0, $m, 1));
                foreach ($datasets as $key => &$dataset) {
                    $q = clone $queryBase;
                    $q->whereMonth('created_at', $m)->whereYear('created_at', date('Y'));
                    if ($key !== 'total') $q->where('status', $key);
                    $dataset['data'][] = $q->count();
                }
            }
        } elseif ($filter === 'yearly') {
            for ($i = 4; $i >= 0; $i--) {
                $year = date('Y') - $i;
                $labels[] = (string)$year;
                foreach ($datasets as $key => &$dataset) {
                    $q = clone $queryBase;
                    $q->whereYear('created_at', $year);
                    if ($key !== 'total') $q->where('status', $key);
                    $dataset['data'][] = $q->count();
                }
            }
        }
    }
}
