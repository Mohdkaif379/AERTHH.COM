<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Return active categories with optional nested children.
     */
    public function index(Request $request)
    {
        $withChildren = $request->boolean('with_children', false);

        $query = Category::query()
            ->where('status', 1)
            ->orderBy('priority', 'asc')
            ->orderBy('id', 'desc');

        if ($withChildren) {
            $query->with('subCategories.subSubCategories');
        }

        $categories = $query->get()->map(function ($category) {
            if ($category->image && !str_starts_with($category->image, 'http')) {
                $category->image = Storage::disk('public')->url($category->image);
            }
            return $category;
        });

        return response()->json($categories);
    }
}
