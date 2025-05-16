<?php

namespace App\Enums;

enum BookingStatusEnum: string
{
    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
    case CANCELLED = 'cancelled';
    case REJECTED = 'rejected';
    case COMPLETED = 'completed';
    case NO_SHOW = 'no_show';
}
