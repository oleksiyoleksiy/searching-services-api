<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CompanyShowResource extends JsonResource
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
            'user' => UserResource::make($this->user),
            'availability' => $this->availability,
            'availabilities' => AvailabilityResource::collection($this->availabilities),
            'gallery' => $this->filesByType('gallery')->get()->map(fn($file) => $file->getURL()),
            'price' => $this->services()->min('price'),
            'reviews' => ReviewResource::collection($this->reviews()->orderByDesc('created_at')->get()),
            'services' => ServiceResource::collection($this->services),
            'is_favorite' => $this->is_favorite,
            'is_owner' => $this->is_owner
        ];
    }
}
