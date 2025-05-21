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
        $currentWeekday = $now->dayOfWeek; // 0 (неділя) до 6 (субота)
        $currentTime = $now->format('H:i');

        $todayAvailable = $this->availabilities()
            ->where('weekday', $currentWeekday)
            ->where('start', '<=', $currentTime)
            ->where('end', '>=', $currentTime)
            ->first();

        if ($todayAvailable) {
            return 'today up to ' . substr($todayAvailable->end, 0, 5);
        }

        for ($i = 1; $i <= 7; $i++) {
            $nextWeekday = ($currentWeekday + $i) % 7;

            $nextAvailability = $this->availabilities()
                ->where('weekday', $nextWeekday)
                ->orderBy('start')
                ->first();

            if ($nextAvailability) {
                $dayName = Carbon::create()->startOfWeek()->addDays($nextWeekday)->format('l');
                return $dayName . ' ' . substr($nextAvailability->start, 0, 5);
            }
        }

        return '';
    }


    public function getRatingAttribute()
    {
        return number_format($this->reviews()->avg('rating'), 1);
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

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function getIsFavoriteAttribute()
    {
        return $this->favorites()->where('user_id', auth()->id())
            ->exists();
    }

    public function getIsOwnerAttribute(): bool
    {
        if(!auth()->check()) return false;

        return $this->company?->user->id === auth()->id();
    }
}
