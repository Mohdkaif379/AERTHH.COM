<?php

namespace App\Http\Controllers\Admin\Withdrawal;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class ApprovedWithdrawalController extends Controller
{
    public function index()
    {
        $approvedWithdrawals = Withdrawal::with('vendor')
            ->where('status', 'approved')
            ->latest()
            ->get();
            
        return view('admin.withdrawal.approved', compact('approvedWithdrawals'));
    }
}
