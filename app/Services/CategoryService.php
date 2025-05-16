<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Company;

class CategoryService
{
    public function index()
    {
        $query = Category::query();

        if ($limit = request('limit')) {
            $query->limit($limit);
        }

        return $query->get();
    }

}
