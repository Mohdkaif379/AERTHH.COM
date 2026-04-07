<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
            ->where(function ($q) {
                $q->whereNull('vendor_id')
                  ->orWhere('vendor_product_status', 'approved');
            })
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
        ->where(function ($q) {
            $q->whereNull('vendor_id')
              ->orWhere('vendor_product_status', 'approved');
        })
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

    // ✅ Store new product
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'unit_price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 422);
        }

        $data = $request->all();

        // Assign vendor details from token
        if ($request->user()) {
            $data['vendor_id'] = $request->user()->id;
            $data['vendor_product_status'] = 'pending';
        }

        // Image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        $product = Product::create($data);

        // Full URL
        if ($product->image) {
            $product->image = url('storage/' . $product->image);
        }

        return response()->json([
            'status' => true,
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }

    // ✅ Update product
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 422);
        }

        $data = $request->all();

        // Image update
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        $product->update($data);

        if ($product->image) {
            $product->image = url('storage/' . $product->image);
        }

        return response()->json([
            'status' => true,
            'message' => 'Product updated successfully',
            'data' => $product
        ]);
    }

    // ✅ Delete product
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'status' => true,
            'message' => 'Product deleted successfully'
        ]);
    }
}
