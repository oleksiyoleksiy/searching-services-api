<?php

namespace App\Http\Controllers;

use App\Http\Requests\Message\MessageRequest;
use App\Http\Resources\MessageResource;
use App\Services\MessageService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct(private MessageService $service) {
    }

    public function index(int $chat)
    {
        return MessageResource::collection($this->service->index($chat));
    }

    public function store(MessageRequest $request, int $chat)
    {
        $data = $request->validated();

        return MessageResource::make($this->service->store($data, $chat));
    }
}
