<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['product_id', 'user_id', 'name', 'rating', 'comment'];

    protected $casts = ['rating' => 'integer'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function toArray()
    {
        $arr = parent::toArray();
        $arr['_id'] = $this->id;
        return $arr;
    }
}
