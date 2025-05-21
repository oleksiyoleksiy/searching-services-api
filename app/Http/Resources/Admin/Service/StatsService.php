<?php

namespace App\Http\Resources\Admin\Service;

use App\Enums\BookingStatusEnum;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;

class StatsService
{
    public function index()
    {
        return [
            'total_users' => User::count(),
            'total_services' => Service::count(),
            'total_bookings' => Booking::count(),
            'revenue' => Booking::query()
                ->where('status', BookingStatusEnum::COMPLETED->value)
                ->join('services', 'bookings.service_id', '=', 'services.id')
                ->sum('services.price')
        ];
    }
}
