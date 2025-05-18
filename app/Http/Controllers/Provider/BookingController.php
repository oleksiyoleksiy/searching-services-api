<?php

namespace App\Http\Controllers\Provider;

use App\Enums\BookingStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProviderBookingResource;
use App\Services\Provider\BookingService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function __construct(private BookingService $service) {}

    public function index()
    {
        return ProviderBookingResource::collection($this->service->index());
    }

    public function changeStatus(int $booking, string $status)
    {
        $status = BookingStatusEnum::tryFrom($status);

        if (!$status) {
            throw ValidationException::withMessages([
                'status' => 'invalid status'
            ]);
        }

        return ProviderBookingResource::make($this->service->changeStatus($booking, $status));
    }
}
