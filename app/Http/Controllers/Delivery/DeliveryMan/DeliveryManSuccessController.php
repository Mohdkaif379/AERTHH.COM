<?php

namespace App\Http\Controllers\Delivery\DeliveryMan;

use App\Http\Controllers\Controller;
use App\Models\DeliveryMan;
use Illuminate\Http\Request;

class DeliveryManSuccessController extends Controller
{
    public function index(Request $request)
    {
        $latestDeliveryMan = DeliveryMan::latest('id')->first();
        
        return view('delivery.delivery_man.delivery_man_success', compact('latestDeliveryMan'));
    }
}
