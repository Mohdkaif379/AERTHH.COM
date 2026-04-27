<?php

namespace App\Http\Controllers\Vendor\MyProductReviews;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class MyProductReviewController extends Controller
{
    public function index(Request $request)
    {
        if (!session()->has('vendor')) {
            return redirect()->route('vendor.login')->with('error', 'Please login first');
        }

        $vendorId = session('vendor')['id'];

        $reviews = Review::with(['customer', 'product'])
            ->whereHas('product', function ($query) use ($vendorId) {
                $query->where('vendor_id', $vendorId);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('vendor.my_product_reviews.index', compact('reviews'));
    }
}
