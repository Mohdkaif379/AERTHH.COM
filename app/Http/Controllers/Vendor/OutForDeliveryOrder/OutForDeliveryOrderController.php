<?php

namespace App\Http\Controllers\Vendor\OutForDeliveryOrder;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OutForDeliveryOrderController extends Controller
{
    public function index()
    {
        $vendor = session('vendor');
        if (!$vendor) {
            return redirect()->route('vendor.login')->with('error', 'Please login first');
        }

        $orders = Order::with(['product', 'customer'])
            ->where('vendor_id', $vendor['id'])
            ->where('status', 'out_for_delivery')
            ->latest()
            ->paginate(10);

        return view('vendor.out-for-delivery-orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $vendorId = session('vendor')['id'];

        if (!$vendorId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'status' => 'required|in:out_for_delivery,delivered,failed_delivery,returned,cancelled'
        ]);

        $order = Order::where('vendor_id', $vendorId)
            ->where('id', $id)
            ->firstOrFail();

        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully');
    }
}

