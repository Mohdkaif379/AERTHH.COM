<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = ['attribute_name'];

      public function products()
    {
        return $this->hasMany(Product::class);
    }
}