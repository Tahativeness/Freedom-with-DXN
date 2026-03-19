<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'subject', 'message', 'type', 'is_read'];

    protected $casts = ['is_read' => 'boolean'];

    public function toArray()
    {
        $arr = parent::toArray();
        $arr['_id'] = $this->id;
        return $arr;
    }
}
