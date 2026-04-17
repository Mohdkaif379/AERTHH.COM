<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
   
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        $product = Product::find($request->product_id);
        
        if ($product->stock_quantity < $request->quantity) {
            return response()->json([
                'status' => false,
                'message' => 'Quantity not available'
            ], 400);
        }

        $unit_price = $product->unit_price;
        $discount = $product->discount ?? 0;
        $discount_type = strtolower($product->discount_type ?? '');

        // Apply discount if any
        if ($discount > 0) {
            if ($discount_type === 'percent' || $discount_type === 'percentage') {
                $unit_price = $unit_price - ($unit_price * ($discount / 100));
            } else {
                // assume flat amount
                $unit_price = $unit_price - $discount;
            }
            // price should not be negative
            if ($unit_price < 0) {
                $unit_price = 0;
            }
        }

        $total_price = $unit_price * $request->quantity;
        $shipping_cost = $product->shipping_cost ?? 0;

        // Default statuses
        $status = 'pending';
        $payment_status = 'pending';

        // If Cash On Delivery is chosen
        if (strtolower($request->payment_method) === 'cod') {
            $status = 'confirmed';
        }

        $order = Order::create([
            'customer_id' => $request->user()->id,
            'vendor_id' => $product->vendor_id,
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'total_price' => $total_price,
            'shipping_cost' => $shipping_cost,
            'status' => $status,
            'payment_method' => $request->payment_method,
            'payment_status' => $payment_status, 
        ]);

        $order->order_no = 'ORD' . str_pad((string) $order->id, 4, '0', STR_PAD_LEFT);
        $order->save();

        // Decrement product stock quantity
        $product->decrement('stock_quantity', $request->quantity);

        return response()->json([
            'status' => true,
            'message' => 'Order created successfully',
            'data' => $order
        ], 201);
    }

    // Fetch logged in customer's orders
    public function index(Request $request)
    {
        // Get the authenticated user's ID
        $customerId = $request->user()->id;

        // Fetch orders for this customer, order by latest first, maybe along with product details
        $orders = Order::with('product') 
            ->where('customer_id', $customerId)->whereNotIn('status', ['delivered', 'cancelled'])
            ->orderBy('id', 'desc')
            ->get();

        // Ensure product image is a full URL
        $orders->each(function ($order) {
            if ($order->product && $order->product->image) {
                if (!str_starts_with($order->product->image, 'http')) {
                    // Prepend the asset URL
                    $order->product->image = asset($order->product->image);
                }
            }
        });

        return response()->json([
            'status' => true,
            'message' => 'Orders fetched successfully',
            'data' => $orders
        ], 200);
    }

    public function cancel(Request $request, $orderId)
    {
        $validator = Validator::make($request->all(), [
            'cancel_reason' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $order = Order::where('id', $orderId)
            ->where('customer_id', $request->user()->id)
            ->first();

        if (! $order) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found',
            ], 404);
        }

        if (strtolower($order->status) === 'cancelled') {
            return response()->json([
                'status' => false,
                'message' => 'Order is already canceled',
            ], 400);
        }

        DB::beginTransaction();

        try {
            $product = Product::find($order->product_id);

            if (! $product) {
                DB::rollBack();

                return response()->json([
                    'status' => false,
                    'message' => 'Product not found for this order',
                ], 404);
            }

            $product->increment('stock_quantity', $order->quantity);

            $order->status = 'canceled';
            $order->cancel_reason = $request->cancel_reason;
            $order->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Order canceled successfully',
                'data' => $order,
            ], 200);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Failed to cancel order',
            ], 500);
        }
    }
}
