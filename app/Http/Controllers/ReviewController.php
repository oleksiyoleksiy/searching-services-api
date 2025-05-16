<?php

namespace App\Http\Controllers;

use App\Http\Requests\Review\ReviewRequest;
use App\Http\Resources\CompanyShowResource;
use App\Models\Company;
use App\Services\ReviewService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct(private ReviewService $service) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Company $company, ReviewRequest $request)
    {
        $data = $request->validated();

        return CompanyShowResource::make($this->service->store($company, $data));
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
