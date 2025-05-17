<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyResource;
use App\Services\FavoriteService;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function __construct(private FavoriteService $service) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CompanyResource::collection($this->service->index());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(int $company, Request $request) {
        $this->service->store($company);

        return response()->json(['message' => 'favorite toggled successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
