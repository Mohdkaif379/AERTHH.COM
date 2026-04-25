<?php

namespace App\Http\Controllers\Vendor\PasswordManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordManagerController extends Controller
{
    public function index()
    {
        return view('vendor.password_manager.index');
    }

   public function updatePassword(Request $request)
{
    // check session
    if (!session()->has('vendor')) {
        return redirect()->route('vendor.login')->with('error', 'Please login first');
    }

    // Get logged in vendor
    $vendor = \App\Models\Vendor::find(session('vendor')['id']);
    if (!$vendor) {
        return redirect()->route('vendor.login')->with('error', 'Vendor not found');
    }

    // Check current password
    if (!Hash::check($request->current_password, $vendor->password)) {
        return back()->with('error', 'Current password is incorrect');
    }

    // Hash new password
    $newPasswordHash = Hash::make($request->new_password);

    // Update password
    \Illuminate\Support\Facades\DB::table('vendors')
        ->where('id', $vendor->id)
        ->update([
            'password' => $newPasswordHash,
            'updated_at' => now()
        ]);

    // Update session
    $sessionVendor = session('vendor');
    $sessionVendor['password'] = $newPasswordHash;
    session(['vendor' => $sessionVendor]);

    return back()->with('success', 'Password changed successfully!');
}
}
