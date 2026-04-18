<?php

namespace App\Http\Controllers\Vendor\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function vendor_dashboard(Request $request)
    {
        return view('vendor.dashboard.dashboard');
    }
}
