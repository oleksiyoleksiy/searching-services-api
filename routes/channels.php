<?php

use App\Models\Chat;
use Illuminate\Support\Facades\Broadcast;



    // Broadcast::presence('chat.{chat}', function ($user, Chat $chat) {
    //     return true;
    // });

    Broadcast::channel('chat.{chat}', function ($user, int $chat) {
        return $user->chats()->where('chats.id', $chat)->exists();
    });
