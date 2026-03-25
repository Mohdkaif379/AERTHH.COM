<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerLoginController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $customer = Customer::query()
            ->where('email', $data['email'])
            ->first();

        if (!$customer || !Hash::check($data['password'], $customer->password)) {
            return response()->json([
                'message' => 'Invalid login credentials.',
            ], 401);
        }

        if (!$customer->status) {
            return response()->json([
                'message' => 'Your account is blocked. Please contact support.',
            ], 403);
        }

        $token = $customer->createToken('customer-login')->plainTextToken;

        return response()->json([
            'message' => 'Customer login successful.',
            'token' => $token,
            'token_type' => 'Bearer',
            'customer' => $customer,
        ]);
    }
}
