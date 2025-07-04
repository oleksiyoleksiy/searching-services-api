<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderBookingResource extends JsonResource
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
            'service' => $this->service->name,
            'client' => $this->user->name,
            'date' => $this->date,
            'start_time' => Carbon::parse($this->start_time)->format('H:i'),
            'price' => $this->service->price,
            'status' => $this->status,
        ];
    }
}
