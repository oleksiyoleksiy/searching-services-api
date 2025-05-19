<?php

namespace App\Services;

class ChatService
{
    public function index()
    {
        return auth()->user()->chats;
    }
}
