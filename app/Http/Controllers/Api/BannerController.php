<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Return published banners with absolute image URLs.
     */
    public function index(Request $request)
    {
        $query = Banner::query()->where('is_published', true)->latest();

        if ($request->filled('type')) {
            $query->where('banner_type', $request->get('type'));
        }

        $banners = $query->get()->map(function ($banner) {
            if ($banner->image && !str_starts_with($banner->image, 'http')) {
                $banner->image = Storage::disk('public')->url($banner->image);
            }
            return $banner;
        });

        return response()->json($banners);
    }
}
