<?php

namespace App\Services;

class FavoriteService
{
    public function store(int $company)
    {
        $favorites = auth()->user()->favorites();
        $query = $favorites->where('company_id', $company);

        $query->exists()
            ? $query->delete()
            : $favorites->create(['company_id' => $company]);
    }
}
