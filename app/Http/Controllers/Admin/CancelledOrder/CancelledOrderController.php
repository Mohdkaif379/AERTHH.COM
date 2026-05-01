<?php

namespace App\Http\Controllers\Admin\CancelledOrder;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class CancelledOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer', 'product', 'vendor'])
            ->where('status', 'cancelled')
            ->latest()
            ->paginate(15);

        return view('admin.cancelled_orders.index', compact('orders'));
    }
}
