<?php

namespace App\Http\Controllers\Vendor\Faq;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        return view('vendor.faq.index');
    }
}
