<?php

namespace App\Services;

class MessageService
{
    public function index(int $chat)
    {
        return $this->getChat($chat)?->messages;
    }

    private function getChat(int $chat) {
        return auth()->user()->chats()->where('id', $chat)->first();
    }

    public function store(array $data, int $chat)
    {
        return $this->getChat($chat)?->messages()->create($data);
    }
}
