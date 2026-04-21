<?php

namespace App\Http\Controllers\Vendor\ReurnedOrder;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class ReturnedOrderController extends Controller
{
    public function index(Request $request)
    {
          $vendor = session('vendor');
        if (!$vendor) {
            return redirect()->route('vendor.login')->with('error', 'Please login first');
        }
        $orders = Order::where('vendor_id', $vendor['id'])
                      ->where('status', 'returned')
                      ->with(['customer', 'product'])
                      ->orderBy('created_at', 'desc')
                      ->paginate(15);

        return view('vendor.returned-orders.index', compact('orders'));
    }
}
