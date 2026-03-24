<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function dashboard()
{
    if (!session()->has('admin_id')) {
        return redirect()->route('admin.login')
                         ->with('error', 'Please login first');
    }

    $stats = [
        'vendors' => Vendor::count(),
        'customers' => Customer::count(),
        'products' => Product::count(),
    ];

    return view('admin.dashboard', compact('stats'));
}
}
