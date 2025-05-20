<?php

namespace App\Http\Resources\Admin\User;

use App\Http\Resources\RoleResource;
use App\Models\User;
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
        $avatar = $this->filesByType('avatar')->first()?->getURL();

        return [
            'id' => $this->id,
            'avatar' => $avatar ?? "https://ui-avatars.com/api/?name=$this->name",
            'phone_number' => $this->phone_number,
            'postal_code' => $this->postal_code,
            'address' => $this->address,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at->format('d.m.Y'),
            'roles' => RoleResource::collection($this->roles),
            'bio' => $this->bio,
            'is_have_avatar' => $avatar !== null,
        ];
    }
}
