<?php

namespace App\Http\Controllers\Delivery\DeliverySignup;

use App\Http\Controllers\Controller;
use App\Models\DeliveryMan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DeliverySignupController extends Controller
{
    public function index()
    {
        return view('delivery.delivery_signup.delivery_signup');
    }

    public function store(Request $request)
    {
        Log::info('Delivery signup submission received', $request->all());
        
        $request->validate([
            'full_name' => 'required|string|max:255',
            'mobile' => 'required|string|min:10|max:15|unique:delivery_men,mobile',
            'email' => 'required|email|unique:delivery_men,email',
            'password' => 'required|min:6|confirmed',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'address_line' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|string|digits:6',
            'aadhaar_number' => 'nullable|digits:12|unique:delivery_men,aadhaar_number',
            'vehicle_type' => 'required|in:bike,bicycle,scooter,auto',
            'vehicle_number' => 'required|string|unique:delivery_men,vehicle_number',
            'driving_license_number' => 'required|string|unique:delivery_men,driving_license_number',
            'aadhaar_image' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120',
            'rc_upload' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120',
            'dl_upload' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120',
        ]);
        
        Log::info('Validation passed. Processing data:', $request->all());

        $data = $request->only([
            'full_name', 'mobile', 'email', 'date_of_birth', 'gender',
            'address_line', 'city', 'state', 'pincode', 'aadhaar_number',
            'vehicle_type', 'vehicle_number', 'driving_license_number'
        ]);

        // Handle file uploads
        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = $request->file('profile_photo')->store('delivery_docs', 'public');
        }
        if ($request->hasFile('aadhaar_image')) {
            $data['aadhaar_image'] = $request->file('aadhaar_image')->store('delivery_docs', 'public');
        }
        if ($request->hasFile('rc_upload')) {
            $data['rc_upload'] = $request->file('rc_upload')->store('delivery_docs', 'public');
        }
        if ($request->hasFile('dl_upload')) {
            $data['dl_upload'] = $request->file('dl_upload')->store('delivery_docs', 'public');
        }

        $data['password'] = Hash::make($request->password);
        $data['status'] = 'pending';

        DeliveryMan::create($data);

        return redirect()->route('delivery.success')
            ->with('success', 'Delivery partner application submitted successfully! Our team will review it soon.');        
    }
}
