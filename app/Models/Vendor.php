<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip',
        'country',
        'status',
        'image',
        'aadhar_no',
        'aadhar_image',
        'pan_no',
        'pan_image',
        'gst_no',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function getImageAttribute($value): ?string
    {
        return $this->formatImagePath($value);
    }

    public function getAadharImageAttribute($value): ?string
    {
        return $this->formatImagePath($value);
    }

    public function getPanImageAttribute($value): ?string
    {
        return $this->formatImagePath($value);
    }

    private function formatImagePath($value): ?string
    {
        if (!$value) {
            return null;
        }

        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }

        // Return raw storage path (storage/app/public/...)
        return 'storage/app/public/' . ltrim($value, '/');
    }
}
