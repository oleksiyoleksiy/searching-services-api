<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\CategoryRequest;
use App\Http\Resources\Admin\Category\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\Admin\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $service) {
    }

    public function index()
    {
        return CategoryCollection::make($this->service->index());
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->validated();

        $this->service->store($data);

        return $this->index();
    }

    public function update(CategoryRequest $request, int $category)
    {
        $category = Category::findOrFail($category);

        $data = $request->validated();

        $this->service->update($data, $category);

        return $this->index();
    }

    public function destroy(int $category)
    {
        $category = Category::findOrFail($category);

        $category->delete();

        return $this->index();
    }
}
