<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'category_id',
        'name',
        'title',
        'slug',
        'quantity',
        'description',
        'price',
        'in_stock',
        'published',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function basketItems()
    {
        return $this->hasMany(Basket::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}

