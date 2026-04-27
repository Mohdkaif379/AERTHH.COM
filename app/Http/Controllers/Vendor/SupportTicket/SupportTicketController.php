<?php

namespace App\Http\Controllers\Vendor\SupportTicket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupportTicketController extends Controller
{
    public function index(Request $request)
    {
        if (!session()->has('vendor')) {
            return redirect()->route('vendor.login')->with('error', 'Please login first');
        }
        $vendorId = session('vendor')['id'];
        
        $query = \App\Models\Ticket::where('vendor_id', $vendorId);
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority') && $request->priority !== 'all') {
            $query->where('priority', $request->priority);
        }

        $tickets = $query->orderBy('created_at', 'desc')->paginate(10)->appends($request->all());
        
        return view('vendor.support_ticket.index', compact('tickets'));
    }

    public function store(Request $request)
    {
        if (!session()->has('vendor')) {
            return response()->json(['message' => 'Please login first'], 401);
        }

        $request->validate([
            'subject' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high,urgent',
            'message' => 'required|string',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
        ]);

        $vendorId = session('vendor')['id'];
        
        $attachmentPaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('support_tickets', 'public');
                $attachmentPaths[] = $path;
            }
        }

        $ticket = new \App\Models\Ticket();
        $ticket->vendor_id = $vendorId;
        $ticket->subject = $request->subject;
        $ticket->priority = $request->priority == 'urgent' ? 'high' : $request->priority;
        $ticket->message = $request->message;
        $ticket->status = 'open';
        $ticket->attachment = empty($attachmentPaths) ? null : json_encode($attachmentPaths);
        $ticket->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Ticket created successfully!',
            'ticket' => $ticket
        ]);
    }
}
