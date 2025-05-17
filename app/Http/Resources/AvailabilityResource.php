<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AvailabilityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'weekday' => Carbon::create()->weekday($this->weekday)->format('l'),
            'start' => Carbon::parse($this->start)->format('H:i'),
            'end' => Carbon::parse($this->end)->format('H:i'),
        ];
    }
}
