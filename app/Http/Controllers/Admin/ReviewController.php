<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Review\ReviewCollection;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Services\Admin\ReviewService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct(private ReviewService $service) {}

    public function index()
    {
        return ReviewCollection::make($this->service->index());
    }

    public function destroy(int $review)
    {
        $review = Review::findOrFail($review);

        $review->delete();

        return $this->index();
    }
}
