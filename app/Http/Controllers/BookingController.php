<?php

namespace App\Http\Controllers;

use App\Http\Requests\Booking\BookingRequest;
use App\Http\Resources\BookingResource;
use App\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct(private BookingService $service) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return BookingResource::collection($this->service->index());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(int $service, BookingRequest $request)
    {
        $data = $request->validated();

        $this->service->store($service, $data);

        return response()->json([
            'message' => 'booking created successfully',
        ]);
    }

    public function cancel(int $booking)
    {
        $this->service->cancel($booking);

        return response()->json([
            'message' => 'booking canceled successfully',
        ]);
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
