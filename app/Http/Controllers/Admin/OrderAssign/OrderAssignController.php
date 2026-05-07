<?php

namespace App\Http\Controllers\Admin\OrderAssign;

use App\Http\Controllers\Controller;
use App\Models\OrderAssign;
use Illuminate\Http\Request;

class OrderAssignController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'delivery_man_id' => 'required|exists:delivery_men,id',
        ]);

        // Check if already assigned (optional, but good practice)
        $assignment = OrderAssign::updateOrCreate(
            ['order_id' => $request->order_id],
            [
                'delivery_man_id' => $request->delivery_man_id,
                'assigned_at' => now(),
                'status' => 'pending',
            ]
        );

        $deliveryMan = \App\Models\DeliveryMan::find($request->delivery_man_id);
        $order = \App\Models\Order::find($request->order_id);
        
        if ($deliveryMan && $order) {
            $deliveryMan->notify(new \App\Notifications\OrderAssignedNotification($order));
        }

        return back()->with('success', 'Order assigned to delivery man successfully!');
    }
}
