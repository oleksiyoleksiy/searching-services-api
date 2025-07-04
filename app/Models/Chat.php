<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chat extends Model
{
    protected $table = 'chats';

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function getInterlocutorAttribute(): ?User
    {
        return $this->users()->whereNot('users.id', auth()->id())->first();
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function isUserMember(): bool
    {
        return $this->users()->where('users.id', auth()->id())->exists();
    }
}
