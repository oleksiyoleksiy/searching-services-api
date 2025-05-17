<?php

namespace App\Services;

use App\Enums\BookingStatusEnum;
use App\Models\Booking;
use Carbon\Carbon;

class BookingService
{
    public function index()
    {
        $query = auth()->user()->bookings()
            ->with(['service', 'service.company']);

            if ($status = request('status')) {
                $query->where('status', BookingStatusEnum::tryFrom($status));
            }
            
            if ($limit = request('limit')) {
                $query->limit($limit);
            }

        return $query->orderbyDesc('created_at')->get();
    }

    public function store(int $service, array $data)
    {
        $data['service_id'] = $service;

        $data['date'] = Carbon::parse($data['date']);

        $data['end_time'] = Carbon::parse($data['start_time'])
            ->addHour()
            ->format('H:i');


        auth()->user()->bookings()->create($data);
    }

    public function cancel(int $booking)
    {
        auth()->user()->bookings()
            ->where('id', $booking)
            ->update(['status' => BookingStatusEnum::CANCELLED->value]);
    }
}
