<?php

namespace App\Http\Controllers\Vendor\AccountSetting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountSettingController extends Controller
{
    public function index(Request $request)
    {
        if (! session()->has('vendor')) {
            return redirect()->route('vendor.login')
                ->with('error', 'Please login first');
        }

        $vendor = \App\Models\Vendor::find(session('vendor')['id']);

        return view('vendor.account-setting.index', compact('vendor'));
    }
}
