<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\CompanyResource;
use App\Models\Category;
use App\Services\ProviderService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryProviderController extends Controller
{
    public function __construct(private ProviderService $service) {
    }

    public function index(Category $category)
    {
        return response()->json([
            'category' => CategoryResource::make($category),
            'providers' => CompanyResource::collection($this->service->indexByCategory($category))
        ], Response::HTTP_OK);
    }
}
