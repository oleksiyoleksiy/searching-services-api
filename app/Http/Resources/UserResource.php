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
        $avatar = $this->filesByType('avatar')->first()?->getURL();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'address' => $this->address,
            'bio' => $this->bio,
            'roles' => RoleResource::collection($this->roles),
            'is_have_avatar' => $avatar !== null,
            'avatar' => $avatar ?? "https://ui-avatars.com/api/?name=$this->name",
            'phone_number' => $this->phone_number,
            'postal_code' => $this->postal_code,
            'created_at' => $this->created_at->format('d M Y'),
            'company' => CompanyResource::make($this->company)
        ];
    }
}
