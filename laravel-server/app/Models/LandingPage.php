<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    protected $fillable = [
        'title', 'slug', 'product_id', 'hero_image', 'hero_title', 'hero_subtitle',
        'hero_bg_color', 'description', 'description_ar', 'ingredients',
        'usage_directions', 'usage_directions_ar', 'qna',
        'cta_text', 'cta_link', 'features', 'benefits', 'gallery',
        'custom_css', 'custom_html', 'published',
    ];

    protected $casts = [
        'features'   => 'array',
        'benefits'   => 'array',
        'gallery'    => 'array',
        'qna'        => 'array',
        'published'  => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
