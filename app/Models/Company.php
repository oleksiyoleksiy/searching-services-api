<?php

namespace App\Models;

use App\Traits\FileTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use FileTrait;

    protected $table = 'companies';

    protected $fillable = [
        'name',
        'user_id',
        'years_of_experience'
    ];

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
}
