<?php

namespace App\Http\Controllers\Admin\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
// use App\Models\Vendor;


class VendorPendingProductController extends Controller
{
    public function index() 
    {
        $products = Product::where('vendor_product_status', 'pending')
                    ->with('vendor')
                    ->latest()
                    ->paginate(10);
                    
        return view('admin.vendor.products-pending.index', compact('products'));
    }
    public function updateStatus($id, $status)
    {
        $product = Product::findOrFail($id);
        
        if (in_array($status, ['approved', 'rejected'])) {
            $product->vendor_product_status = $status;
            $product->save();
            $message = 'Product ' . $status . ' successfully.';
        } else {
            return redirect()->back()->with('error', 'Invalid status.');
        }

        return redirect()->back()->with('success', $message);
    }
}
