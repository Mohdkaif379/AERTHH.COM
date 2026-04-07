<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::latest()->paginate(15);

        $vendors->getCollection()->transform(function ($vendor) {
            return $this->withImageUrls($vendor);
        });

        return response()->json($vendors);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:vendors,email'],
            'phone' => ['required', 'string', 'max:20', 'unique:vendors,phone'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'zip' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:255'],
            'status' => ['sometimes', 'boolean'],
            'image' => ['nullable'],
            'aadhar_no' => ['required', 'string', 'max:50'],
            'aadhar_image' => ['required'],
            'pan_no' => ['required', 'string', 'max:50'],
            'pan_image' => ['required'],
            'gst_no' => ['required', 'string', 'max:50'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('vendors/images', 'public');
        }
        if ($request->hasFile('aadhar_image')) {
            $data['aadhar_image'] = $request->file('aadhar_image')->store('vendors/aadhar', 'public');
        }
        if ($request->hasFile('pan_image')) {
            $data['pan_image'] = $request->file('pan_image')->store('vendors/pan', 'public');
        }

        $data['status'] = $data['status'] ?? true;
        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'vendor';

        $vendor = Vendor::create($data);

        return response()->json($this->withImageUrls($vendor), 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $vendor = Vendor::where('email', $request->email)->first();

        if (!$vendor || !Hash::check($request->password, $vendor->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid email or password.',
            ], 401);
        }

        if (!$vendor->status) {
            return response()->json([
                'status' => false,
                'message' => 'Your account is blocked. Please contact support.',
            ], 403);
        }

        // Generate token using Sanctum
        $token = $vendor->createToken('vendor_auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Vendor logged in successfully.',
            'token' => $token,
            'vendor' => $this->withImageUrls($vendor),
        ]);
    }


    public function show(Vendor $vendor)
    {
        return response()->json($this->withImageUrls($vendor));
    }

    public function update(Request $request, Vendor $vendor)
    {
        $data = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'max:255', Rule::unique('vendors', 'email')->ignore($vendor->id)],
            'phone' => ['sometimes', 'string', 'max:20', Rule::unique('vendors', 'phone')->ignore($vendor->id)],
            'address' => ['sometimes', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'zip' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:255'],
            'status' => ['sometimes', 'boolean'],
            'image' => ['nullable'],
            'aadhar_no' => ['sometimes', 'string', 'max:50'],
            'aadhar_image' => ['nullable'],
            'pan_no' => ['sometimes', 'string', 'max:50'],
            'pan_image' => ['nullable'],
            'gst_no' => ['sometimes', 'string', 'max:50'],
            'password' => ['sometimes', 'string', 'min:8', 'confirmed'],
        ]);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        if ($request->hasFile('image')) {
            $this->deleteFileIfExists($vendor->getRawOriginal('image'));
            $data['image'] = $request->file('image')->store('vendors/images', 'public');
        }

        if ($request->hasFile('aadhar_image')) {
            $this->deleteFileIfExists($vendor->getRawOriginal('aadhar_image'));
            $data['aadhar_image'] = $request->file('aadhar_image')->store('vendors/aadhar', 'public');
        }

        if ($request->hasFile('pan_image')) {
            $this->deleteFileIfExists($vendor->getRawOriginal('pan_image'));
            $data['pan_image'] = $request->file('pan_image')->store('vendors/pan', 'public');
        }

        $vendor->fill($data);
        $vendor->save();

        return response()->json($this->withImageUrls($vendor));
    }

    public function destroy(Vendor $vendor)
    {
        $this->deleteFileIfExists($vendor->getRawOriginal('image'));
        $this->deleteFileIfExists($vendor->getRawOriginal('aadhar_image'));
        $this->deleteFileIfExists($vendor->getRawOriginal('pan_image'));

        $vendor->delete();

        return response()->json(['message' => 'Vendor deleted successfully.']);
    }

    public function updateStatus(Request $request, Vendor $vendor)
    {
        $data = $request->validate([
            'status' => ['required', 'boolean'],
        ]);

        $vendor->status = $data['status'];
        $vendor->save();

        $label = $vendor->status ? 'activated' : 'blocked';

        return response()->json([
            'message' => "Vendor {$label} successfully.",
            'vendor' => $this->withImageUrls($vendor),
        ]);
    }

    private function withImageUrls(Vendor $vendor): Vendor
    {
        foreach (['image', 'aadhar_image', 'pan_image'] as $field) {
            if ($vendor->getRawOriginal($field)) {
                $vendor->setAttribute(
                    $field,
                    Storage::disk('public')->url($vendor->getRawOriginal($field))
                );
            }
        }

        return $vendor;
    }

    private function deleteFileIfExists(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
