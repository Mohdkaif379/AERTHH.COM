<?php
namespace App\Http\Controllers\Admin\SubSubCategory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubSubCategory;
use App\Models\SubCategory;
use App\Models\Category;

class SubSubCategoryController extends Controller
{
    // ✅ List
    public function index()
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login')
                             ->with('error', 'Please login first');
        }

        $data = SubSubCategory::with(['category', 'subCategory'])->latest()->get();

        return view('admin.subsubcategory.index', compact('data'));
    }

    // ✅ Create Form
    public function create()
    {
        $categories = Category::all();
        $subcategories = SubCategory::all();

        return view('admin.subsubcategory.create', compact('categories', 'subcategories'));
    }

    // ✅ Store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'priority' => 'nullable'
        ]);

        SubSubCategory::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'priority' => $request->priority,
        ]);

        return redirect()->route('subsubcategory.index')
                         ->with('success', 'SubSubCategory created');
    }

    // ✅ Edit
    public function edit($id)
    {
        $item = SubSubCategory::findOrFail($id);
        $categories = Category::all();
        $subcategories = SubCategory::all();

        return view('admin.subsubcategory.edit', compact('item', 'categories', 'subcategories'));
    }

    // ✅ Update
    public function update(Request $request, $id)
    {
        $item = SubSubCategory::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'priority' => 'nullable'
        ]);

        $item->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'priority' => $request->priority,
        ]);

        return redirect()->route('subsubcategory.index')
                         ->with('success', 'Updated successfully');
    }

    // ✅ Delete
    public function destroy($id)
    {
        $item = SubSubCategory::findOrFail($id);
        $item->delete();

        return back()->with('success', 'Deleted successfully');
    }
}