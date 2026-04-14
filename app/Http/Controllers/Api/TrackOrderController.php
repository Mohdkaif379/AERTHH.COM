<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TrackOrderController extends Controller
{
    public function trackOrder(Request $request)
    {
        $orderId = $request->input('order_id');

        // Simulate tracking data for demonstration purposes
        $trackingData = [
            'order_id' => $orderId,
        ];

        return response()->json($trackingData);
    }
}
