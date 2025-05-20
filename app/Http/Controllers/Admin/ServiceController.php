<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Service\ServiceRequest;
use App\Http\Resources\Admin\Service\ServiceCollection;
use App\Models\Service;
use App\Services\Admin\ServiceService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct(private ServiceService $service) {}

    public function index()
    {
        return ServiceCollection::make($this->service->index());
    }

    public function store(ServiceRequest $request)
    {
        $data = $request->validated();

        $this->service->store($data);

        return $this->index();
    }

    public function update(ServiceRequest $request, int $service)
    {
        $service = Service::findOrFail($service);

        $data = $request->validated();

        $this->service->update($data, $service);

        return $this->index();
    }

    public function destroy(int $service)
    {
        $service = Service::findOrFail($service);

        $service->delete();

        return $this->index();
    }
}
