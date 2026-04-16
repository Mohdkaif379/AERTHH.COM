<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index()
    {
        $subscribe = Subscriber::all();
        return view('admin.subscribers.index', compact('subscribe'));
    }

    public function destroy($id)
    {
        $subscribe = Subscriber::findOrFail($id);
        $subscribe->delete();
        return redirect()->back()->with('success', 'Subscriber deleted successfully.');
    }
}
