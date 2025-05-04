<?php

namespace App\Traits;

use App\Models\File;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

trait FileTrait
{
    public function files(): HasMany
    {
        return $this->hasMany(File::class, 'object_id')
            ->where('object', class_basename($this));
    }

    public function filesByType(string $type)
    {
        return $this->files()->where('type', $type);
    }
}
