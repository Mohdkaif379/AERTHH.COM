<?php

namespace App\Http\Controllers\Vendor\Withdrawal;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function index()
    {
        $vendor = session('vendor');
        if (!$vendor) {
            return redirect()->route('vendor.login')->with('error', 'Please login first');
        }

        $availableBalance = $this->getAvailableBalance();
        
        $totalEarnings = Order::where('vendor_id', $vendor['id'])
            ->where('status', 'delivered')
            ->get()
            ->sum(function (Order $order) {
                return (float) $order->total_price + (float) ($order->shipping_cost ?? 0);
            });

        $pendingPayout = Withdrawal::where('vendor_id', $vendor['id'])
            ->where('status', 'pending')
            ->sum('amount');

        return view('vendor.withdrawal.index', compact('availableBalance', 'totalEarnings', 'pendingPayout'));
    }

    public function store(Request $request)
    {
        $vendor = session('vendor');
        if (!$vendor) {
            return redirect()->route('vendor.login')->with('error', 'Please login first');
        }

        $balance = $this->getAvailableBalance();

        $request->validate([
            'payment_type' => 'required|in:bank_transfer,upi',
            'amount' => 'required|numeric|min:1|max:' . $balance,
            'account_holder_name' => 'required_if:payment_type,bank_transfer',
            'account_number' => 'required_if:payment_type,bank_transfer',
            'bank_name' => 'required_if:payment_type,bank_transfer',
            'ifsc_code' => 'required_if:payment_type,bank_transfer',
            'upi_id' => 'required_if:payment_type,upi',
        ], [
            'amount.max' => 'Insufficient balance for this withdrawal.',
        ]);

        Withdrawal::create([
            'vendor_id' => $vendor['id'],
            'payment_type' => $request->payment_type,
            'account_holder_name' => $request->account_holder_name,
            'account_number' => $request->account_number,
            'bank_name' => $request->bank_name,
            'ifsc_code' => $request->ifsc_code,
            'upi_id' => $request->upi_id,
            'amount' => $request->amount,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Withdrawal request submitted successfully!');
    }

    private function getAvailableBalance()
    {
        $vendorId = session('vendor.id');
        if (!$vendorId) return 0;

        $totalEarnings = Order::where('vendor_id', $vendorId)
            ->where('status', 'delivered')
            ->get()
            ->sum(function (Order $order) {
                return (float) $order->total_price + (float) ($order->shipping_cost ?? 0);
            });

        $alreadyWithdrawn = Withdrawal::where('vendor_id', $vendorId)
            ->whereIn('status', ['pending', 'approved'])
            ->sum('amount');

        return $totalEarnings - $alreadyWithdrawn;
    }
}
