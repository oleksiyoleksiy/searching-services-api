<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Services\Provider\ReviewService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct(private ReviewService $service) {
    }
    public function index()
    {
        return ReviewResource::collection($this->service->index());
    }
}
