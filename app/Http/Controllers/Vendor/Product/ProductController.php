<?php

namespace App\Http\Controllers\Vendor\Product;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index()
    {
        $vendor = session('vendor');
        if (!$vendor) {
            return redirect()->route('vendor.login')->with('error', 'Please login first');
        }

        $products = Product::with(['category', 'subCategory', 'subSubCategory', 'brand'])
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
                'additional_images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',

                'description' => 'nullable|string',

                'tags' => 'nullable|array',
                'tags.*' => 'string|max:50',
            ]);


            $data = $request->except(['image', 'additional_image', 'additional_images', 'existing_additional_images']);


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

         

            // Multiple images:
            // form uses additional_images[], DB column is additional_image
            $uploadedAdditionalImages = [];

            if ($request->hasFile('additional_images')) {
                $uploadedAdditionalImages = $request->file('additional_images');
            } elseif ($request->hasFile('additional_image')) {
                // backward compatibility for old field name
                $uploadedAdditionalImages = $request->file('additional_image');
            }

            if (!empty($uploadedAdditionalImages)) {
                $images = [];
                foreach ($uploadedAdditionalImages as $img) {
                    $images[] = $img->store('products', 'public');
                }
                // Product model casts this field to array
                $data['additional_image'] = $images;
            }

            $product = Product::create($data);

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

    public function destroy($id)
    {
        $vendor = session('vendor');
        if (!$vendor) {
            return redirect()->route('vendor.login')->with('error', 'Please login first');
        }

        $product = Product::where('id', $id)
            ->where('vendor_id', $vendor['id'])
            ->first();

        if (!$product) {
            return redirect()->route('vendor.products.index')
                ->with('error', 'Product not found or unauthorized.');
        }

        $product->delete();

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function edit($id)
    {
        $vendor = session('vendor');
        if (!$vendor) {
            return redirect()->route('vendor.login')->with('error', 'Please login first');
        }

        $product = Product::where('id', $id)
            ->where('vendor_id', $vendor['id'])
            ->first();

        if (!$product) {
            return redirect()->route('vendor.products.index')
                ->with('error', 'Product not found or unauthorized.');
        }

        $categories = \App\Models\Category::all();
        $subcategories = \App\Models\SubCategory::all();
        $subsubcategories = \App\Models\SubSubCategory::all();
        $brands = \App\Models\Brand::all();
        $attributes = \App\Models\Attribute::all();

        return view('vendor.product.edit', compact('product', 'categories', 'brands', 'attributes', 'subcategories', 'subsubcategories'));
    }

    public function update(Request $request, $id)
    {
        $vendor = session('vendor');
        if (!$vendor) {
            return redirect()->route('vendor.login')
                ->with('error', 'Please login first');
        }

        $product = Product::where('id', $id)
            ->where('vendor_id', $vendor['id'])
            ->first();

        if (!$product) {
            return redirect()->route('vendor.products.index')
                ->with('error', 'Product not found or unauthorized.');
        }

        if ($request->filled('tags') && is_string($request->tags)) {
            $request->merge([
                'tags' => array_map('trim', explode(',', $request->tags))
            ]);
        }

        try {
            $request->validate([
                'product_name' => 'required|string|max:255',
                'sku' => ['nullable', 'string', 'max:255', Rule::unique('products', 'sku')->ignore($product->id)],
                'unit_price' => 'required|numeric|min:0',
                'product_unit' => 'required|string|max:255',
                'stock_quantity' => 'required|integer|min:0',
                'category_id' => 'required|exists:categories,id',
                'sub_category_id' => 'nullable|exists:sub_categories,id',
                'sub_sub_category_id' => 'nullable|exists:sub_sub_categories,id',
                'brand_id' => 'nullable|exists:brands,id',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'additional_images' => 'nullable|array',
                'additional_images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
                'existing_additional_images' => 'nullable|array',
                'existing_additional_images.*' => 'string',
                'description' => 'nullable|string',
                'tags' => 'nullable|array',
                'tags.*' => 'string|max:50',
            ]);

            $data = $request->except(['image', 'additional_image', 'additional_images', 'existing_additional_images']);
            $data['vendor_id'] = $vendor['id'];
            $data['status'] = $request->has('status') ? 1 : 0;
            $data['vendor_product_status'] = 'pending';

            if ($request->filled('tags')) {
                $data['tags'] = $request->tags;
            } else {
                $data['tags'] = null;
            }

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('products', 'public');
            }

            $currentAdditionalImages = is_array($product->additional_image) ? $product->additional_image : [];
            $requestedExistingImages = $request->input('existing_additional_images', []);
            if (!is_array($requestedExistingImages)) {
                $requestedExistingImages = [];
            }

            // Keep only paths that already belong to this product
            $keptAdditionalImages = array_values(array_intersect($requestedExistingImages, $currentAdditionalImages));

            $uploadedAdditionalImages = [];
            if ($request->hasFile('additional_images')) {
                $uploadedAdditionalImages = $request->file('additional_images');
            } elseif ($request->hasFile('additional_image')) {
                $uploadedAdditionalImages = $request->file('additional_image');
            }

            $newAdditionalImages = [];
            if (!empty($uploadedAdditionalImages)) {
                foreach ($uploadedAdditionalImages as $img) {
                    $newAdditionalImages[] = $img->store('products', 'public');
                }
            }

            // Existing kept images + newly uploaded images
            $data['additional_image'] = array_values(array_merge($keptAdditionalImages, $newAdditionalImages));

            $product->update($data);

            return redirect()->route('vendor.products.index')
                ->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            Log::error('Product update failed', [
                'product_id' => $id,
                'error' => $e->getMessage()
            ]);

            return back()->withInput()->with('error', $e->getMessage());
        }
    }
}
