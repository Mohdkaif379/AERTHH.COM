<?php

namespace App\Http\Controllers\Vendor\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
 public function vendor_dashboard(Request $request)
{
    // check session
    if (!session()->has('vendor')) {
        return redirect()->route('vendor.login')
            ->with('error', 'Please login first');
    }
    $vendor = session('vendor');

    return view('vendor.dashboard.dashboard', compact('vendor'));
}
}
