<?php

namespace App\Services\Provider;

use App\Enums\BookingStatusEnum;

class StatsService
{
    public function __construct(private BookingService $bookingService) {}

    public function index()
    {
        $query = $this->bookingService->providerBookings();

        return [
            'requests' => $query->where('status', BookingStatusEnum::PENDING->value)->count(),
            'active_bookings' => $query->where('status', BookingStatusEnum::UPCOMING->value)->count(),
            'completed' => $query->where('status', BookingStatusEnum::COMPLETED->value)->count(),
            'reviews' => auth()->user()->company->reviews()->count(),
        ];
    }
}
