<?php

namespace App\Services\Provider;

class ReviewService
{
    public function index()
    {
        return auth()->user()->company->reviews()
            ->with(['user'])
            ->orderbyDesc('created_at')
            ->get();
    }
}
