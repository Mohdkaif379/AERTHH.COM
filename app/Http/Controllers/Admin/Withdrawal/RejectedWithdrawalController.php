<?php

namespace App\Http\Controllers\Admin\Withdrawal;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class RejectedWithdrawalController extends Controller
{
    public function index()
    {
        $rejectedWithdrawals = Withdrawal::with('vendor')
            ->where('status', 'rejected')
            ->latest()
            ->get();
            
        return view('admin.withdrawal.rejected', compact('rejectedWithdrawals'));
    }
}
