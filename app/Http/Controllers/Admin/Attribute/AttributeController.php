<?php

namespace App\Http\Controllers\Admin\Attribute;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attribute;

class AttributeController extends Controller
{
    // 🔹 List Page
    public function index()
    {
        $attributes = Attribute::latest()->get();
        return view('admin.attributes.index', compact('attributes'));
    }

    // 🔹 Create Page
    public function create()
    {
        return view('admin.attributes.create');
    }

    // 🔹 Store Data
    public function store(Request $request)
    {
        $request->validate([
            'attribute_name' => 'required|string|max:255|unique:attributes,attribute_name'
        ]);

        Attribute::create($request->all());

        return redirect()->route('attribute.index')->with('success', 'Attribute created successfully');
    }

    // 🔹 Edit Page
    public function edit($id)
    {
        $attribute = Attribute::findOrFail($id);
        return view('admin.attributes.edit', compact('attribute'));
    }

    // 🔹 Update Data
    public function update(Request $request, $id)
    {
        $attribute = Attribute::findOrFail($id);

        $request->validate([
            'attribute_name' => 'required|string|max:255|unique:attributes,attribute_name,' . $id
        ]);

        $attribute->update($request->all());

        return redirect()->route('attribute.index')->with('success', 'Attribute updated successfully');
    }

    // 🔹 Delete
    public function destroy($id)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->delete();

        return redirect()->route('attribute.index')->with('success', 'Attribute deleted successfully');
    }
}