<?php

namespace App\Http\Controllers\Delivery\MyAssignOrder;

use App\Http\Controllers\Controller;
use App\Models\OrderAssign;
use Illuminate\Http\Request;

class MyOrderAssignController extends Controller
{
    public function index()
    {
        $deliveryMan = session('delivery_man');
        
        if (!$deliveryMan) {
            return redirect()->route('delivery.login')->with('error', 'Please login first');
        }

        $assignments = OrderAssign::with(['order.customer.addresses', 'order.product', 'order.vendor'])
            ->where('delivery_man_id', $deliveryMan->id)
            ->where('status', '!=', 'rejected') // Exclude rejected assignments
            ->whereHas('order', function($query) {
                // Exclude orders that are already delivered, failed, or cancelled
                $query->whereNotIn('status', ['delivered', 'failed_delivery', 'cancelled']);
            })
            ->latest()
            ->paginate(10);

        // Mark notifications as read
        if ($deliveryMan instanceof \App\Models\DeliveryMan) {
            $deliveryMan->unreadNotifications->markAsRead();
        } else {
            // If it's just data in session, fetch model and mark read
            $dmModel = \App\Models\DeliveryMan::find($deliveryMan->id ?? $deliveryMan['id']);
            if ($dmModel) {
                $dmModel->unreadNotifications->markAsRead();
            }
        }

        return view('delivery.my_assign_order.index', compact('assignments'));
    }

    public function getNotifications()
    {
        $deliveryManId = session('delivery_man')->id ?? session('delivery_man')['id'] ?? null;
        
        if (!$deliveryManId) {
            return response()->json(['unreadCount' => 0, 'notifications' => []]);
        }

        $dmModel = \App\Models\DeliveryMan::find($deliveryManId);
        if (!$dmModel) {
            return response()->json(['unreadCount' => 0, 'notifications' => []]);
        }

        $notifications = $dmModel->notifications()->latest()->take(5)->get()->map(function($n) {
            return [
                'message' => $n->data['message'] ?? 'New notification',
                'time' => $n->created_at->diffForHumans(),
                'url' => $n->data['action_url'] ?? '#',
                'is_read' => $n->read_at !== null
            ];
        });

        return response()->json([
            'unreadCount' => $dmModel->unreadNotifications->count(),
            'notifications' => $notifications
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        $assignment = OrderAssign::findOrFail($id);
        
        // Security check: ensure it belongs to the logged-in delivery man
        if ($assignment->delivery_man_id != session('delivery_man')->id) {
            return back()->with('error', 'Unauthorized action.');
        }

        // Prevent update if already accepted or rejected
        if ($assignment->status != 'pending') {
            return back()->with('error', 'Status has already been updated and cannot be changed.');
        }

        $assignment->update([
            'status' => $request->status,
        ]);

        $message = $request->status == 'accepted' ? 'Order accepted successfully!' : 'Order rejected successfully.';
        return back()->with('success', $message);
    }

    public function updateOrderDeliveryStatus(Request $request, $orderId)
    {
        $request->validate([
            'status' => 'required|in:out_for_delivery,delivered,failed_delivery',
        ]);

        $deliveryMan = session('delivery_man');
        
        // Check if this order is assigned to the current delivery man and accepted
        $assignment = OrderAssign::where('order_id', $orderId)
            ->where('delivery_man_id', $deliveryMan->id)
            ->where('status', 'accepted')
            ->first();

        if (!$assignment) {
            return back()->with('error', 'You are not authorized to update this order status. Make sure you have accepted the assignment first.');
        }

        $order = \App\Models\Order::findOrFail($orderId);
        
        // Prevent updates if already delivered or failed
        if (in_array($order->status, ['delivered', 'failed_delivery'])) {
            return back()->with('info', 'This order status is already finalized.');
        }

        $order->update([
            'status' => $request->status
        ]);

        $statusLabel = str_replace('_', ' ', $request->status);
        return back()->with('success', "Order status updated to {$statusLabel} successfully!");
    }
}
