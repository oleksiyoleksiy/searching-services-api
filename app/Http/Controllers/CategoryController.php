<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryShowResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $service) {}

    public function index()
    {
        return CategoryResource::collection($this->service->index());
    }

    public function show(int $category)
    {
        return CategoryShowResource::make($this->service->show($category));
    }
}
