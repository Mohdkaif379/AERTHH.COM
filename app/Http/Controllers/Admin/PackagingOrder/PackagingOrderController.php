<?php

namespace App\Http\Controllers\Admin\PackagingOrder;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class PackagingOrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with(['product', 'customer', 'vendor'])
            ->where('status', 'packaging')
            ->orderByDesc('id');

        if ($request->filled('search')) {
            $search = trim($request->search);

            $orders->where(function ($query) use ($search) {
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

        $orders = $orders->paginate(15)->withQueryString();

        return view('admin.packaging_orders.index', compact('orders'));
    }

    public function markAsPackaging($id)
    {
        $order = Order::find($id);

        if (! $order) {
            return back()->with('error', 'Order not found.');
        }

        if (strtolower((string) $order->status) === 'packaging') {
            return back()->with('info', 'Order is already in packaging status.');
        }

        $order->status = 'packaging';
        $order->save();

        return back()->with('success', 'Order moved to packaging successfully.');
    }
}
