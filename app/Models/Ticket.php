<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'vendor_id',
        'subject',
        'message',
        'status',
        'priority',
        'attachment',
        'closed_at'
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
