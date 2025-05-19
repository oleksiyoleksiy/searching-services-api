<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
            'name' => $this->name,
            'rating' => $this->rating,
            'categories' => CategoryResource::collection($this->categories),
            'years_of_experience' => $this->years_of_experience,
            'description' => $this->description,
            'reviews_count' => $this->reviews()->count(),
            'image' => $this->filesByType('preview')->first()?->getURL() ?? Storage::url('/images/no-image.png'),
            'address' => $this->user->address,
            'postal_code' => $this->user->postal_code,
            'availability' => $this->availability,
            'price' => $this->services()->min('price'),
            'is_owner' => $this->is_owner
        ];
    }
}
