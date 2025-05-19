<?php

use App\Models\Chat;
use Illuminate\Support\Facades\Broadcast;

Broadcast::presence('chat.{chat}', function ($user, Chat $chat) {
    return true;
});
