<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_name',
        'description',
        'category_id',
        'sub_category_id',
        'sub_sub_category_id',
        'brand_id',
        'vendor_id',
        'vendor_product_status',
        'product_type',
        'image',
        'tags',
        'sku',
        'unit_price',
        'stock_quantity',
        'discount',
        'discount_type',
        'product_unit',
        'status',
        'shipping_cost',
        'tax_amount',
        'attribute_id',
        'attribute_value',
        'additional_image'
    ];

    protected $casts = [
        'tags' => 'array',
        'additional_image' => 'array',
        'status' => 'boolean',
        'unit_price' => 'decimal:2',
        'discount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'tax_amount' => 'decimal:2',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function subSubCategory()
    {
        return $this->belongsTo(SubSubCategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
