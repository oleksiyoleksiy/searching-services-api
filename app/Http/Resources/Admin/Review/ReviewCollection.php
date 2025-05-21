<?php

namespace App\Http\Resources\Admin\Review;

use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ReviewCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $res = [];

        foreach ($this->collection as $review) {
            $res[] = ReviewResource::make($review);
        }

        return [
            'reviews' => $res,
            'total_reviews' => Review::count(),
        ];
    }
}
