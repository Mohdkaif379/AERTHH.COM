<?php

namespace App\Http\Controllers\Vendor\PrivacyPolicy;

use App\Http\Controllers\Controller;

class PrivacyPolicyController extends Controller
{
    public function index()
    {
        return view('vendor.privacy-policy.index');
    }
}
