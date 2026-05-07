<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderAssign extends Model
{
    protected $fillable = [
        'order_id',
        'delivery_man_id',
        'assigned_at',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function deliveryMan()
    {
        return $this->belongsTo(DeliveryMan::class);
    }
}
