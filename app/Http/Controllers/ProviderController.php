<?php

namespace App\Http\Controllers;

use App\Http\Requests\Provider\UpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\CompanyShowResource;
use App\Http\Resources\UserResource;
use App\Models\Category;
use App\Models\Company;
use App\Services\ProviderService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProviderController extends Controller
{
    public function __construct(private ProviderService $service) {}

    public function index()
    {
        return CompanyResource::collection($this->service->index());
    }

    public function show(Company $company)
    {
        return CompanyShowResource::make($this->service->show($company));
    }

    public function update(UpdateRequest $request)
    {
        $data = $request->validated();

        return UserResource::make($this->service->update($data));
    }
}
