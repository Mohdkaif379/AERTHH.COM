<?php

namespace App\Http\Controllers\Vendor\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
public function index()
    {
        $vendor = session('vendor');
        if (!$vendor) {
            return redirect()->route('vendor.login')->with('error', 'Please login first');
        }

        $products = \App\Models\Product::with(['category', 'subCategory', 'subSubCategory', 'brand'])
            ->where('vendor_id', $vendor['id'])->get();

        return view('vendor.product.index', compact('products'));
    }


    public function create()
    {
        $vendor = session('vendor');
        if (!$vendor) {
            return redirect()->route('vendor.login')->with('error', 'Please login first');
        }

        $categories = \App\Models\Category::all();
        $subcategories = \App\Models\SubCategory::all();
        $subsubcategories = \App\Models\SubSubCategory::all();
        $brands = \App\Models\Brand::all();
        $attributes = \App\Models\Attribute::all();

        return view('vendor.product.create', compact('categories', 'brands', 'attributes', 'subcategories', 'subsubcategories'));
    }




    public function store(Request $request)
    {
        Log::info('Product store request started', [
            'request_data' => $request->all()
        ]);

        $vendor = session('vendor');

        if (!$vendor) {
            return redirect()->route('vendor.login')
                ->with('error', 'Please login first');
        }

        // ✅ convert tags string → array
        if ($request->filled('tags') && is_string($request->tags)) {
            $request->merge([
                'tags' => array_map('trim', explode(',', $request->tags))
            ]);
        }

        try {

            $request->validate([
                'product_name' => 'required|string|max:255',
                'sku' => 'nullable|string|max:255|unique:products,sku',
                'unit_price' => 'required|numeric|min:0',
                'product_unit' => 'required|string|max:255',
                'stock_quantity' => 'required|integer|min:0',
                'category_id' => 'required|exists:categories,id',
                'sub_category_id' => 'nullable|exists:sub_categories,id',
                'sub_sub_category_id' => 'nullable|exists:sub_sub_categories,id',
                'brand_id' => 'nullable|exists:brands,id',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

                'additional_images' => 'nullable|array',
                'additional_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

                'description' => 'nullable|string',

                'tags' => 'nullable|array',
                'tags.*' => 'string|max:50',
            ]);

            $data = $request->except(['image', 'additional_images']);

            // ✅ vendor id from session
            $data['vendor_id'] = $vendor['id'];

            $data['status'] = 1;
            $data['vendor_product_status'] = 'pending';

            // ✅ tags
            if ($request->filled('tags')) {
                $data['tags'] = $request->tags;
            }

            // ✅ main image
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('products', 'public');
            }

            // ✅ additional images
            $additionalImages = [];

            if ($request->hasFile('additional_images')) {
                foreach ($request->file('additional_images') as $file) {
                    if ($file) {
                        $additionalImages[] = $file->store('products', 'public');
                    }
                }
            }

            if (!empty($additionalImages)) {
                $data['additional_images'] = $additionalImages;
            }

            $product = \App\Models\Product::create($data);

            Log::info('Product created', ['id' => $product->id]);

            return redirect()->route('vendor.products.index')
                ->with('success', 'Product created (Pending)');
        } catch (\Exception $e) {

            Log::error('Product store failed', [
                'error' => $e->getMessage()
            ]);

            return back()->with('error', $e->getMessage());
        }
    }
}
