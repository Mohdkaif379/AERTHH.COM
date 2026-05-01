<?php

namespace App\Http\Controllers\Admin\Withdrawal;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class PendingWithdrawalController extends Controller
{
    public function index()
    {
        $pendingWithdrawals = Withdrawal::with('vendor')
            ->where('status', 'pending')
            ->latest()
            ->get();
            
        return view('admin.withdrawal.pending', compact('pendingWithdrawals'));
    }

    public function approve($id)
    {
        $withdrawal = Withdrawal::findOrFail($id);
        $withdrawal->status = 'approved';
        $withdrawal->save();
        
        return redirect()->back()->with('success', 'Withdrawal request approved successfully.');
    }

    public function reject($id)
    {
        $withdrawal = Withdrawal::findOrFail($id);
        $withdrawal->status = 'rejected';
        $withdrawal->save();
        
        return redirect()->back()->with('success', 'Withdrawal request rejected.');
    }
}
