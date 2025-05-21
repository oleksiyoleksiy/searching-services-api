<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Http\Requests\Provider\Company\CompanyRequest;
use App\Http\Resources\Provider\Company\CompanyResource;
use App\Http\Resources\UserResource;
use App\Services\Provider\CompanyService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct(private CompanyService $service) {}

    public function index()
    {
        return CompanyResource::make(auth()->user()->company);
    }

    public function update(CompanyRequest $request)
    {
        $data = $request->validated();

        $this->service->update($data);

        return $this->index();
    }
}
