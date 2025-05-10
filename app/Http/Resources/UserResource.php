<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'roles' => RoleResource::collection($this->roles),
            'avatar' => $this->filesByType('avatar')->first()?->getURL() ?? "https://ui-avatars.com/api/?name=$this->name",
            'created_at' => $this->created_at->format('Y.m.d'),
        ];
    }
}
