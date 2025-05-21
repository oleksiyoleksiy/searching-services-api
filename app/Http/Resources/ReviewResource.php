<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'company' => $this->company->name,
            'user' => UserResource::make($this->user),
            'rating' => $this->rating,
            'content' => $this->content,
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
