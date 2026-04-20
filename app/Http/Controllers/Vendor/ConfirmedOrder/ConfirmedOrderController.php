<?php

namespace App\Http\Controllers\Vendor\ConfirmedOrder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class ConfirmedOrderController extends Controller
{
    public function index()
    {
        $vendor = session('vendor');
        if (!$vendor) {
            return redirect()->route('vendor.login')->with('error', 'Please login first');
        }

        $orders = Order::with(['product', 'customer'])
            ->where('vendor_id', $vendor['id'])
            ->where('status', 'confirmed')
            ->latest()
            ->paginate(10);

        return view('vendor.confirmed-orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $vendorId = session('vendor')['id'];

        if (!$vendorId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'status' => 'required|in:pending,confirmed,packaging,rejected,cancelled'
        ]);

        $order = Order::where('vendor_id', $vendorId)
            ->where('id', $id)
            ->firstOrFail();

        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully');
    }
}

