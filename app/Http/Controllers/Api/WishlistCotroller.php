<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class WishlistCotroller extends Controller
{
    public function index(Request $request)
    {
        $wishlists = Wishlist::with('product')
            ->where('customer_id', $request->user()->id)
            ->latest()
            ->get();

        $wishlists->each(function ($wishlist) {
            if ($wishlist->product && $wishlist->product->image && ! str_starts_with($wishlist->product->image, 'http')) {
                $wishlist->product->image = Storage::disk('public')->url($wishlist->product->image);
            }
        });

        return response()->json([
            'status' => true,
            'message' => 'Wishlist items fetched successfully',
            'data' => $wishlists,
        ], 200);
    }

    public function addToWishlist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
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

        $wishlist = Wishlist::where('customer_id', $customer->id)
            ->where('product_id', $product->id)
            ->first();

        if ($wishlist) {
            $wishlist->load('product');

            if ($wishlist->product && $wishlist->product->image && ! str_starts_with($wishlist->product->image, 'http')) {
                $wishlist->product->image = Storage::disk('public')->url($wishlist->product->image);
            }

            return response()->json([
                'status' => true,
                'message' => 'Product already exists in wishlist',
                'data' => $wishlist,
            ], 200);
        }

        $wishlist = Wishlist::create([
            'customer_id' => $customer->id,
            'product_id' => $product->id,
        ]);

        $wishlist->load('product');

        if ($wishlist->product && $wishlist->product->image && ! str_starts_with($wishlist->product->image, 'http')) {
            $wishlist->product->image = Storage::disk('public')->url($wishlist->product->image);
        }

        return response()->json([
            'status' => true,
            'message' => 'Product added to wishlist successfully',
            'data' => $wishlist,
        ], 200);
    }

    public function removeFromWishlist(Request $request, $productId)
    {
        $wishlist = Wishlist::where('customer_id', $request->user()->id)
            ->where('product_id', $productId)
            ->first();

        if (! $wishlist) {
            return response()->json([
                'status' => false,
                'message' => 'Wishlist item not found',
            ], 404);
        }

        $wishlist->delete();

        return response()->json([
            'status' => true,
            'message' => 'Product removed from wishlist successfully',
        ], 200);
    }
}
