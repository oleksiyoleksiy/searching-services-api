<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function index()
    {
        return Category::all();
    }

    public function show(int $category)
    {
        $query = Category::query();

        $search = request()->query('search');
        // $distance = request()->query('distance');
        $search = request()->query('search');
        $search = request()->query('search');


    }
}
