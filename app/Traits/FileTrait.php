<?php

namespace App\Traits;

use App\Models\File;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Storage;

trait FileTrait
{
    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'object');
    }

    public function filesByType(string $type)
    {

        return $this->files()->where('type', $type);
    }
}
