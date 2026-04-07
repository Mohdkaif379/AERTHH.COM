<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $carts = Cart::with('product')
            ->where('customer_id', $request->user()->id)
            ->latest()
            ->get();

        $carts->each(function ($cart) {
            if ($cart->product && $cart->product->image && ! str_starts_with($cart->product->image, 'http')) {
                $cart->product->image = asset($cart->product->image);
            }
        });

        return response()->json([
            'status' => true,
            'message' => 'Cart items fetched successfully',
            'data' => $carts,
        ], 200);
    }

    public function addToCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $customer = $request->user();
        $product = Product::find($request->product_id);
        $quantity = $request->quantity ?? 1;

        $cart = Cart::where('customer_id', $customer->id)
            ->where('product_id', $product->id)
            ->first();

        $cartQuantity = $cart ? $cart->quantity + $quantity : $quantity;

        if ($product->stock_quantity < $cartQuantity) {
            return response()->json([
                'status' => false,
                'message' => 'Requested quantity not available',
            ], 400);
        }

        if ($cart) {
            $cart->quantity = $cartQuantity;
            $cart->save();
        } else {
            $cart = Cart::create([
                'customer_id' => $customer->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }

        $cart->load('product');

        return response()->json([
            'status' => true,
            'message' => 'Product added to cart successfully',
            'data' => $cart,
        ], 200);
    }

    public function removeFromCart(Request $request, $productId)
    {
        $cart = Cart::where('customer_id', $request->user()->id)
            ->where('product_id', $productId)
            ->first();

        if (! $cart) {
            return response()->json([
                'status' => false,
                'message' => 'Cart item not found',
            ], 404);
        }

        $cart->delete();

        return response()->json([
            'status' => true,
            'message' => 'Product removed from cart successfully',
        ], 200);
    }
}
