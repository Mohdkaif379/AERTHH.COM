<?php

namespace App\Http\Controllers\Admin\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::latest()->paginate(20);
        return view('admin.vendor.index', compact('vendors'));
    }

    /**
     * Display a single vendor.
     */
    public function show(Vendor $vendor)
    {
        return view('admin.vendor.show', compact('vendor'));
    }

    /**
     * Toggle vendor status (active/inactive).
     */
    public function status(Vendor $vendor)
    {
        $vendor->status = !$vendor->status;
        $vendor->save();

        return redirect()->back()->with('success', 'Vendor status updated successfully.');
    }

    /**
     * Delete a vendor and related images.
     */
    public function destroy(Vendor $vendor)
    {
        foreach (['image', 'aadhar_image', 'pan_image'] as $field) {
            $path = $vendor->getRawOriginal($field);
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        $vendor->delete();

        return redirect()->route('vendors.index')->with('success', 'Vendor deleted successfully.');
    }
}
