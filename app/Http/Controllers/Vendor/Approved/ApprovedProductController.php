<?php

namespace App\Http\Controllers\Vendor\Approved;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ApprovedProductController extends Controller
{
    public function index()
    {
        $vendor = session('vendor');
        if (!$vendor) {
            return redirect()->route('vendor.login')->with('error', 'Please login first');
        }

        $approvedProducts = Product::with(['category', 'subCategory', 'brand'])
            ->where('vendor_id', $vendor['id'])
            ->where('vendor_product_status', 'approved')
            ->latest()
            ->get();

        return view('vendor.approved_products.index', compact('approvedProducts'));
    }
}
