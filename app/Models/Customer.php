<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'terms_and_conditions',
        'status',
        'referral_code',
        'gender',
        'profile_image',
        'dob',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'terms_and_conditions' => 'boolean',
        'status' => 'boolean',
        'dob' => 'date',
    ];

    // Always return full URL for profile_image when serialized
    public function getProfileImageAttribute($value): ?string
    {
        if (!$value) {
            return null;
        }

        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }

        return Storage::disk('public')->url($value);
    }
}
