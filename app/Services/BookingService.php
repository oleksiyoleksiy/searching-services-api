<?php

namespace App\Services;

use App\Enums\BookingStatusEnum;
use App\Models\Booking;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

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

    public function store(Service $service, array $data)
    {
        if ($service->is_owner) {
            throw ValidationException::withMessages([
                'you can not book your own service'
            ]);
        }

        $data['service_id'] = $service->id;

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
