<?php

namespace App\Http\Controllers\Delivery\MyDeliveredHistory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyDeliveredHistoryController extends Controller
{
    public function index()
    {
        $deliveryMan = session('delivery_man');
        
        if (!$deliveryMan) {
            return redirect()->route('delivery.login')->with('error', 'Please login first');
        }

        $history = \App\Models\OrderAssign::with(['order.customer.addresses', 'order.product', 'order.vendor'])
            ->where('delivery_man_id', $deliveryMan->id)
            ->where('status', 'accepted')
            ->whereHas('order', function($query) {
                $query->whereIn('status', ['delivered', 'failed_delivery']);
            })
            ->latest()
            ->paginate(10);

        return view('delivery.my_delivered_history.index', compact('history'));
    }
}
