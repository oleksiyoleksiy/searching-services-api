<?php

namespace App\Services\Provider;

use App\Enums\BookingStatusEnum;
use App\Models\Booking;
use App\Models\Chat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class BookingService
{
    public function index()
    {
        return $this->providerBookings()->get();
    }

    public function providerBookings()
    {
        return Booking::whereIn('service_id', auth()->user()->company->services->pluck('id'));
    }

    public function changeStatus(int $bookingId, BookingStatusEnum $status)
    {
        return DB::transaction(function () use ($bookingId, $status) {
            $booking = $this->providerBookings()->findOrFail($bookingId);
            $booking->update(['status' => $status->value]);

            if ($status->isUpcoming()) {
                $interlocutorId = $booking->user_id;

                if (!$this->chatExistsWith($interlocutorId)) {
                    $chat = auth()->user()->chats()->create();
                    $chat->users()->attach($interlocutorId);
                }
            }

            return $booking->refresh();
        });
    }

    private function chatExistsWith(int $interlocutorId): bool
    {
        return auth()->user()->chats()
            ->whereHas('users', fn($q) => $q->where('users.id', $interlocutorId))
            ->exists();
    }
}
