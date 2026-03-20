<?php

namespace App\Http\Controllers\Admin\Brand;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    // ✅ List
    public function index()
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login')
                             ->with('error', 'Please login first');
        }

        $brands = Brand::latest()->get();
        return view('admin.brand.index', compact('brands'));
    }

    // ✅ Create Form
    public function create()
    {
        return view('admin.brand.create');
    }

    // ✅ Store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:brands,name',
            'alt_text' => 'nullable',
            'image' => 'required|image'
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('brand'), $imageName);
        }

        Brand::create([
            'name' => $request->name,
            'alt_text' => $request->alt_text,
            'image' => $imageName,
            'status' => 1
        ]);

        return redirect()->route('brand.index')
                         ->with('success', 'Brand created successfully');
    }

    // ✅ Edit
    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brand.edit', compact('brand'));
    }

    // ✅ Update
    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:brands,name,' . $id,
            'alt_text' => 'nullable',
            'image' => 'nullable|image'
        ]);

        // image update
        if ($request->hasFile('image')) {

            // old image delete
            if ($brand->image && file_exists(public_path('brand/'.$brand->image))) {
                unlink(public_path('brand/'.$brand->image));
            }

            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('brand'), $imageName);

            $brand->image = $imageName;
        }

        $brand->update([
            'name' => $request->name,
            'alt_text' => $request->alt_text,
        ]);

        return redirect()->route('brand.index')
                         ->with('success', 'Brand updated successfully');
    }

    // ✅ Delete
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        // delete image
        if ($brand->image && file_exists(public_path('brand/'.$brand->image))) {
            unlink(public_path('brand/'.$brand->image));
        }

        $brand->delete();

        return back()->with('success', 'Brand deleted successfully');
    }

    // ✅ Status Toggle
    public function status($id)
    {
        $brand = Brand::findOrFail($id);

        $brand->status = !$brand->status;
        $brand->save();

        return back()->with('success', 'Status updated');
    }
}