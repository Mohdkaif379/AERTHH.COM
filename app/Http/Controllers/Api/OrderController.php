<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    // Create a new order
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

        // Decrement product stock quantity
        $product->decrement('stock_quantity', $request->quantity);

        return response()->json([
            'status' => true,
            'message' => 'Order created successfully',
            'data' => $order
        ], 201);
    }
}
