<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'customer_id',
        'type',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address_line',
        'city',
        'state',
        'zip_code',
        'country',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
