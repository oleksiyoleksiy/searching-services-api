<?php

namespace App\Services\Admin;

use App\Models\Service;

class ServiceService
{
    public function index()
    {
        $query = Service::query();

        if ($search = request('search')) {
            $query->where('name', 'LIKE', "%$search%");
        }

        return $query->paginate(10);
    }

    public function update(array $data, Service $service)
    {
        $service->update($data);
    }

    public function store(array $data)
    {
        Service::create($data);
    }
}
