<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price', 'category', 'image', 'images',
        'in_stock', 'stock_count', 'sku', 'benefits', 'ingredients', 'usage',
        'featured', 'dxn_id', 'source_url', 'dxn_category', 'rating',
    ];

    protected $casts = [
        'images'    => 'array',
        'benefits'  => 'array',
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
