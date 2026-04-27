<?php

namespace App\Http\Controllers\Vendor\VendorHistory;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class VendorHistoryController extends Controller
{
    public function index(Request $request)
    {
        $vendor = session('vendor');

        if (! $vendor) {
            return redirect()->route('vendor.login')->with('error', 'Please login first');
        }

        $orders = Order::with(['product', 'customer'])
            ->where('vendor_id', $vendor['id'])
            ->whereIn('status', ['failed_delivery', 'delivered', 'cancelled', 'returned'])
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('vendor.vendor-history.index', compact('orders'));
    }
}
