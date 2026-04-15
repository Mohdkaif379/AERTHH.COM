<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscrberController extends Controller
{
    public function subscribe(Request $request)
    {
        // Validation
        $request->validate([
            'email' => 'required|email|unique:subscribers,email'
        ]);

        // Save
        $subscriber = Subscriber::create([
            'email' => $request->email
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Subscribed successfully',
            'data' => $subscriber
        ], 200);
    }
}
