<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatSupport;
use Illuminate\Http\Request;

class ChatSupportController extends Controller
{
    public function index()
    {
        return view('admin.chat.index');
    }

    public function get_all_chat()
    {
        $completedChats = ChatSupport::with(['customer', 'support'])
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('customer_id')
            ->map(function ($messages) {
                $messages = $messages->sortBy('created_at')->values();
                $customer = $messages->first()->customer;
                $lastMessage = $messages->last();
                $supportName = optional($lastMessage->support)->name ?? 'Support Team';

                return [
                    'customer_id'    => $customer?->id,
                    'customer'       => $customer,
                    'messages'       => $messages,
                    'last_message'   => $lastMessage->message,
                    'last_time'      => $lastMessage->created_at,
                    'completed_at'   => $messages->max('updated_at'),
                    'total_messages' => $messages->count(),
                    'support_name'   => $supportName,
                ];
            })
            ->sortByDesc('completed_at')
            ->values();

        return view('admin.chat.all_chat_history', compact('completedChats'));
    }
    
}
