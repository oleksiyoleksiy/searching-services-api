<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChatResource;
use App\Services\ChatService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct(private ChatService $service) {
    }

    public function index()
    {
        return ChatResource::collection($this->service->index());
    }
}
