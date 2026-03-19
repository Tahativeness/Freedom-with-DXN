<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'total_amount', 'shipping_address', 'payment_method',
        'payment_status', 'status', 'notes', 'referred_by',
    ];

    protected $casts = [
        'shipping_address' => 'array',
        'total_amount'     => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    public function toArray()
    {
        $arr = parent::toArray();
        $arr['_id'] = $this->id;
        return $arr;
    }
}
