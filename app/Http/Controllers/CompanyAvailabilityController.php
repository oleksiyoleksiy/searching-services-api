<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Services\CompanyAvailabilityService;
use Illuminate\Http\Request;

class CompanyAvailabilityController extends Controller
{
    public function __construct(private CompanyAvailabilityService $service) {}

    /**
     * Display a listing of the resource.
     */
    public function index(int $company)
    {
        return response()->json(
            $this->service->index($company)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
