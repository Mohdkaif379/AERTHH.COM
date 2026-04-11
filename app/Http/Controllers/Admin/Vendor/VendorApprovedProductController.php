<?php

namespace App\Http\Controllers\Admin\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class VendorApprovedProductController extends Controller
{
    public function index()
    {
        $products = Product::where('vendor_product_status', 'approved')
            ->with('vendor')
            ->latest()
            ->paginate(10);

        return view('admin.vendor.approved-products.index', compact('products'));
    }
}
