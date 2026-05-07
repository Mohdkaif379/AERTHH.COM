<?php

namespace App\Http\Controllers\Delivery\DeliveryLogin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryMan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class DeliveryLoginController extends Controller
{
    public function index()
    {
        return view('delivery.delivery_login.delivery_login');
    }

    public function login(Request $request)
    {
        \Log::info('Delivery login attempt', ['mobile' => $request->mobile]);

        // validation
        $request->validate([
            'mobile' => 'required',
            'password' => 'required'
        ]);

        \Log::info('DeliveryMan validation passed', ['mobile' => $request->mobile]);

        // find delivery man by mobile
        $deliveryMan = DeliveryMan::where('mobile', $request->mobile)->first();
        \Log::info('DeliveryMan found', ['mobile' => $request->mobile, 'status' => $deliveryMan?->status]);

        // check user exists
        if (!$deliveryMan) {
            \Log::warning('DeliveryMan not found', ['mobile' => $request->mobile]);
            return back()->with('error', 'Invalid mobile number');
        }

        // ✅ status check (active / approved)
        if ($deliveryMan->status !== 'active') {
            return back()->with('error', 'Your account is not active. Please contact admin.');
        }

        // check password
        if (!Hash::check($request->password, $deliveryMan->password)) {
            return back()->with('error', 'Invalid password');
        }

        // store session (without password)
        session([
            'delivery_man' => $deliveryMan->makeHidden(['password'])
        ]);

        return redirect()->route('delivery.dashboard')
            ->with('success', 'Login successful');
    }


    public function logout()
    {

        session()->flush();

        return redirect()->route('delivery.login')
            ->with('success', 'Logged out successfully');
    }
}
