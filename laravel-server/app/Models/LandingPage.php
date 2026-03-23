<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    protected $fillable = [
        'title', 'slug', 'product_id', 'hero_image', 'hero_title', 'hero_subtitle',
        'hero_bg_color', 'cta_text', 'cta_link', 'features', 'benefits', 'gallery',
        'custom_css', 'custom_html', 'published',
    ];

    protected $casts = [
        'features'  => 'array',
        'benefits'  => 'array',
        'gallery'   => 'array',
        'published'  => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
