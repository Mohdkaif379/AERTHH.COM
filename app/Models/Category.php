<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\SubCategory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'status',
        'priority',
    ];

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function subSubCategories()
    {
        return $this->hasMany(SubSubCategory::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}