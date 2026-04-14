<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatSupport extends Model
{
    protected $fillable = [
        'customer_id',
        'support_id',
        'message',
        'sender_type',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

   
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function support()
    {
        return $this->belongsTo(Admin::class, 'support_id');
    }

    // Scope: Sirf unread messages
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    // Scope: Customer ke saare messages
    public function scopeForCustomer($query, $customerId)
    {
        return $query->where('customer_id', $customerId);
    }
}
