<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Category;
use App\Models\SubCategory;

class SubSubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'sub_category_id',
        'priority'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

     public function products()
    {
        return $this->hasMany(Product::class);
    }
}