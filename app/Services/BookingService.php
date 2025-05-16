<?php

namespace App\Services;

use Carbon\Carbon;

class BookingService
{
    public function store(int $service, array $data)
    {
        $data['service_id'] = $service;

        $data['date'] = Carbon::parse($data['date']);

        $data['end_time'] = Carbon::parse($data['start_time'])
            ->addHour()
            ->format('H:i');


        auth()->user()->bookings()->create($data);
    }
}
