<?php

namespace App\Http\Controllers\Vendor\AccountSetting;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AccountSettingController extends Controller
{
    public function index(Request $request)
    {
        if (! session()->has('vendor')) {
            return redirect()->route('vendor.login')
                ->with('error', 'Please login first');
        }

        $vendor = Vendor::find(session('vendor')['id']);

        return view('vendor.account-setting.index', compact('vendor'));
    }

    public function edit(Request $request)
    {
        if (! session()->has('vendor')) {
            return redirect()->route('vendor.login')->with('error', 'Please login first');
        }

        $vendor = Vendor::find(session('vendor')['id']);

        return view('vendor.account-setting.edit', compact('vendor'));
    }

    public function update(Request $request)
    {
        if (! session()->has('vendor')) {
            return redirect()->route('vendor.login')->with('error', 'Please login first');
        }

        $vendor = Vendor::find(session('vendor')['id']);

        if (! $vendor) {
            return redirect()->route('vendor.login')->with('error', 'Vendor account not found');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('vendors', 'email')->ignore($vendor->id)],
            'phone' => ['required', 'string', 'max:20', Rule::unique('vendors', 'phone')->ignore($vendor->id)],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'zip' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:255'],
            'gst_no' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            if ($vendor->getRawOriginal('image')) {
                Storage::disk('public')->delete($vendor->getRawOriginal('image'));
            }

            $validated['image'] = $request->file('image')->store('vendors/profile', 'public');
        }

        $vendor->update($validated);

        session([
            'vendor' => $vendor->fresh()->toArray(),
        ]);

        return redirect()
            ->route('vendor.account-setting.index')
            ->with('success', 'Profile updated successfully.');
    }
}
