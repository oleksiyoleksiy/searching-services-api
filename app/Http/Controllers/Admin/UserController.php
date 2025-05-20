<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreRequest;
use App\Http\Requests\Admin\User\UpdateRequest;
use App\Http\Requests\Admin\User\UserRequest;
use App\Http\Resources\Admin\User\UserCollection;
use App\Http\Resources\Admin\User\UserResource;
use App\Models\User;
use App\Services\Admin\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private UserService $service) {
    }

    public function index()
    {
        return UserCollection::make($this->service->index());
    }

    public function show(int $user)
    {
        $user = User::findOrFail($user);

        return UserResource::make($user);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $this->service->store($data);

        return $this->index();
    }

    public function update(UpdateRequest $request, int $user)
    {
        $user = User::findOrFail($user);

        $data = $request->validated();

        $this->service->update($data, $user);

        return $this->index();
    }
}
