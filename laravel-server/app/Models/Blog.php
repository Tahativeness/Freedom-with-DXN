<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'title', 'slug', 'excerpt', 'content', 'content_ar', 'content_type', 'image', 'sub_image',
        'category', 'tags', 'published', 'views',
    ];

    protected $casts = [
        'tags'      => 'array',
        'published' => 'boolean',
        'views'     => 'integer',
    ];

    public function toArray()
    {
        $arr = parent::toArray();
        $arr['_id'] = $this->id;
        return $arr;
    }
}
