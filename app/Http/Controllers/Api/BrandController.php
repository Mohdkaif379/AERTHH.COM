<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::where('status', 1)
            ->orderBy('name', 'asc')
            ->get()
            ->map(function ($brand) {

                // Full URL with public/brand
                $brand->image = url('public/brand/' . $brand->image);

                return $brand;
            });

        return response()->json($brands);
    }
}