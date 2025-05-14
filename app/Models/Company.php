<?php

namespace App\Models;

use App\Traits\FileTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use FileTrait;

    protected $table = 'companies';

    protected $fillable = [
        'name',
        'user_id',
        'years_of_experience',
        'description'
    ];

    public function getAvailabilityAttribute()
    {
        $now = Carbon::now();
        $currentDay = $now->format('l');
        $currentTime = $now->format('H:i');

        $todayAvailable = $this->availabilities()
            ->where('day', $currentDay)
            ->where('start', '<=', $currentTime)
            ->where('end', '>=', $currentTime)
            ->first();

        if ($todayAvailable) {
            return 'today up to ' . $todayAvailable->end;
        }

        $daysOfWeek = [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday'
        ];

        $currentIndex = array_search($currentDay, $daysOfWeek);
        for ($i = 1; $i <= 7; $i++) {
            $nextDay = $daysOfWeek[($currentIndex + $i) % 7];

            $nextAvailability = $this->availabilities()
                ->where('day', $nextDay)
                ->orderBy('start')
                ->first();

            if ($nextAvailability) {
                return $nextDay . ' ' . substr($nextAvailability->start, 0, 5); 
            }
        }

        return '';
    }

    public function getRatingAttribute()
    {
        return $this->reviews()->avg('rating');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function availabilities(): HasMany
    {
        return $this->hasMany(CompanyAvailability::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}
