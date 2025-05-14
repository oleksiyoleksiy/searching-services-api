<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Company;

class CategoryService
{
    public function index()
    {
        return Category::all();
    }

}
