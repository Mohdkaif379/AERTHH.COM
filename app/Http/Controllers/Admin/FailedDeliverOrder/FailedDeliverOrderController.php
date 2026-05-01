<?php

namespace App\Http\Controllers\Admin\FailedDeliverOrder;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class FailedDeliverOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['customer', 'product', 'vendor'])
            ->where('status', 'failed_delivery')
            ->latest()
            ->paginate(15);

        return view('admin.failed_orders.index', compact('orders'));
    }
}
