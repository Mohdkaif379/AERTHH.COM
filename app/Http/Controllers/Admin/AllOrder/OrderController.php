<?php

namespace App\Http\Controllers\Admin\AllOrder;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        
        $orders = Order::with(['customer', 'product', 'vendor'])
            ->when($status && $status !== 'all', function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(15);

        return view('admin.all_orders.index', compact('orders', 'status'));
    }
}
