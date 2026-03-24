<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->paginate(20);
        return view('admin.customer.index', compact('customers'));
    }

    /**
     * Display a single customer.
     */
    public function show(Customer $customer)
    {
        return view('admin.customer.show', compact('customer'));
    }

    /**
     * Toggle customer status (active/inactive).
     */
    public function status(Customer $customer)
    {
        $customer->status = !$customer->status;
        $customer->save();

        return redirect()->back()->with('success', 'Customer status updated successfully.');
    }

    /**
     * Delete a customer and related assets.
     */
    public function destroy(Customer $customer)
    {
        $path = $customer->getRawOriginal('profile_image');
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
