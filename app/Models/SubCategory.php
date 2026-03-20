<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Category;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_id', 'priority'];

    public function category()
    {
        return $this->belongsTo(Category::class);
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