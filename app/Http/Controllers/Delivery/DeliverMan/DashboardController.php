<?php

namespace App\Http\Controllers\Delivery\DeliverMan;

use App\Http\Controllers\Controller;
use App\Models\DeliveryMan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // ✅ session check
        if (!session()->has('delivery_man')) {
            return redirect()->route('delivery.login')
                ->with('error', 'Please login first');
        }

        $deliveryMan = session('delivery_man');

        $totalOrders = 156; // TODO: real relation
        $todayEarnings = 1280; // TODO: calculate real
        $rating = 4.98;
        $completionRate = 98.5;

        return view('delivery.dashboard.dashboard', compact(
            'deliveryMan',
            'totalOrders',
            'todayEarnings',
            'rating',
            'completionRate'
        ));
    }
}
