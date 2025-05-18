<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\ServiceRequest;
use App\Http\Resources\ProviderServiceResource;
use App\Http\Resources\ServiceResource;
use App\Services\Provider\ServiceService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct(private ServiceService $service) {
    }

    public function index()
    {
        return ProviderServiceResource::collection($this->service->index());
    }

    public function store(ServiceRequest $request)
    {
        $data = $request->validated();

        return ProviderServiceResource::make($this->service->store($data));
    }

    public function update(ServiceRequest $request, int $service)
    {
        $data = $request->validated();

        return ProviderServiceResource::make($this->service->update($data, $service));
    }

    public function destroy(int $service)
    {
        $this->service->destroy($service);

        return response()->noContent();
    }
}
