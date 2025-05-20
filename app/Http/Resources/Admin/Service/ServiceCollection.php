<?php

namespace App\Http\Resources\Admin\Service;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ServiceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $res = [];

        foreach ($this->collection as $service) {
            $res[] = ServiceResource::make($service);
        }

        return [
            'services' => $res,
            'total_services' => Service::count(),
        ];
    }
}
