<?php

namespace App\Http\Controllers\Admin\ReturnedOrder;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class ReturnedOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer', 'product', 'vendor'])
            ->where('status', 'returned')
            ->latest()
            ->paginate(15);

        return view('admin.returned_orders.index', compact('orders'));
    }
}
