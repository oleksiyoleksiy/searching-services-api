<?php

namespace App\Services;

use App\Models\Company;
use App\Models\CompanyAvailability;
use Carbon\Carbon;

class CompanyAvailabilityService
{
    public function index(int $company)
    {
        $query = CompanyAvailability::where('company_id', $company);

        if ($date = request('date')) {
            $weekday = Carbon::parse($date)->dayOfWeek;
            $query->where('weekday', $weekday);
        }

        $availability = $query->first();

        if (!$availability) {
            return [];
        }

        $start = Carbon::parse($availability->start);
        $end = Carbon::parse($availability->end);

        $timeSlots = [];

        while ($start < $end) {
            $timeSlots[] = $start->format('H:i');
            $start->addHour();
        }

        return $timeSlots;
    }
}
