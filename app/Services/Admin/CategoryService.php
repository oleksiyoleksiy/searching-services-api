<?php

namespace App\Services\Admin;

use App\Models\Category;

class CategoryService
{
    public function index()
    {
        $query = Category::orderByDesc('created_at');

        if ($search = request('search')) {
            $query->where('name', 'LIKE', "%$search%");
        }

        return $query->paginate(15);
    }

    public function store(array $data)
    {
        Category::create($data);
    }

    public function update(array $data, Category $category)
    {
        $category->update($data);
    }
}
