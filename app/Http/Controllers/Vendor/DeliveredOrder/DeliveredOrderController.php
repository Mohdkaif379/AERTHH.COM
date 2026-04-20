<?php

namespace App\Http\Controllers\Vendor\DeliveredOrder;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class DeliveredOrderController extends Controller
{
    public function index()
    {
        $vendor = session('vendor');
        if (!$vendor) {
            return redirect()->route('vendor.login')->with('error', 'Please login first');
        }

        $orders = Order::with(['product', 'customer'])
            ->where('vendor_id', $vendor['id'])
            ->where('status', 'delivered')
            ->latest()
            ->paginate(10);

        return view('vendor.delivered-orders.index', compact('orders'));
    }
}

