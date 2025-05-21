<?php

namespace App\Http\Resources\Provider\Company;

use App\Http\Resources\ImageResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'user' => UserResource::make($this->user),
            'preview' => $this->filesByType('preview')->first()?->getURL(),
            'gallery' => ImageResource::collection($this->filesByType('gallery')->get()),
            'availabilities' => AvailabilityResource::collection($this->availabilities)
        ];
    }
}
