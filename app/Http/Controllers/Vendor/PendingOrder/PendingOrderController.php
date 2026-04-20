<?php

namespace App\Http\Controllers\Vendor\PendingOrder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class PendingOrderController extends Controller
{
    public function index()
    {
        $vendor = session('vendor');
        if (!$vendor) {
            return redirect()->route('vendor.login')->with('error', 'Please login first');
        }

        $orders = Order::with(['product', 'customer'])
            ->where('vendor_id', $vendor['id'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('vendor.pending-orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $vendorId = session('vendor')['id'];

        if (!$vendorId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'status' => 'required|in:pending,confirmed,rejected'
        ]);


        $order = Order::where('vendor_id', $vendorId)
            ->where('id', $id)
            ->firstOrFail();

        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully');
    }
}
