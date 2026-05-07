<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
     protected $fillable = [
        'name',
        'email',
        'password',
        'profile',
        'phone',
        'status',
    ];  
    
    public function deliveryMen()
    {
        return $this->hasMany(DeliveryMan::class, 'created_by');
    }
}
