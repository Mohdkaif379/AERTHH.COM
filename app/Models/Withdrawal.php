<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{  
    protected $fillable = [
        'vendor_id',
        'payment_type',
        'account_holder_name',
        'account_number',
        'bank_name',
        'ifsc_code',
        'upi_id',
        'amount',
        'status',
    ];

     public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
