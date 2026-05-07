<?php

namespace App\Http\Controllers\Admin\DeliveryMan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\DeliveryMan;

class DeliveryManController extends Controller
{
    public function index()
    {
        $delivery_men = DeliveryMan::latest()->get();
        return view('admin.delivery_man.index', compact('delivery_men'));
    }

    public function updateStatus($id, $status)
    {
        $delivery_man = DeliveryMan::findOrFail($id);
        $delivery_man->status = $status;
        $delivery_man->save();

        return redirect()->back()->with('success', 'Delivery man status updated successfully.');
    }

    public function show($id)
    {
        $delivery_man = DeliveryMan::findOrFail($id);
        return view('admin.delivery_man.show', compact('delivery_man'));
    }

    public function destroy($id)
    {
        $delivery_man = DeliveryMan::findOrFail($id);
        $delivery_man->delete();
        return redirect()->route('admin.delivery-man.index')->with('success', 'Delivery man deleted successfully.');
    }
}
