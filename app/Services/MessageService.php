<?php

namespace App\Services;

use App\Events\MessageSentEvent;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class MessageService
{
    public function index(int $chat)
    {
        $messages = Message::where('chat_id', $chat)
            ->orderBy('created_at')
            ->get();

        $grouped = $messages->groupBy(function ($message) {
            return $message->created_at->format('d M Y');
        });

        $result = [];

        foreach ($grouped as $date => $group) {
            $result[] = [
                'date' => $date,
                'messages' => MessageResource::collection($group),
            ];
        }

        return $result;
    }



    private function getChat(int $chat)
    {
        return auth()->user()->chats()->where('chats.id', $chat);
    }

    public function store(array $data, int $chat)
    {
        if (!$this->getChat($chat)->exists()) {
            throw ValidationException::withMessages([
                'message' => "You don't belong to this chat"
            ]);
        }

        $data['chat_id'] = $chat;

        $message = auth()->user()->messages()->create($data);

        $groupKey = $message->created_at->format('d M Y');

        broadcast(new MessageSentEvent($message))->toOthers();

        return [
            'date' => $groupKey,
            'message' => MessageResource::make($message),
        ];
    }
}
