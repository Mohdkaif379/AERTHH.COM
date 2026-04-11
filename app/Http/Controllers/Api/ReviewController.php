<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['customer', 'product'])->latest();

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        $reviews = $query->get();

        $reviews->each(function ($review) {
            if ($review->product && $review->product->image && ! str_starts_with($review->product->image, 'http')) {
                $review->product->image = Storage::disk('public')->url($review->product->image);
            }
        });

        return response()->json([
            'status' => true,
            'message' => 'Reviews fetched successfully',
            'data' => $reviews,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
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

        $review = Review::updateOrCreate(
            [
                'customer_id' => $customer->id,
                'product_id' => $product->id,
            ],
            [
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]
        );

        $review->load(['customer', 'product']);

        if ($review->product && $review->product->image && ! str_starts_with($review->product->image, 'http')) {
            $review->product->image = Storage::disk('public')->url($review->product->image);
        }

        return response()->json([
            'status' => true,
            'message' => 'Review saved successfully',
            'data' => $review,
        ], 200);
    }

    public function destroy(Request $request, $productId)
    {
        $review = Review::where('customer_id', $request->user()->id)
            ->where('product_id', $productId)
            ->first();

        if (! $review) {
            return response()->json([
                'status' => false,
                'message' => 'Review not found',
            ], 404);
        }

        $review->delete();

        return response()->json([
            'status' => true,
            'message' => 'Review deleted successfully',
        ], 200);
    }
}
