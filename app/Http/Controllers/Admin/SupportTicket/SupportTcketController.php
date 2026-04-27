<?php

namespace App\Http\Controllers\Admin\SupportTicket;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class SupportTcketController extends Controller
{
    public function index(Request $request)
    {
        $tickets = Ticket::with('vendor')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('subject', 'like', "%{$search}%")
                        ->orWhere('id', 'like', "%{$search}%")
                        ->orWhereHas('vendor', function ($vendorQuery) use ($search) {
                            $vendorQuery->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->when($request->filled('status') && $request->status !== 'all', function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->filled('priority') && $request->priority !== 'all', function ($query) use ($request) {
                $query->where('priority', $request->priority);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.support_ticket.index', compact('tickets'));
    }
}
