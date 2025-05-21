<?php

namespace App\Services\Admin;

use App\Models\Review;

class ReviewService
{
    public function index()
    {
        return Review::paginate(10);
    }
}
