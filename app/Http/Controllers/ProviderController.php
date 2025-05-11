<?php

namespace App\Http\Controllers;

use App\Http\Requests\Provider\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Services\ProviderService;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function __construct(private ProviderService $service) {}

    public function update(UpdateRequest $request)
    {
        $data = $request->validated();

        return UserResource::make($this->service->update($data));
    }
}
