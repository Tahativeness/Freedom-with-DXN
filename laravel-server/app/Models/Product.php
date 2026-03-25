<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'name_ar', 'description', 'description_ar', 'price', 'category',
        'image', 'images', 'in_stock', 'stock_count', 'sku',
        'benefits', 'benefits_ar', 'ingredients', 'usage', 'usage_ar',
        'featured', 'dxn_id', 'source_url', 'landing_page', 'dxn_category', 'rating',
    ];

    protected $casts = [
        'images'      => 'array',
        'benefits'    => 'array',
        'benefits_ar' => 'array',
        'price'     => 'float',
        'rating'    => 'float',
        'in_stock'  => 'boolean',
        'featured'  => 'boolean',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function toArray(): array
    {
        $arr = parent::toArray();
        $arr['_id'] = $this->id;
        return $arr;
    }
}
