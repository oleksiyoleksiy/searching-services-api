<?php

namespace App\Http\Resources\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $res = [];

        foreach($this->collection as $user) {
            $res[] = UserResource::make($user);
        }

        return [
            'users' => $res,
            'total_users' => User::count(),
            'new_this_month' => User::havingRaw('MONTH(created_at) = MONTH(NOW())')->count()
        ];
    }
}
