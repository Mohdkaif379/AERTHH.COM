<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChatSupport;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatSupportController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $customer = Auth::user();

        $chat = ChatSupport::create([
            'customer_id' => $customer->id,
            'support_id'  => null,
            'message'     => $request->message,
            'sender_type' => 'customer',
            'is_read'     => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Message bheja gaya.',
            'data'    => $chat->load('customer'),
        ], 201);
    }

    public function myHistory(Request $request)
    {
        $customer = Auth::user();

        $chats = ChatSupport::forCustomer($customer->id)
            ->with(['customer', 'support'])
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $chats,
        ]);
    }

    public function allChats(Request $request)
    {
        // Har customer ki latest message aur unread count ke saath (jo complete nahi hui)
        $chats = ChatSupport::with(['customer', 'support'])
            ->where('status', '!=', 'completed')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('customer_id')
            ->map(function ($messages) {
                $latest = $messages->first();
                return [
                    'customer_id'    => $latest->customer_id,
                    'customer'       => $latest->customer,
                    'last_message'   => $latest->message,
                    'last_time'      => $latest->created_at,
                    'unread_count'   => $messages->where('is_read', false)
                                                 ->where('sender_type', 'customer')
                                                 ->count(),
                    'total_messages' => $messages->count(),
                ];
            })
            ->values();

        return response()->json([
            'success' => true,
            'data'    => $chats,
        ]);
    }

    public function customerChat($customerId)
    {
        $chats = ChatSupport::forCustomer($customerId)
            ->where('status', '!=', 'completed')
            ->with(['customer', 'support'])
            ->orderBy('created_at', 'asc')
            ->get();

        if ($chats->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Is customer ki koi chat nahi mili.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $chats,
        ]);
    }

    public function replyMessage(Request $request, $customerId)
    {
        $request->validate([
            'message'    => 'required|string|max:2000',
            'support_id' => 'required|exists:admins,id',
        ]);

        $reply = ChatSupport::create([
            'customer_id' => $customerId,
            'support_id'  => $request->support_id,
            'message'     => $request->message,
            'sender_type' => 'support',
            'is_read'     => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reply bheja gaya.',
            'data'    => $reply->load(['customer', 'support']),
        ], 201);
    }

    public function markAsRead($customerId)
    {
        $updated = ChatSupport::forCustomer($customerId)
            ->where('sender_type', 'customer')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'message' => "{$updated} messages read mark kiye gaye.",
        ]);
    }

    public function customerMarkAsRead(Request $request)
    {
        $customer = Auth::user();

        $updated = ChatSupport::forCustomer($customer->id)
            ->where('sender_type', 'support')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'message' => "{$updated} messages read mark kiye gaye.",
        ]);
    }

    public function destroy($id)
    {
        $chat = ChatSupport::find($id);

        if (!$chat) {
            return response()->json([
                'success' => false,
                'message' => 'Message nahi mila.',
            ], 404);
        }

        $chat->delete();

        return response()->json([
            'success' => true,
            'message' => 'Message delete ho gaya.',
        ]);
    }

    public function completeChat($customerId)
    {
        $updated = ChatSupport::forCustomer($customerId)
            ->where('status', '!=', 'completed')
            ->update(['status' => 'completed']);

        return response()->json([
            'success' => true,
            'message' => 'Chat successfully marked as completed.',
        ]);
    }
}
