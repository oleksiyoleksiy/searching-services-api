<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private UserService $service) {
    }

    public function current()
    {
        return UserResource::make(auth()->user());
    }

    public function update(UpdateRequest $request)
    {
        $data = $request->validated();

        return UserResource::make($this->service->update($data));
    }
}
