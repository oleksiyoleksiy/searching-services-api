<?php

namespace App\Services\Provider;

class ServiceService
{
    public function index()
    {
        return auth()->user()->company->services()
            ->orderbyDesc('created_at')
            ->get();
    }

    public function store(array $data)
    {
        return auth()->user()->company->services()->create($data);
    }

    public function update(array $data, int $service)
    {
        $service = auth()->user()->company->services()->findOrFail($service);

        $service->update($data);

        return $service->refresh();
    }

    public function destroy(int $service)
    {
        $service = auth()->user()->company->services()->findOrFail($service);

        $service->delete();
    }

}
