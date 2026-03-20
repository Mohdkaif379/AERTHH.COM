<?php
namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // ✅ List
    public function index()
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('admin.login')
                             ->with('error', 'Please login first');
        }

        $categories = Category::latest()->get();
        return view('admin.category.index', compact('categories'));
    }

    // ✅ Create Form
    public function create()
    {
        return view('admin.category.create');
    }

    // ✅ Store
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image',
            'priority' => 'nullable'
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('category'), $imageName);
        }

        Category::create([
            'name' => $request->name,
            'image' => $imageName,
            'status' => 1,
            'priority' => $request->priority,
        ]);

        return redirect()->route('category.index')
                         ->with('success', 'Category created');
    }

    // ✅ Edit Form
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    // ✅ Update
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image',
            'priority' => 'nullable'
        ]);

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('category'), $imageName);
            $category->image = $imageName;
        }

        $category->update([
            'name' => $request->name,
            'priority' => $request->priority,
        ]);

        return redirect()->route('category.index')
                         ->with('success', 'Category updated');
    }

    // ✅ Delete
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return back()->with('success', 'Category deleted');
    }

    // ✅ Status Toggle
    public function status($id)
    {
        $category = Category::findOrFail($id);
        $category->status = !$category->status;
        $category->save();

        return back()->with('success', 'Status updated');
    }
}