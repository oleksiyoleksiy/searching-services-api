<?php

namespace App\Services;

use App\Http\Requests\Review\ReviewRequest;
use App\Models\Company;

class ReviewService
{
    public function store(Company $company, array $data)
    {
        $data['company_id'] = $company->id;

        auth()->user()->reviews()->create($data);

        return $company->fresh()->load(['reviews', 'categories', 'services']);
    }
}
