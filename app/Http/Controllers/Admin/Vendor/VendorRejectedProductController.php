<?php

namespace App\Http\Controllers\Admin\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class VendorRejectedProductController extends Controller
{
    public function index()
    {
        $products = Product::where('vendor_product_status', 'rejected')
            ->with('vendor')
            ->latest()
            ->paginate(10);

        return view('admin.vendor.rejected-products.index', compact('products'));
    }
}
