<?php

namespace App\Http\Controllers\Vendor\Pending;

use App\Http\Controllers\Controller;
use App\Models\Product;

class PendingProductController extends Controller
{
    public function index()
    {
        $vendor = session('vendor');
        if (!$vendor) {
            return redirect()->route('vendor.login')->with('error', 'Please login first');
        }

        $pendingProducts = Product::with(['category', 'subCategory', 'brand'])
            ->where('vendor_id', $vendor['id'])
            ->where('vendor_product_status', 'pending')
            ->latest()
            ->get();

        return view('vendor.pending_products.index', compact('pendingProducts'));
    }
}
