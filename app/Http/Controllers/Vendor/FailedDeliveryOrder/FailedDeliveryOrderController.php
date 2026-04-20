<?php

namespace App\Http\Controllers\Vendor\FailedDeliveryOrder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;


class FailedDeliveryOrderController extends Controller
{
    public function index()
    {
        $vendor = session('vendor');
        if (!$vendor) {
            return redirect()->route('vendor.login')->with('error', 'Please login first');
        }

        $orders = Order::with(['product', 'customer'])
            ->where('vendor_id', $vendor['id'])
            ->where('status', 'failed_delivery')
            ->latest()
            ->paginate(10);

        return view('vendor.failed-delivery-orders.index', compact('orders'));
    }
}

