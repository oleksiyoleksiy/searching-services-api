<?php

namespace App\Services;

use App\Models\Company;

class FavoriteService
{
    public function index()
    {
        return Company::whereHas('favorites', fn($q) => $q->where('user_id', auth()->id()))->get();
    }

    public function store(int $company)
    {
        $favorites = auth()->user()->favorites();
        $query = $favorites->where('company_id', $company);

        $query->exists()
            ? $query->delete()
            : $favorites->create(['company_id' => $company]);
    }
}
