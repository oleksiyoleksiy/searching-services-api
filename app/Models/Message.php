<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }
}
