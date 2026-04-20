<?php

namespace App\Http\Controllers\Vendor\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login()
    {
        return view('vendor.login');
    }

    public function loginSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $vendor = Vendor::where('email', $request->email)->first();

        if (!$vendor || !Hash::check($request->password, $vendor->password)) {
            return back()->with('error', 'Invalid email or password');
        }

        if (!$vendor->status) {
            return back()->with('error', 'Account inactive');
        }

        // ✅ Full vendor data session me
        session([
            'vendor' => $vendor->toArray()
        ]);

        return redirect()->route('vendor.dashboard');
    }

    public function logout()
    {
       session()->forget('vendor');
        return redirect()->route('vendor.login');
    }
}
