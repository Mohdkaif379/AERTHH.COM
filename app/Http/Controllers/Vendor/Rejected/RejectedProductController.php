<?php

namespace App\Http\Controllers\Vendor\Rejected;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class RejectedProductController extends Controller
{
    public function index()
    {
        $vendor = session('vendor');
        if (!$vendor) {
            return redirect()->route('vendor.login')->with('error', 'Please login first');
        }

        $rejectedProducts = Product::with(['category', 'subCategory', 'brand'])
            ->where('vendor_id', $vendor['id'])
            ->where('vendor_product_status', 'rejected')
            ->latest()
            ->get();

        return view('vendor.rejected_products.index', compact('rejectedProducts'));
    }
}
