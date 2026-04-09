<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BestSellerController extends Controller
{
    public function index(Request $request)
    {
        $limit = (int) $request->input('limit', 10);
        $limit = $limit > 0 ? min($limit, 50) : 10;

        $vendorSummary = Order::select(
            'vendor_id',
            DB::raw('SUM(quantity) as total_sold'),
            DB::raw('COUNT(*) as total_orders')
        )
            ->whereNotNull('vendor_id')
            ->groupBy('vendor_id');

        $vendors = Vendor::query()
            ->joinSub($vendorSummary, 'vendor_summary', function ($join) {
                $join->on('vendors.id', '=', 'vendor_summary.vendor_id');
            })
            ->select('vendors.*')
            ->where('vendors.status', 1)
            ->orderByDesc('vendor_summary.total_sold')
            ->orderByDesc('vendor_summary.total_orders')
            ->limit($limit)
            ->get()
            ->map(function ($vendor) {
                foreach (['image', 'aadhar_image', 'pan_image'] as $field) {
                    $rawValue = $vendor->getRawOriginal($field);

                    if ($rawValue && !str_starts_with($rawValue, 'http')) {
                        $vendor->setAttribute($field, Storage::disk('public')->url($rawValue));
                    }
                }

                return $vendor;
            });

        return response()->json([
            'status' => true,
            'message' => 'Best seller vendors fetched successfully',
            'data' => $vendors,
        ]);
    }
}
