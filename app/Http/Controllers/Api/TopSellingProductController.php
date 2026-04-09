<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Product;

class TopSellingProductController extends Controller
{
    public function index()
    {
        // Sabse zyada buy hue product IDs ko orders table se fetch karna
        $topProductIds = \Illuminate\Support\Facades\DB::table('orders')
            ->select('product_id', \Illuminate\Support\Facades\DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(15)
            ->pluck('product_id');

        if ($topProductIds->isEmpty()) {
            return response()->json([]);
        }

        // Un IDs ke basis pe full product data fetch karna aur order maintain karna
        $topSellingProducts = Product::whereIn('id', $topProductIds)
            ->get()
            ->sortBy(function ($product) use ($topProductIds) {
                return array_search($product->id, $topProductIds->toArray());
            })
            ->values();

        // Har product me image ka path storage/app/public/ format me set karna jisme domain bhi shamil ho
        $topSellingProducts->transform(function ($product) {
            if ($product->getRawOriginal('image')) {
                // asset() function automatically current domain add kar deta hai
                $product->image = asset('storage/' . ltrim($product->getRawOriginal('image'), '/'));
            }
            return $product;
        });

        return response()->json($topSellingProducts);
    }
}
