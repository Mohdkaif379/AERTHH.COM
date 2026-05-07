<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class DeliveryMan extends Model
{
    use Notifiable;
      protected $fillable = [
        'full_name',
        'mobile',
        'email',
        'password',
        'date_of_birth',
        'gender',
        'profile_photo',
        'address_line',
        'city',
        'state',
        'pincode',
        'aadhaar_number',
        'aadhaar_image',
        'vehicle_type',
        'vehicle_number',
        'driving_license_number',
        'rc_upload',
        'dl_upload',
        'status',
        'rejection_reason',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function orders()
    {
        return $this->hasMany(OrderAssign::class);
    }
}
