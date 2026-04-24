<?php

namespace App\Http\Controllers\Vendor\VendorSignup;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VendorSignupController extends Controller
{
    public function signup()
    {
        return view('vendor.signup');
    }

    public function signupSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:vendors,email'],
            'phone' => ['required', 'string', 'max:20', 'unique:vendors,phone'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'zip' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:255'],
            'aadhar_no' => ['required', 'string', 'max:255'],
            'aadhar_image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'pan_no' => ['required', 'string', 'max:255'],
            'pan_image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'gst_no' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $vendorImage = null;
        if ($request->hasFile('image')) {
            $vendorImage = $request->file('image')->store('vendors/profile', 'public');
        }

        $aadharImage = $request->file('aadhar_image')->store('vendors/aadhar', 'public');
        $panImage = $request->file('pan_image')->store('vendors/pan', 'public');

        Vendor::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'city' => $validated['city'] ?? null,
            'state' => $validated['state'] ?? null,
            'zip' => $validated['zip'] ?? null,
            'country' => $validated['country'] ?? null,
            'image' => $vendorImage,
            'aadhar_no' => $validated['aadhar_no'],
            'aadhar_image' => $aadharImage,
            'pan_no' => $validated['pan_no'],
            'pan_image' => $panImage,
            'gst_no' => $validated['gst_no'],
            'password' => Hash::make($validated['password']),
            'status' => false,
            'role' => 'vendor',
        ]);

        return redirect()
            ->route('vendor.signup.thanks')
            ->with('success', 'Vendor account created successfully.');
    }
}
