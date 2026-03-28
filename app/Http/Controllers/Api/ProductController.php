<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Return active products with related category and brand details.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'subCategory', 'subSubCategory', 'brand', 'attribute'])
            ->where('status', 1)
            ->latest();

        if ($request->filled('search')) {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', (int) $request->category_id);
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', (int) $request->brand_id);
        }

        $products = $query->get()->map(function ($product) {
            if ($product->image && !str_starts_with($product->image, 'http')) {
                $product->image = Storage::disk('public')->url($product->image);
            }

            $product->additional_image = collect($product->additional_image)->map(function ($image) {
                if (!$image || str_starts_with($image, 'http')) {
                    return $image;
                }

                return Storage::disk('public')->url($image);
            })->values();

            return $product;
        });

        return response()->json($products);
    }

  
public function show($id)
{
    $product = Product::with(['category', 'subCategory', 'subSubCategory', 'brand', 'attribute'])
        ->where('status', 1)
        ->find($id);

    if (!$product) {
        return response()->json([
            'message' => 'Product not found'
        ], 404);
    }

    // Main image URL fix
    if ($product->image && !str_starts_with($product->image, 'http')) {
        $product->image = Storage::disk('public')->url($product->image);
    }

    // Additional images URL fix
    $product->additional_image = collect($product->additional_image)->map(function ($image) {
        if (!$image || str_starts_with($image, 'http')) {
            return $image;
        }

        return Storage::disk('public')->url($image);
    })->values();

    return response()->json($product);
}
}
