<?php
namespace App\Http\Controllers\Admin\SubCategory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;

class SubCategoryController extends Controller
{
    // ✅ List
    public function index()
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login')
                             ->with('error', 'Please login first');
        }

        $subcategories = SubCategory::with('category')->latest()->get();

        return view('admin.subcategory.index', compact('subcategories'));
    }

    // ✅ Create Form
    public function create()
    {
        $categories = Category::all();
        return view('admin.subcategory.create', compact('categories'));
    }

    // ✅ Store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'priority' => 'nullable'
        ]);

        SubCategory::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'priority' => $request->priority,
        ]);

        return redirect()->route('subcategory.index')
                         ->with('success', 'SubCategory created');
    }

    // ✅ Edit Form
    public function edit($id)
    {
        $subcategory = SubCategory::findOrFail($id);
        $categories = Category::all();

        return view('admin.subcategory.edit', compact('subcategory', 'categories'));
    }

    // ✅ Update
    public function update(Request $request, $id)
    {
        $subcategory = SubCategory::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'priority' => 'nullable'
        ]);

        $subcategory->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'priority' => $request->priority,
        ]);

        return redirect()->route('subcategory.index')
                         ->with('success', 'SubCategory updated');
    }

    // ✅ Delete
    public function destroy($id)
    {
        $subcategory = SubCategory::findOrFail($id);
        $subcategory->delete();

        return back()->with('success', 'SubCategory deleted');
    }
}
