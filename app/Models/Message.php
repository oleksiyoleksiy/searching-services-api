<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = [
        'content',
        'user_id',
        'chat_id'
    ];

    public function getIsOwnerAttribute()
    {
        return $this->user_id === auth()->id();
    }
}
