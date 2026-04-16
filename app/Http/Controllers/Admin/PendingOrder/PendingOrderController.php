<?php

namespace App\Http\Controllers\Admin\PendingOrder;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class PendingOrderController extends Controller
{
    public function index(Request $request)
    {
        $pendingOrders = Order::with(['product', 'customer', 'vendor'])
            ->where('status', 'pending')
            ->orderByDesc('id');

        if ($request->filled('search')) {
            $search = trim($request->search);

            $pendingOrders->where(function ($query) use ($search) {
                $query->where('order_no', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($customerQuery) use ($search) {
                        $customerQuery->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('product', function ($productQuery) use ($search) {
                        $productQuery->where('product_name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('vendor', function ($vendorQuery) use ($search) {
                        $vendorQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $pendingOrders = $pendingOrders->paginate(15)->withQueryString();

        return view('admin.pending-order.index', compact('pendingOrders'));
    }
}
