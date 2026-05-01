<?php

namespace App\Http\Controllers\Admin\OutDelivery;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OutForDeliveryController extends Controller
{
    public function move($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'out_for_delivery';
        $order->save();

        return redirect()->back()->with('success', 'Order status updated to Out for Delivery');
    }

    public function index()
    {
        $orders = Order::with(['customer', 'product', 'vendor'])
            ->where('status', 'out_for_delivery')
            ->latest()
            ->paginate(15);

        return view('admin.out_for_delivery.index', compact('orders'));
    }
}
