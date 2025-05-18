<?php

namespace App\Services\Provider;

use App\Enums\BookingStatusEnum;
use App\Models\Booking;

class BookingService
{
    public function index()
    {
        return $this->providerBookings()->get();
    }

    public function providerBookings()
    {
        return Booking::whereHas('service', function ($query) {
            $query->whereIn('id', auth()->user()->company->services->pluck('id'));
        });
    }

    public function changeStatus(int $booking, BookingStatusEnum $status)
    {
        $booking = $this->providerBookings()->findOrFail($booking);

        $booking->update(['status' => $status->value]);

        return $booking->refresh();
    }
}
