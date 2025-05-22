<?php

namespace App\Http\Resources\Admin\Category;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
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
            $res[] = CategoryResource::make($review);
        }

        return [
            'categories' => $res,
            'total_categories' => Category::count(),
        ];
    }
}
