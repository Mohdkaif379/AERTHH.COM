<?php

namespace App\Http\Controllers\Admin\Delivered;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class DeliveredController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer', 'product', 'vendor'])
            ->where('status', 'delivered')
            ->latest()
            ->paginate(15);

        return view('admin.delivered_orders.index', compact('orders'));
    }

    public function move($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'delivered';
        $order->save();

        return redirect()->back()->with('success', 'Order status updated to Delivered');
    }
}
